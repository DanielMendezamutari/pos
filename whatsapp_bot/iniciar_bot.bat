@echo off
title BOT DE AUDITORIA WHATSAPP - JOKER POS
color 0b

echo =========================================================
echo    INICIANDO BOT DE AUDITORIA WHATSAPP - JOKER POS
echo =========================================================
echo.

:loop
echo [%date% %time%] Ejecutando bot.js...
node bot.js
echo.
echo [%date% %time%] El bot se detuvo. Reconectando en 5 segundos... (Presiona Ctrl+C para cancelar)
timeout /t 5 >nul
goto loop
