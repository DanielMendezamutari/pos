import asyncio
import math
import sys
import wave
from pathlib import Path

ROOT = Path(__file__).parent
sys.path.insert(0, str(ROOT.parent / 'video_promocional' / 'pydeps'))
import edge_tts

TEXT = (
    '¿Vendes todos los días, pero no siempre tienes claro qué está pasando en tu negocio? '
    'Con RiberSoft POS, ves tus indicadores y tus ventas en un solo lugar. '
    'Atiende más rápido con un punto de venta visual, productos organizados y búsquedas ágiles. '
    'Mantén tu inventario bajo control y consulta tus resultados cuando lo necesites. '
    'Por solo ciento cincuenta bolivianos al mes, no estás pagando un gasto más: '
    'estás invirtiendo en orden, control y mejores decisiones para tu negocio. '
    'RiberSoft POS. Crece con información clara.'
)

async def voice():
    await edge_tts.Communicate(TEXT, 'es-BO-MarceloNeural', rate='+24%').save(str(ROOT / 'locucion_ventas.mp3'))

def music():
    rate, duration = 44100, 31.0
    notes = [146.83, 174.61, 220.00, 174.61, 164.81, 196.00, 246.94, 196.00]
    frames = bytearray()
    for n in range(int(rate * duration)):
        t = n / rate
        note = notes[int(t / 1.5) % len(notes)]
        phase = t % 1.5
        env = min(1, phase * 5, (1.5 - phase) * 4)
        sample = (0.024 * math.sin(2*math.pi*73.42*t) + 0.018 * math.sin(2*math.pi*110*t)
                  + 0.052 * env * math.sin(2*math.pi*note*t)
                  + 0.014 * env * math.sin(2*math.pi*note*2*t))
        fade = min(1, t * 1.5, (duration - t) * 1.5)
        frames.extend(int(max(-1, min(1, sample * fade)) * 32767).to_bytes(2, 'little', signed=True))
    with wave.open(str(ROOT / 'musica_original.wav'), 'wb') as out:
        out.setnchannels(1); out.setsampwidth(2); out.setframerate(rate); out.writeframes(frames)

music()
asyncio.run(voice())
