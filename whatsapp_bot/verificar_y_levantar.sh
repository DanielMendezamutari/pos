#!/bin/bash
# ==============================================================================
# SCRIPT GUARDIÁN (WATCHDOG) - BOT WHATSAPP AUDITORÍA JOKER POS
# Se ejecuta vía Cron Job cada 5 o 10 minutos en cPanel.
# Si el proceso se cayó o el servidor se reinició, lo levanta automáticamente.
# ==============================================================================

# Directorio del bot en el servidor
BOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$BOT_DIR" || exit 1

# Verificar si bot.js está corriendo
PID=$(pgrep -f "bot.js" | head -n 1)

if [ -n "$PID" ]; then
    # El bot ya está corriendo normalmente
    # echo "Bot activo (PID: $PID)"
    exit 0
else
    # El bot está caído: Levantarlo en segundo plano
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] 🤖 El bot estaba apagado. Reiniciando en segundo plano..." >> bot_watchdog.log
    nohup node --experimental-global-webcrypto bot.js >> bot_salida.log 2>&1 &
    NUEVO_PID=$!
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] ✅ Bot reiniciado con éxito (PID: $NUEVO_PID)" >> bot_watchdog.log
fi
