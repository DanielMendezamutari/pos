import asyncio
import sys
from pathlib import Path

ROOT = Path(__file__).parent
sys.path.insert(0, str(ROOT / 'pydeps'))
import edge_tts

TEXT = (
    'RiberSoft POS. Todo tu negocio, bajo control. '
    'Visualiza tus indicadores en tiempo real. '
    'Atiende y cobra con rapidez, desde un punto de venta intuitivo. '
    'Organiza tu inventario y consulta cada producto. '
    'Revisa tus ventas y exporta reportes cuando los necesites. '
    'RiberSoft POS. Más orden para operar. Más tiempo para crecer.'
)

async def main():
    voice = 'es-BO-MarceloNeural'
    communicator = edge_tts.Communicate(TEXT, voice, rate='+28%')
    await communicator.save(str(ROOT / 'locucion.mp3'))

asyncio.run(main())
