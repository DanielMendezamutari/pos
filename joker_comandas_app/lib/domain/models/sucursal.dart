class Sucursal {
  final int codsucursal;
  final String nombresucursal;
  final bool cajaAbierta;
  final int? codarqueo;
  final String? cajero;

  Sucursal({
    required this.codsucursal,
    required this.nombresucursal,
    required this.cajaAbierta,
    this.codarqueo,
    this.cajero,
  });

  factory Sucursal.fromJson(Map<String, dynamic> json) {
    final rawId = json['codsucursal'] ?? json['id'] ?? 0;
    final rawName = json['nombresucursal'] ?? json['nombre'] ?? '';
    return Sucursal(
      codsucursal: int.tryParse(rawId.toString()) ?? 0,
      nombresucursal: rawName.toString(),
      cajaAbierta: json['caja_abierta'] == true,
      codarqueo: json['codarqueo'] != null ? int.tryParse(json['codarqueo'].toString()) : null,
      cajero: json['cajero'] ?? json['caja_actual'],
    );
  }
}
