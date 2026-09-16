import 'package:flutter/material.dart';
import '../../../../data/services/api_service.dart';
import '../../../../data/services/storage_service.dart';
import '../../../../domain/models/sucursal.dart';

class LoginViewModel extends ChangeNotifier {
  final ApiService _apiService;
  final StorageService _storageService;

  LoginViewModel({
    required this._apiService,
    required this._storageService,
  });

  List<Sucursal> _sucursales = [];
  List<Sucursal> get sucursales => _sucursales;

  Sucursal? _selectedSucursal;
  Sucursal? get selectedSucursal => _selectedSucursal;

  String _pin = '';
  String get pin => _pin;

  bool _isLoading = false;
  bool get isLoading => _isLoading;

  String? _errorMessage;
  String? get errorMessage => _errorMessage;

  bool _isConnected = true;
  bool get isConnected => _isConnected;

  String get currentBaseUrl => _storageService.getBaseUrl();

  Future<void> init() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      _isConnected = await _apiService.testConnection();
      final res = await _apiService.getSucursales();
      if (res.success && res.data != null) {
        _sucursales = res.data!;
        final savedSucId = _storageService.getSucursalId();
        final match = _sucursales.where((s) => s.codsucursal == savedSucId);
        if (match.isNotEmpty) {
          _selectedSucursal = match.first;
        } else if (_sucursales.isNotEmpty) {
          _selectedSucursal = _sucursales.first;
        }
      } else {
        _errorMessage = res.message;
      }
    } catch (e) {
      _errorMessage = 'Error de conexión inicial: $e';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void selectSucursal(Sucursal sucursal) {
    _selectedSucursal = sucursal;
    _storageService.setSucursalId(sucursal.codsucursal);
    _storageService.setSucursalNombre(sucursal.nombresucursal);
    _pin = '';
    _errorMessage = null;
    notifyListeners();
  }

  void appendDigit(String digit, VoidCallback onSuccess) {
    if (_pin.length < 4) {
      _pin += digit;
      _errorMessage = null;
      notifyListeners();

      if (_pin.length == 4) {
        login(onSuccess);
      }
    }
  }

  void deleteDigit() {
    if (_pin.isNotEmpty) {
      _pin = _pin.substring(0, _pin.length - 1);
      _errorMessage = null;
      notifyListeners();
    }
  }

  void clearPin() {
    _pin = '';
    _errorMessage = null;
    notifyListeners();
  }

  Future<bool> testCustomUrl(String url) async {
    return await _apiService.testConnection(url);
  }

  Future<void> updateBaseUrl(String newUrl) async {
    _isLoading = true;
    notifyListeners();

    await _storageService.setBaseUrl(newUrl);
    await init();
  }

  Future<void> login(VoidCallback onSuccess) async {
    if (_selectedSucursal == null) {
      _errorMessage = 'Seleccione una sucursal';
      notifyListeners();
      return;
    }

    if (!_selectedSucursal!.cajaAbierta) {
      _errorMessage = 'La caja de ${_selectedSucursal!.nombresucursal} está CERRADA.\nEl cajero debe abrir turno en el POS para poder comandar.';
      _pin = '';
      notifyListeners();
      return;
    }

    if (_pin.length != 4) {
      _errorMessage = 'Ingrese el PIN de 4 dígitos';
      notifyListeners();
      return;
    }

    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final res = await _apiService.loginPin(_selectedSucursal!.codsucursal, _pin);
      if (res.success) {
        _pin = '';
        _isLoading = false;
        notifyListeners();
        onSuccess();
      } else {
        _errorMessage = res.message;
        _pin = '';
        _isLoading = false;
        notifyListeners();
      }
    } catch (e) {
      _errorMessage = 'Error en inicio de sesión: $e';
      _pin = '';
      _isLoading = false;
      notifyListeners();
    }
  }
}
