@echo off
title BOT DE AUDITORIA WHATSAPP - JOKER POS
color 0b

echo =========================================================
echo    INICIANDO BOT DE AUDITORIA WHATSAPP - JOKER POS
echo =========================================================
echo.

cd /d "%~dp0whatsapp_bot" 2>nul || cd /d "%~dp0"

:loop
echo [%date% %time%] Ejecutando bot.js...
node bot.js
echo.
echo [%date% %time%] El bot se detuvo. Reconectando en 5 segundos... (Presiona Ctrl+C para cancelar)
timeout /t 5 >nul
goto loop
