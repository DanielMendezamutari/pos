class Producto {
  final dynamic id;
  final String tipo; // 'producto' | 'combo'
  final String nombre;
  final double precio;
  final String categoria;
  final double stock;
  final String? codigo;

  Producto({
    required this.id,
    required this.tipo,
    required this.nombre,
    required this.precio,
    required this.categoria,
    required this.stock,
    this.codigo,
  });

  factory Producto.fromJson(Map<String, dynamic> json) {
    final rawId = json['id'] ?? json['idproducto'] ?? 0;
    final rawNombre = json['nombre'] ?? json['producto'] ?? '';
    final rawTipo = json['tipo'] ?? json['tipoproducto'] ?? 'producto';
    final rawStock = json['stock'] ?? json['existencia'] ?? 0;
    final rawCategoria = json['categoria'] ?? 'GENERAL';
    final rawCodigo = json['codigo'] ?? json['codproducto'];

    return Producto(
      id: rawId,
      tipo: rawTipo.toString().toLowerCase(),
      nombre: rawNombre.toString(),
      precio: double.tryParse((json['precio'] ?? 0).toString()) ?? 0.0,
      categoria: rawCategoria.toString(),
      stock: double.tryParse(rawStock.toString()) ?? 0.0,
      codigo: rawCodigo?.toString(),
    );
  }

  bool get isCombo => tipo.toLowerCase().contains('combo');
}
