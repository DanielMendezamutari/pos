class Mesa {
  final int id;
  final String nombre;
  final int orden;

  Mesa({
    required this.id,
    required this.nombre,
    required this.orden,
  });

  factory Mesa.fromJson(Map<String, dynamic> json) {
    final rawId = json['id'] ?? json['codmesa'] ?? 0;
    final rawName = json['nombre'] ?? json['nromesa'] ?? json['nommesa'] ?? 'Mesa';
    return Mesa(
      id: int.tryParse(rawId.toString()) ?? 0,
      nombre: rawName.toString(),
      orden: int.tryParse((json['orden'] ?? 0).toString()) ?? 0,
    );
  }
}
