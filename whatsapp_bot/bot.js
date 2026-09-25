import * as baileysModule from '@whiskeysockets/baileys';
import pino from 'pino';

const baileys = baileysModule.default || baileysModule;
const makeWASocket = baileysModule.makeWASocket || (baileys.default ? baileys.default.makeWASocket : null) || baileys.makeWASocket || baileysModule.default || baileys;
const useMultiFileAuthState = baileysModule.useMultiFileAuthState || (baileys.default ? baileys.default.useMultiFileAuthState : null) || baileys.useMultiFileAuthState;
const DisconnectReason = baileysModule.DisconnectReason || (baileys.default ? baileys.default.DisconnectReason : null) || baileys.DisconnectReason;
const downloadMediaMessage = baileysModule.downloadMediaMessage || (baileys.default ? baileys.default.downloadMediaMessage : null) || baileys.downloadMediaMessage;
const fetchLatestBaileysVersion = baileysModule.fetchLatestBaileysVersion || (baileys.default ? baileys.default.fetchLatestBaileysVersion : null) || baileys.fetchLatestBaileysVersion;

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { exec } from 'child_process';
import qrcodeTerminal from 'qrcode-terminal';
import QRCode from 'qrcode';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Cargar configuración
const configPath = path.join(__dirname, 'config.json');
const config = JSON.parse(fs.readFileSync(configPath, 'utf8'));

const CARPETA_SALIDA = path.resolve(__dirname, config.carpeta_salida);
const AUTH_DIR = path.join(__dirname, 'auth_info_baileys');
const QR_HTML_PATH = path.join(__dirname, 'qr.html');

if (process.argv.includes('--reset')) {
    console.log('🧹 Limpiando sesión previa para empezar desde cero...');
    if (fs.existsSync(AUTH_DIR)) fs.rmSync(AUTH_DIR, { recursive: true, force: true });
    if (fs.existsSync(QR_HTML_PATH)) fs.unlinkSync(QR_HTML_PATH);
}

if (!fs.existsSync(CARPETA_SALIDA)) {
    fs.mkdirSync(CARPETA_SALIDA, { recursive: true });
}

console.log('====================================================');
console.log('🤖 INICIANDO BOT DE AUDITORIA WHATSAPP - JOKER POS');
console.log('📁 Carpeta destino de fotos:', CARPETA_SALIDA);
console.log('====================================================');

// Mapa dinámico de JIDs a sucursal
let grupoMap = new Map(); // jid -> { nombre, sucursal, codsucursal }

function limpiarTexto(str) {
    if (!str) return '';
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

function identificarGrupo(chatName) {
    if (!chatName) return null;
    const cleanChat = limpiarTexto(chatName);

    for (const g of config.grupos) {
        if (limpiarTexto(g.nombre) === cleanChat) return g;
        for (const alias of g.aliases) {
            if (cleanChat.includes(limpiarTexto(alias))) {
                return g;
            }
        }
    }
    return null;
}

function clasificarFoto(caption) {
    if (!caption) return 'FOTO_GENERAL';
    const text = limpiarTexto(caption);

    if (text.includes('planilla') || text.includes('mesa') || text.includes('producto') || text.includes('comanda')) {
        return 'PLANILLA_CIERRE';
    }
    if (text.includes('arqueo') || text.includes('cierre') || text.includes('sobre') || text.includes('efectivo') || text.includes('caja chica')) {
        return 'PAPELITO_ARQUEO';
    }
    if (text.includes('ingreso') || text.includes('compra') || text.includes('factura') || text.includes('nota') || text.includes('llego') || text.includes('pedido') || text.includes('cerveza')) {
        return 'INGRESO_MERCADERIA';
    }
    if (text.includes('gasto') || text.includes('recibo') || text.includes('taxi') || text.includes('limon') || text.includes('hielo')) {
        return 'GASTO_MENOR';
    }
    return 'FOTO_GENERAL';
}

async function procesarMensajeImagen(sock, msg, infoGrupo) {
    try {
        let m = msg.message;
        if (m?.viewOnceMessage?.message) {
            m = m.viewOnceMessage.message;
        } else if (m?.viewOnceMessageV2?.message) {
            m = m.viewOnceMessageV2.message;
        }

        const isImage = !!m?.imageMessage;
        const isDocImage = m?.documentMessage?.mimetype?.startsWith('image/');

        if (!isImage && !isDocImage) return;

        const imgMsg = isImage ? m.imageMessage : m.documentMessage;
        const caption = imgMsg.caption || '';
        const timestamp = (msg.messageTimestamp ? Number(msg.messageTimestamp) * 1000 : Date.now());
        const dateObj = new Date(timestamp);

        const fechaStr = dateObj.toISOString().slice(0, 10); // YYYY-MM-DD
        const horaStr = dateObj.toTimeString().slice(0, 8).replace(/:/g, '-'); // HH-mm-ss
        const remitente = msg.pushName ? msg.pushName.replace(/[^a-zA-Z0-9_-]/g, '_') : 'cajero';
        const tipoClasif = clasificarFoto(caption);

        // Directorio: auditoria_fotos/YYYY-MM-DD/SUCURSAL/
        const dirDiaSucursal = path.join(CARPETA_SALIDA, fechaStr, infoGrupo.sucursal);
        if (!fs.existsSync(dirDiaSucursal)) {
            fs.mkdirSync(dirDiaSucursal, { recursive: true });
        }

        const msgId = msg.key.id || Date.now().toString();
        const extension = isImage ? '.jpg' : path.extname(imgMsg.fileName || '.jpg') || '.jpg';
        const nombreArchivo = `${horaStr}_${tipoClasif}_${remitente}_${msgId.slice(-6)}${extension}`;
        const rutaFinal = path.join(dirDiaSucursal, nombreArchivo);

        if (fs.existsSync(rutaFinal)) {
            return; // Ya fue descargada
        }

        console.log(`📥 Descargando imagen de [${infoGrupo.sucursal}] de ${remitente} (${fechaStr} ${horaStr})...`);
        const buffer = await downloadMediaMessage(
            msg,
            'buffer',
            {},
            {
                logger: pino({ level: 'silent' }),
                reuploadRequest: sock.updateMediaMessage
            }
        );

        fs.writeFileSync(rutaFinal, buffer);
        console.log(`✅ Guardada exitosamente: ${nombreArchivo} [${tipoClasif}]`);

        // Registrar metadatos
        const metaPath = path.join(dirDiaSucursal, 'registro_fotos.json');
        let lista = [];
        if (fs.existsSync(metaPath)) {
            try {
                lista = JSON.parse(fs.readFileSync(metaPath, 'utf8'));
            } catch (e) {
                lista = [];
            }
        }

        lista.push({
            id: msgId,
            archivo: nombreArchivo,
            fecha: fechaStr,
            hora: horaStr,
            timestamp: timestamp,
            remitente: msg.pushName || 'Desconocido',
            remitente_num: msg.key.participant || msg.key.remoteJid,
            caption: caption,
            clasificacion: tipoClasif,
            sucursal: infoGrupo.sucursal,
            codsucursal: infoGrupo.codsucursal,
            grupo_nombre: infoGrupo.nombre
        });

        fs.writeFileSync(metaPath, JSON.stringify(lista, null, 2), 'utf8');

    } catch (err) {
        console.error('❌ Error al procesar imagen:', err.message);
    }
}

async function iniciarBot() {
    const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);
    const { version, isLatest } = await fetchLatestBaileysVersion();
    console.log(`Usando versión Baileys: v${version.join('.')}, más reciente: ${isLatest}`);

    const sock = makeWASocket({
        version,
        logger: pino({ level: 'silent' }),
        printQRInTerminal: false,
        auth: state,
        browser: ['Ubuntu', 'Chrome', '20.0.04'],
        syncFullHistory: false,
        connectTimeoutMs: 60000,
        defaultQueryTimeoutMs: undefined,
        keepAliveIntervalMs: 30000,
        generateHighQualityLinkPreview: false
    });

    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (connection) {
            console.log(`📡 Estado de conexión: ${connection}`);
        }

        if (qr) {
            console.log('\n======================================================');
            console.log('📲 CÓDIGO QR GENERADO. ESCANÉALO CON TU WHATSAPP:');
            console.log('======================================================\n');
            qrcodeTerminal.generate(qr, { small: true });

            // Generar HTML visual para abrirlo en el navegador
            try {
                const qrDataURL = await QRCode.toDataURL(qr, { width: 350 });
                const html = `<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="7">
    <title>Escanear QR WhatsApp - Joker POS</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #fff; text-align: center; padding: 40px; }
        .card { background: #1e293b; display: inline-block; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 1px solid #334155; }
        img { border-radius: 12px; background: white; padding: 12px; }
        h2 { color: #38bdf8; margin-top: 0; }
        ol { text-align: left; max-width: 320px; margin: 20px auto; color: #cbd5e1; line-height: 1.6; }
        .badge { background: #0284c7; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Auditoría Joker POS</span>
        <h2>🤖 Conectar WhatsApp de Auditoría</h2>
        <p>Abre WhatsApp en tu teléfono y escanea este código:</p>
        <img src="${qrDataURL}" alt="Código QR WhatsApp" />
        <ol>
            <li>Abre WhatsApp en tu teléfono</li>
            <li>Toca en <strong>Menú (tres puntos)</strong> o <strong>Configuración</strong></li>
            <li>Selecciona <strong>Dispositivos vinculados</strong></li>
            <li>Toca en <strong>Vincular un dispositivo</strong> y apunta tu cámara aquí</li>
        </ol>
        <p style="color: #94a3b8; font-size: 13px;">🔄 La página se actualiza automáticamente cada 7s si cambia el QR.</p>
    </div>
</body>
</html>`;
                fs.writeFileSync(QR_HTML_PATH, html, 'utf8');
                console.log(`🌐 También puedes abrir el QR en tu navegador aquí:`);
                console.log(`   file:///${QR_HTML_PATH.replace(/\\/g, '/')}\n`);

                // Abrir en el navegador si es la primera vez
                if (!global.browserOpened) {
                    global.browserOpened = true;
                    exec(`cmd /c start "" "${QR_HTML_PATH}"`);
                }
            } catch (err) {
                console.error('Error generando QR HTML:', err.message);
            }
        }

        if (connection === 'close') {
            const shouldReconnect = (lastDisconnect?.error)?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('Conexión cerrada por:', lastDisconnect?.error?.message, 'Reconectando:', shouldReconnect);
            if (shouldReconnect) {
                setTimeout(iniciarBot, 3000);
            } else {
                console.log('Sesión cerrada permanentemente. Borra la carpeta auth_info_baileys para volver a escanear.');
            }
        } else if (connection === 'open') {
            console.log('\n🎉 ¡CONEXIÓN EXITOSA CON WHATSAPP!');
            console.log('El bot está activo y escuchando los grupos de auditoría.\n');

            // Actualizar el HTML a estado conectado
            try {
                const connectedHtml = `<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WhatsApp Conectado - Joker POS</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #064e3b; color: #fff; text-align: center; padding: 50px; }
        .card { background: #065f46; display: inline-block; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.4); border: 1px solid #10b981; }
        h1 { color: #34d399; margin-top: 0; }
        p { color: #d1fae5; font-size: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>✅ ¡WhatsApp Vinculado con Éxito!</h1>
        <p>El bot de auditoría está conectado y monitoreando en segundo plano los 5 grupos de billar.</p>
        <p>Las fotos de planillas, sobres y arqueos se descargarán automáticamente a <code>pos/auditoria_fotos/</code>.</p>
    </div>
</body>
</html>`;
                fs.writeFileSync(QR_HTML_PATH, connectedHtml, 'utf8');
            } catch (e) {}

            // Descubrir y mapear grupos
            try {
                const chats = await sock.groupFetchAllParticipating();
                console.log('📋 GRUPOS ENCONTRADOS EN TU CUENTA:');
                console.log('----------------------------------------------------');
                for (const jid in chats) {
                    const c = chats[jid];
                    const match = identificarGrupo(c.subject);
                    if (match) {
                        grupoMap.set(jid, {
                            jid,
                            nombre: c.subject,
                            sucursal: match.sucursal,
                            codsucursal: match.codsucursal
                        });
                        console.log(`✅ [VINCULADO] "${c.subject}" ➡️ SUCURSAL: ${match.sucursal} (ID: ${match.codsucursal})`);
                    } else {
                        // console.log(`   [Otro] "${c.subject}"`);
                    }
                }
                console.log('----------------------------------------------------');
                console.log(`Total grupos de auditoría monitoreados: ${grupoMap.size} de 5`);
            } catch (e) {
                console.log('Aviso al listar grupos:', e.message);
            }
        }
    });

    sock.ev.on('creds.update', saveCreds);

    // Evento de recepción de mensajes nuevos
    sock.ev.on('messages.upsert', async ({ messages, type }) => {
        for (const msg of messages) {
            if (!msg.message) continue;
            const jid = msg.key.remoteJid;

            // Verificar si el chat está mapeado a un grupo de auditoría
            let infoGrupo = grupoMap.get(jid);
            if (!infoGrupo) {
                // Intentar buscar el nombre del grupo si no estaba en el mapa inicial
                continue;
            }

            // Procesar si contiene foto
            await procesarMensajeImagen(sock, msg, infoGrupo);
        }
    });

    // Evento de recepción de historial sincronizado (fotos pasadas)
    sock.ev.on('messaging-history.set', async ({ chats, messages }) => {
        console.log(`📥 Sincronizando historial inicial de WhatsApp (${messages.length} mensajes recibidos)...`);
        let fotosHistoricas = 0;
        for (const msg of messages) {
            if (!msg.message) continue;
            const jid = msg.key.remoteJid;
            const infoGrupo = grupoMap.get(jid);
            if (infoGrupo) {
                const m = msg.message;
                const isImage = !!m?.imageMessage || !!m?.documentMessage?.mimetype?.startsWith('image/') || !!m?.viewOnceMessage?.message?.imageMessage;
                if (isImage) {
                    await procesarMensajeImagen(sock, msg, infoGrupo);
                    fotosHistoricas++;
                }
            }
        }
        if (fotosHistoricas > 0) {
            console.log(`✨ Se procesaron ${fotosHistoricas} fotos del historial reciente.`);
        }
    });
}

process.on('uncaughtException', (err) => {
    console.error('⚠️ Excepción no capturada en bot:', err.message);
});

process.on('unhandledRejection', (reason, promise) => {
    console.error('⚠️ Promesa no capturada en bot:', reason);
});

iniciarBot().catch(err => console.error('Error fatal al iniciar bot:', err));
