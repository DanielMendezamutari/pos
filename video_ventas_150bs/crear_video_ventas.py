from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageFont

ROOT = Path(__file__).parent
CAPTURES = ROOT.parent / 'video_promocional' / 'capturas'
FRAMES = ROOT / 'frames'
FRAMES.mkdir(parents=True, exist_ok=True)
W, H = 1920, 1080
FONT = Path(r'C:\Windows\Fonts\segoeuib.ttf')

def f(size):
    return ImageFont.truetype(str(FONT), size)

def center(draw, text, y, size, color='white'):
    box = draw.textbbox((0, 0), text, font=f(size))
    draw.text(((W - box[2] + box[0]) / 2, y), text, font=f(size), fill=color)

def title(name, label, headline, detail, price=False):
    img = Image.new('RGB', (W, H), '#061c31')
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle((150, 150, 1770, 930), radius=44, fill='#0d304f', outline='#21bed7', width=3)
    center(draw, label.upper(), 265, 27, '#25c5dd')
    center(draw, headline, 365, 70)
    center(draw, detail, 505, 34, '#c5e4ee')
    if price:
        draw.rounded_rectangle((650, 630, 1270, 790), radius=30, fill='#23b9d4')
        center(draw, 'Bs 150 / mes', 665, 62, '#062038')
    center(draw, 'RIBERSOFT POS', 825, 25, '#8eb9c8')
    img.save(FRAMES / name)

def screen(name, source, label, headline, detail):
    shot = Image.open(CAPTURES / source).convert('RGB')
    blurred = shot.resize((W, H)).filter(ImageFilter.GaussianBlur(18))
    background = Image.blend(blurred, Image.new('RGB', (W, H), '#071d31'), .55).convert('RGBA')
    shot.thumbnail((1450, 765))
    x, y = (W - shot.width)//2, 115
    shade = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    d = ImageDraw.Draw(shade)
    d.rounded_rectangle((x-18, y-18, x+shot.width+18, y+shot.height+18), radius=24, fill=(0,0,0,135))
    background = Image.alpha_composite(background, shade)
    background.paste(shot, (x, y))
    overlay = Image.new('RGBA', (W, 220), (4, 18, 34, 238))
    background.alpha_composite(overlay, (0, H-220))
    draw = ImageDraw.Draw(background)
    draw.text((125, 885), label.upper(), font=f(25), fill='#21c1da')
    draw.text((125, 925), headline, font=f(45), fill='white')
    draw.text((125, 985), detail, font=f(29), fill='#c5dfe9')
    background.convert('RGB').save(FRAMES / name)

title('01_hook.png', 'Control para vender mejor', '¿Tu negocio vende, pero tú tienes el control?', 'Convierte cada día de operación en información útil.')
screen('02_dashboard.png', 'dashboard.png', 'Visión clara', 'Mira lo importante en un solo lugar.', 'Indicadores y ventas para entender tu operación.')
screen('03_pos.png', 'pos.png', 'Ventas ágiles', 'Atiende y cobra con rapidez.', 'Un punto de venta visual, productos ordenados y búsqueda directa.')
screen('04_inventario.png', 'inventario.png', 'Control de productos', 'Organiza tu inventario todos los días.', 'Consulta tu catálogo y mantén tus productos a la vista.')
screen('05_reportes.png', 'ventas.png', 'Decisiones con información', 'Revisa ventas y genera reportes.', 'Ten los datos que necesitas cuando los necesitas.')
title('06_precio.png', 'Una inversión accesible', 'No es un gasto más.', 'Es una cuota mensual para operar con más orden y control.', True)
title('07_cierre.png', 'RiberSoft POS', 'Invierte en claridad para tu negocio.', 'Ventas, control e información que te ayudan a avanzar.')
