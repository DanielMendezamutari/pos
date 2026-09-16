import 'package:flutter_test/flutter_test.dart';
import 'package:joker_comandas_app/domain/models/mesa.dart';
import 'package:joker_comandas_app/domain/models/producto.dart';
import 'package:joker_comandas_app/domain/models/item_comanda.dart';
import 'package:joker_comandas_app/domain/models/comanda.dart';

void main() {
  group('Domain Models Unit Tests', () {
    test('Mesa model parses JSON correctly', () {
      final json = {'id': 5, 'nombre': 'Mesa 5', 'orden': 5};
      final mesa = Mesa.fromJson(json);
      expect(mesa.id, 5);
      expect(mesa.nombre, 'Mesa 5');
      expect(mesa.orden, 5);
    });

    test('Producto and ItemComanda calculate subtotals correctly', () {
      final prod = Producto(
        id: 'PROD_1',
        tipo: 'producto',
        nombre: 'Cerveza Huari 330ml',
        precio: 15.0,
        categoria: 'Cervezas',
        stock: 24,
      );

      final item = ItemComanda(producto: prod, cantidad: 3);
      expect(item.subtotal, 45.0);

      final json = item.toJson();
      expect(json['id'], 'PROD_1');
      expect(json['idproducto'], 'PROD_1');
      expect(json['nombre'], 'Cerveza Huari 330ml');
      expect(json['producto'], 'Cerveza Huari 330ml');
      expect(json['cantidad'], 3);
      expect(json['subtotal'], 45.0);
    });

    test('Comanda and ResumenTurno parse correctly', () {
      final jsonResumen = {
        'total_cobrado': 150.0,
        'total_pendiente': 35.0,
        'total_turno': 185.0,
        'cant_cobrada': 5,
        'cant_pendiente': 1,
      };

      final resumen = ResumenTurno.fromJson(jsonResumen);
      expect(resumen.totalCobrado, 150.0);
      expect(resumen.totalPendiente, 35.0);
      expect(resumen.cantCobrada, 5);
    });
  });
}
