import 'package:flutter/material.dart';
import '../../../../data/services/api_service.dart';
import '../../../../data/services/storage_service.dart';
import '../../../../domain/models/comanda.dart';

class TurnoViewModel extends ChangeNotifier {
  final ApiService _apiService;
  final StorageService _storageService;

  TurnoViewModel({
    required this._apiService,
    required this._storageService,
  });

  ResumenTurno? _resumen;
  ResumenTurno? get resumen => _resumen;

  List<Comanda> _comandas = [];
  List<Comanda> get comandas => _comandas;

  bool _isLoading = false;
  bool get isLoading => _isLoading;

  String? _errorMessage;
  String? get errorMessage => _errorMessage;

  String get meseraNombre => _storageService.getMeseraNombre() ?? 'Mesera';
  String get sucursalNombre => _storageService.getSucursalNombre();

  Future<void> loadHistorial() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final res = await _apiService.getHistorialTurno();
      if (res.success && res.data != null) {
        _resumen = res.data!['resumen'] as ResumenTurno;
        _comandas = res.data!['comandas'] as List<Comanda>;
      } else {
        _errorMessage = res.message;
      }
    } catch (e) {
      _errorMessage = 'Error al cargar turno: $e';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> logout(VoidCallback onDone) async {
    await _storageService.clearAuth();
    onDone();
  }
}
