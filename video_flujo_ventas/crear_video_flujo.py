from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageFont

ROOT = Path(__file__).parent
CAPTURES = ROOT / 'capturas'
FRAMES = ROOT / 'frames'
FRAMES.mkdir(parents=True, exist_ok=True)
W, H = 1920, 1080
FONT = Path(r'C:\Windows\Fonts\segoeuib.ttf')

def font(size):
    return ImageFont.truetype(str(FONT), size)

def centered(draw, text, y, size, color='white'):
    box = draw.textbbox((0, 0), text, font=font(size))
    draw.text(((W - box[2] + box[0]) / 2, y), text, font=font(size), fill=color)

def title(name, label, headline, detail, price=False):
    image = Image.new('RGB', (W, H), '#061c31')
    draw = ImageDraw.Draw(image)
    draw.rounded_rectangle((150, 150, 1770, 930), radius=44, fill='#0d304f', outline='#21bed7', width=3)
    centered(draw, label.upper(), 265, 27, '#25c5dd')
    centered(draw, headline, 365, 70)
    centered(draw, detail, 505, 34, '#c5e4ee')
    if price:
        draw.rounded_rectangle((650, 630, 1270, 790), radius=30, fill='#23b9d4')
        centered(draw, 'Bs 150 / mes', 665, 62, '#062038')
    centered(draw, 'RIBERSOFT POS', 825, 25, '#8eb9c8')
    image.save(FRAMES / name)

def screen(name, source, label, headline, detail):
    shot = Image.open(CAPTURES / source).convert('RGB')
    blurred = shot.resize((W, H)).filter(ImageFilter.GaussianBlur(18))
    image = Image.blend(blurred, Image.new('RGB', (W, H), '#071d31'), .55).convert('RGBA')
    shot.thumbnail((1450, 765))
    x, y = (W - shot.width) // 2, 115
    shadow = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    ImageDraw.Draw(shadow).rounded_rectangle((x-18, y-18, x+shot.width+18, y+shot.height+18), radius=24, fill=(0, 0, 0, 135))
    image = Image.alpha_composite(image, shadow)
    image.paste(shot, (x, y))
    image.alpha_composite(Image.new('RGBA', (W, 220), (4, 18, 34, 238)), (0, H-220))
    draw = ImageDraw.Draw(image)
    draw.text((125, 885), label.upper(), font=font(25), fill='#21c1da')
    draw.text((125, 925), headline, font=font(45), fill='white')
    draw.text((125, 985), detail, font=font(29), fill='#c5dfe9')
    image.convert('RGB').save(FRAMES / name)

title('01_inicio.png', 'RiberSoft POS', 'Vender puede ser simple.', 'Un flujo claro para atender, cobrar y registrar cada movimiento.')
screen('02_pos.png', '01_inicio_pos.png', 'Punto de venta', 'Tu negocio listo para atender.', 'Catálogo visual, productos ordenados y búsqueda directa.')
screen('03_apertura.png', '02_apertura_caja.png', 'Inicio de turno', 'Empieza con control de caja.', 'Selecciona la caja y registra la apertura antes de vender.')
screen('04_carrito.png', '03_producto_carrito.png', 'Venta ágil', 'Elige productos y arma el carrito.', 'El total se actualiza mientras atiendes a tu cliente.')
screen('05_cobro.png', '04_cobro.png', 'Cobro organizado', 'Revisa total, documento y condición.', 'Todo lo necesario para preparar una venta ordenada.')
screen('06_listo.png', '05_listo_facturar.png', 'Listo para vender', 'Elige la forma de pago y registra.', 'Un flujo visible, sencillo y preparado para tu operación.')
title('07_precio.png', 'Una inversión accesible', 'No es un gasto más.', 'Es orden, rapidez y control para tu negocio.', True)
