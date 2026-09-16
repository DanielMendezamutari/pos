"""Crea una cama musical ambiental original para el video promocional."""
import math
import wave
from pathlib import Path

OUT = Path(__file__).parent / 'musica_original.wav'
RATE = 44100
DURATION = 21.0

notes = [146.83, 174.61, 220.00, 174.61, 164.81, 196.00, 246.94, 196.00]
frames = bytearray()
for n in range(int(RATE * DURATION)):
    t = n / RATE
    step = int(t / 1.5) % len(notes)
    phase = t % 1.5
    envelope = min(1, phase * 5, (1.5 - phase) * 4)
    pad = 0.025 * math.sin(2 * math.pi * 73.42 * t) + 0.018 * math.sin(2 * math.pi * 110.0 * t)
    tone = 0.055 * envelope * (math.sin(2 * math.pi * notes[step] * t) + 0.35 * math.sin(2 * math.pi * notes[step] * 2 * t))
    shimmer = 0.012 * envelope * math.sin(2 * math.pi * notes[step] * 4 * t)
    fade = min(1, t * 1.5, (DURATION - t) * 1.5)
    sample = max(-1, min(1, (pad + tone + shimmer) * fade))
    frames.extend(int(sample * 32767).to_bytes(2, 'little', signed=True))

with wave.open(str(OUT), 'wb') as wav:
    wav.setnchannels(1)
    wav.setsampwidth(2)
    wav.setframerate(RATE)
    wav.writeframes(frames)
