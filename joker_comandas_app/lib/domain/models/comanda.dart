import 'item_comanda.dart';

class Comanda {
  final int id;
  final String codigo;
  final String mesaNombre;
  final double total;
  final String metodoPagoSugerido;
  final String estado; // 'PENDIENTE' | 'COBRADO' | 'CANCELADO'
  final String tiempoTranscurrido;
  final String fechahora;
  final List<ItemComanda> items;

  Comanda({
    required this.id,
    required this.codigo,
    required this.mesaNombre,
    required this.total,
    required this.metodoPagoSugerido,
    required this.estado,
    required this.tiempoTranscurrido,
    required this.fechahora,
    required this.items,
  });

  bool get isPendiente => estado == 'PENDIENTE';
  bool get isCobrado => estado == 'COBRADO';

  factory Comanda.fromJson(Map<String, dynamic> json) {
    var rawItems = json['items'];
    List<ItemComanda> list = [];
    if (rawItems is List) {
      list = rawItems.map((i) => ItemComanda.fromJson(i)).toList();
    }

    return Comanda(
      id: int.parse(json['id'].toString()),
      codigo: json['codigo_comanda'] ?? '',
      mesaNombre: json['mesa_nombre'] ?? 'Sin mesa',
      total: double.tryParse(json['total'].toString()) ?? 0.0,
      metodoPagoSugerido: json['metodo_pago_sugerido'] ?? 'EFECTIVO',
      estado: json['estado'] ?? 'PENDIENTE',
      tiempoTranscurrido: json['tiempo_transcurrido'] ?? '',
      fechahora: json['fechahora'] ?? '',
      items: list,
    );
  }
}

class ResumenTurno {
  final double totalCobrado;
  final double totalPendiente;
  final double totalTurno;
  final int cantCobrada;
  final int cantPendiente;

  ResumenTurno({
    required this.totalCobrado,
    required this.totalPendiente,
    required this.totalTurno,
    required this.cantCobrada,
    required this.cantPendiente,
  });

  factory ResumenTurno.fromJson(Map<String, dynamic> json) {
    return ResumenTurno(
      totalCobrado: double.tryParse(json['total_cobrado'].toString()) ?? 0.0,
      totalPendiente: double.tryParse(json['total_pendiente'].toString()) ?? 0.0,
      totalTurno: double.tryParse(json['total_turno'].toString()) ?? 0.0,
      cantCobrada: int.tryParse(json['cant_cobrada'].toString()) ?? 0,
      cantPendiente: int.tryParse(json['cant_pendiente'].toString()) ?? 0,
    );
  }
}
