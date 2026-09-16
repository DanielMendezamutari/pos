from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageFont

ROOT = Path(__file__).parent
CAPTURES = ROOT / 'capturas'
FRAMES = ROOT / 'frames'
FRAMES.mkdir(exist_ok=True)
W, H = 1920, 1080
FONT = Path(r'C:\Windows\Fonts\segoeuib.ttf')
FONT_BOLD = Path(r'C:\Windows\Fonts\segoeuib.ttf')

def font(size, bold=False):
    return ImageFont.truetype(str(FONT_BOLD if bold else FONT), size)

def canvas():
    return Image.new('RGB', (W, H), '#071b2f')

def centered(draw, text, y, size, color='white', bold=False):
    f = font(size, bold)
    box = draw.textbbox((0, 0), text, font=f)
    draw.text(((W - (box[2] - box[0])) / 2, y), text, font=f, fill=color)

def title_frame(name, headline, subtitle, logo=False):
    img = canvas()
    draw = ImageDraw.Draw(img)
    draw.rounded_rectangle((145, 130, 1775, 950), radius=48, fill='#0d2e4d', outline='#26b6d4', width=3)
    if logo:
        mark = Image.open(ROOT.parent / 'fotos' / 'logo_principal.png').convert('RGBA')
        mark.thumbnail((580, 250))
        img.paste(mark, ((W-mark.width)//2, 210), mark)
    centered(draw, headline, 520 if logo else 305, 72, '#ffffff', True)
    centered(draw, subtitle, 625 if logo else 430, 36, '#b9e9f2')
    draw.line((700, 715 if logo else 540, 1220, 715 if logo else 540), fill='#24bdd7', width=5)
    centered(draw, 'GESTIÓN ÁGIL · CONTROL TOTAL · DECISIONES CLARAS', 770 if logo else 620, 27, '#8db7c7')
    img.save(FRAMES / name, quality=95)

def screen_frame(source, name, title, subtitle, kicker):
    shot = Image.open(CAPTURES / source).convert('RGB')
    bg = shot.resize((W, H)).filter(ImageFilter.GaussianBlur(18))
    bg = Image.blend(bg, Image.new('RGB', (W, H), '#062038'), .50)
    card = shot.copy()
    card.thumbnail((1450, 770))
    x = (W - card.width) // 2
    y = 115
    out = bg
    shade = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    sd = ImageDraw.Draw(shade)
    sd.rounded_rectangle((x-18, y-18, x+card.width+18, y+card.height+18), radius=24, fill=(0, 0, 0, 125))
    out = Image.alpha_composite(out.convert('RGBA'), shade)
    out.paste(card, (x, y))
    panel = Image.new('RGBA', (W, 215), (4, 20, 37, 235))
    out.alpha_composite(panel, (0, H-215))
    draw = ImageDraw.Draw(out)
    draw.text((125, 890), kicker.upper(), font=font(25, True), fill='#21c1da')
    draw.text((125, 925), title, font=font(44, True), fill='white')
    draw.text((125, 982), subtitle, font=font(29), fill='#c1dce7')
    out.convert('RGB').save(FRAMES / name, quality=95)

title_frame('01_inicio.png', 'Tu negocio, bajo control.', 'RiberSoft POS: venta, inventario y reportes en un solo lugar.', True)
screen_frame('dashboard.png', '02_dashboard.png', 'Ve tu operación de un vistazo.', 'Indicadores, ventas, productos y movimientos para decidir con claridad.', 'Dashboard ejecutivo')
screen_frame('pos.png', '03_pos.png', 'Cobra con rapidez y precisión.', 'Catálogo visual, búsqueda ágil y herramientas para atención en mostrador.', 'Punto de venta')
screen_frame('inventario.png', '04_inventario.png', 'Inventario siempre organizado.', 'Consulta productos y administra tu catálogo con opciones de exportación.', 'Gestión de inventario')
screen_frame('ventas.png', '05_reportes.png', 'Información lista para analizar.', 'Consulta tus ventas y exporta reportes cuando los necesitas.', 'Reportes y consultas')
title_frame('06_cierre.png', 'RiberSoft POS', 'Más orden para operar. Más tiempo para crecer.', False)
