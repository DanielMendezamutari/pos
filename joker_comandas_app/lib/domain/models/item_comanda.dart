import 'producto.dart';

class ItemComanda {
  final Producto producto;
  int cantidad;
  String notas;

  ItemComanda({
    required this.producto,
    this.cantidad = 1,
    this.notas = '',
  });

  double get subtotal => producto.precio * cantidad;

  Map<String, dynamic> toJson() {
    return {
      'id': producto.id,
      'idproducto': producto.id,
      'codigo': producto.codigo ?? '',
      'codproducto': producto.codigo ?? '',
      'tipo': producto.tipo,
      'tipoproducto': producto.tipo,
      'nombre': producto.nombre,
      'producto': producto.nombre,
      'cantidad': cantidad,
      'precio': producto.precio,
      'subtotal': subtotal,
      'notas': notas,
    };
  }

  factory ItemComanda.fromJson(Map<String, dynamic> json) {
    return ItemComanda(
      producto: Producto(
        id: json['id'] ?? json['idproducto'],
        codigo: (json['codigo'] ?? json['codproducto'])?.toString(),
        tipo: json['tipo'] ?? json['tipoproducto'] ?? 'producto',
        nombre: json['nombre'] ?? json['producto'] ?? '',
        precio: double.tryParse((json['precio'] ?? 0).toString()) ?? 0.0,
        categoria: json['categoria']?.toString() ?? '',
        stock: double.tryParse((json['stock'] ?? json['existencia'] ?? 0).toString()) ?? 0.0,
      ),
      cantidad: int.tryParse((json['cantidad'] ?? 1).toString()) ?? 1,
      notas: json['notas'] ?? '',
    );
  }
}
