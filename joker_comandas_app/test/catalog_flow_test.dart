import 'dart:io';
import 'package:flutter_test/flutter_test.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:joker_comandas_app/data/services/storage_service.dart';
import 'package:joker_comandas_app/data/services/api_service.dart';
import 'package:joker_comandas_app/domain/models/mesa.dart';
import 'package:joker_comandas_app/domain/models/producto.dart';
import 'package:joker_comandas_app/ui/features/comanda/view_models/comanda_view_model.dart';

class RealHttpOverrides extends HttpOverrides {
  @override
  HttpClient createHttpClient(SecurityContext? context) {
    return super.createHttpClient(context)
      ..badCertificateCallback = (cert, host, port) => true;
  }
}

void main() {
  HttpOverrides.global = RealHttpOverrides();

  group('Catalog & Comanda Flow Verification', () {
    test('Mesa parses nromesa, codmesa and nombre seamlessly', () {
      final backendJson = {
        'id': 6,
        'codmesa': 6,
        'nombre': 'Mesa 1',
        'nromesa': 'Mesa 1',
        'orden': 1,
      };
      final mesa = Mesa.fromJson(backendJson);
      expect(mesa.id, 6);
      expect(mesa.nombre, 'Mesa 1');
    });

    test('Live Local API Test: Login Mesera Central and Load Catalog', () async {
      SharedPreferences.setMockInitialValues({});
      final storage = await StorageService.init();
      await storage.setBaseUrl('http://127.0.0.1/pos/api');

      final api = ApiService(storage);

      // 1. Test connection
      final isOnline = await api.testConnection();
      expect(isOnline, true, reason: 'Local API server must be online');

      // 2. Login Mesera Central (codsucursal 2, pin 2222)
      final loginRes = await api.loginPin(2, '2222');
      expect(loginRes.success, true, reason: loginRes.message);
      expect(loginRes.data!['token'], isNotNull);
      expect(storage.getToken(), isNotNull);
      expect(storage.getMeseraNombre(), 'Mesera Central');
      expect(storage.getSucursalNombre(), 'JOKER CENTRAL');

      // 3. Get Mesas
      final mesasRes = await api.getMesas(2);
      expect(mesasRes.success, true, reason: mesasRes.message);
      expect(mesasRes.data, isNotEmpty);
      expect(mesasRes.data!.first.nombre.isNotEmpty, true);
      print('Mesas loaded: ${mesasRes.data!.map((m) => m.nombre).toList()}');

      // 4. Get Productos
      final prodRes = await api.getProductos(2);
      expect(prodRes.success, true, reason: prodRes.message);
      final prods = prodRes.data!['productos'] as List<Producto>;
      final cats = prodRes.data!['categorias'] as List<String>;
      expect(prods, isNotEmpty, reason: 'Products list should not be empty');
      expect(cats, contains('Todos'));
      expect(cats, contains('CERVEZAS'));
      print('Total productos cargados: ${prods.length}');
      print('Categorías: $cats');

      // 5. Test ComandaViewModel integration
      final vm = ComandaViewModel(apiService: api, storageService: storage);
      await vm.loadCatalog();
      expect(vm.isLoading, false);
      expect(vm.errorMessage, isNull);
      expect(vm.mesas, isNotEmpty);
      expect(vm.filteredProductos, isNotEmpty);
      expect(vm.filteredProductos.length, prods.length);

      // 6. Test Category filtering
      if (cats.contains('CERVEZAS')) {
        vm.selectCategoria('CERVEZAS');
        expect(vm.filteredProductos.every((p) => p.categoria.toUpperCase() == 'CERVEZAS'), true);
      }

      // Reset to Todos
      vm.selectCategoria('TODOS');
      expect(vm.filteredProductos.length, prods.length);

      // 7. Test Search filtering
      vm.setSearchQuery('COMBO');
      expect(vm.filteredProductos.isNotEmpty, true);
      expect(vm.filteredProductos.every((p) => p.nombre.toLowerCase().contains('combo')), true);

      // 8. Test Comanda Creation End-to-End
      vm.setSearchQuery('');
      final prodParaComanda = vm.filteredProductos.first;
      vm.addToCart(prodParaComanda);
      expect(vm.cart.length, 1);
      expect(vm.cartTotal, prodParaComanda.precio);

      // Select Mesa 1
      final targetMesa = vm.mesas.firstWhere((m) => m.nombre.toLowerCase().contains('1'), orElse: () => vm.mesas.first);
      vm.selectMesa(targetMesa);
      expect(vm.selectedMesa, isNotNull);
      expect(vm.selectedMesa!.nombre.isNotEmpty, true);

      // Select QR payment
      vm.setMetodoPago('QR');
      expect(vm.metodoPago, 'QR');

      // Send Comanda
      final sendOk = await vm.sendComanda();
      expect(sendOk, true, reason: vm.errorMessage);
      expect(vm.cart.isEmpty, true, reason: 'Cart must be cleared after successful send');
      expect(vm.successMessage, isNotNull);
      print('✓ Comanda enviada exitosamente: ${vm.successMessage}');
    });
  });
}
