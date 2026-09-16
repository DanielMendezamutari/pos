import 'package:flutter/material.dart';
import '../../../../data/services/api_service.dart';
import '../../../../data/services/storage_service.dart';
import '../../../../domain/models/mesa.dart';
import '../../../../domain/models/producto.dart';
import '../../../../domain/models/item_comanda.dart';

class ComandaViewModel extends ChangeNotifier {
  final ApiService _apiService;
  final StorageService _storageService;

  ComandaViewModel({
    required this._apiService,
    required this._storageService,
  });

  List<Mesa> _mesas = [];
  List<Mesa> get mesas => _mesas;

  Mesa? _selectedMesa;
  Mesa? get selectedMesa => _selectedMesa;

  List<Producto> _allProductos = [];
  List<Producto> _filteredProductos = [];
  List<Producto> get filteredProductos => _filteredProductos;

  List<String> _categorias = ['Todos'];
  List<String> get categorias => _categorias;

  String _selectedCategoria = 'Todos';
  String get selectedCategoria => _selectedCategoria;

  String _searchQuery = '';
  String get searchQuery => _searchQuery;

  final List<ItemComanda> _cart = [];
  List<ItemComanda> get cart => List.unmodifiable(_cart);

  String _metodoPago = 'EFECTIVO';
  String get metodoPago => _metodoPago;

  String _notas = '';
  String get notas => _notas;

  bool _isLoading = false;
  bool get isLoading => _isLoading;

  bool _isSubmitting = false;
  bool get isSubmitting => _isSubmitting;

  String? _errorMessage;
  String? get errorMessage => _errorMessage;

  String? _successMessage;
  String? get successMessage => _successMessage;

  String get meseraNombre => _storageService.getMeseraNombre() ?? 'Mesera';
  String get sucursalNombre => _storageService.getSucursalNombre();

  double get cartTotal {
    return _cart.fold(0.0, (sum, item) => sum + item.subtotal);
  }

  int get cartCount {
    return _cart.fold(0, (sum, item) => sum + item.cantidad);
  }

  Future<void> loadCatalog() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final sucursalId = _storageService.getSucursalId();

      // 1. Fetch tables
      final resMesas = await _apiService.getMesas(sucursalId);
      if (resMesas.success && resMesas.data != null) {
        _mesas = resMesas.data!;
        if (_mesas.isNotEmpty && _selectedMesa == null) {
          _selectedMesa = _mesas.first;
        }
      }

      // 2. Fetch products & combos
      final resProd = await _apiService.getProductos(sucursalId);
      if (resProd.success && resProd.data != null) {
        _allProductos = resProd.data!['productos'] as List<Producto>;
        _categorias = resProd.data!['categorias'] as List<String>;
        _filterProductos();
      } else {
        _errorMessage = resProd.message;
      }
    } catch (e) {
      _errorMessage = 'Error al cargar catálogo: $e';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void selectMesa(Mesa mesa) {
    _selectedMesa = mesa;
    notifyListeners();
  }

  void selectCategoria(String cat) {
    _selectedCategoria = cat;
    _filterProductos();
    notifyListeners();
  }

  void setSearchQuery(String q) {
    _searchQuery = q.toLowerCase().trim();
    _filterProductos();
    notifyListeners();
  }

  void _filterProductos() {
    _filteredProductos = _allProductos.where((p) {
      final selCat = _selectedCategoria.toLowerCase().trim();
      final pCat = p.categoria.toLowerCase().trim();

      final matchesCategory = selCat == 'todos' ||
          (selCat == 'combos' && p.isCombo) ||
          pCat == selCat;

      final matchesSearch = _searchQuery.isEmpty ||
          p.nombre.toLowerCase().contains(_searchQuery);

      return matchesCategory && matchesSearch;
    }).toList();
  }

  void addToCart(Producto prod) {
    final index = _cart.indexWhere((item) => item.producto.id == prod.id && item.producto.tipo == prod.tipo);
    if (index >= 0) {
      _cart[index].cantidad += 1;
    } else {
      _cart.add(ItemComanda(producto: prod, cantidad: 1));
    }
    notifyListeners();
  }

  void decreaseQuantity(ItemComanda item) {
    final index = _cart.indexOf(item);
    if (index >= 0) {
      if (_cart[index].cantidad > 1) {
        _cart[index].cantidad -= 1;
      } else {
        _cart.removeAt(index);
      }
      notifyListeners();
    }
  }

  void removeItem(ItemComanda item) {
    _cart.remove(item);
    notifyListeners();
  }

  void clearCart() {
    _cart.clear();
    _notas = '';
    notifyListeners();
  }

  void setMetodoPago(String metodo) {
    _metodoPago = metodo;
    notifyListeners();
  }

  void setNotas(String val) {
    _notas = val;
    notifyListeners();
  }

  Future<bool> sendComanda() async {
    if (_cart.isEmpty) {
      _errorMessage = 'El carrito está vacío';
      notifyListeners();
      return false;
    }

    _isSubmitting = true;
    _errorMessage = null;
    _successMessage = null;
    notifyListeners();

    try {
      final itemsData = _cart.map((item) => item.toJson()).toList();
      final res = await _apiService.crearComanda(
        codmesa: _selectedMesa?.id,
        mesaNombre: _selectedMesa?.nombre ?? 'Barra',
        items: itemsData,
        metodoPago: _metodoPago,
        notas: _notas,
      );

      if (res.success) {
        _successMessage = 'Comanda enviada a caja exitosamente (Total: Bs. ${cartTotal.toStringAsFixed(2)})';
        clearCart();
        _isSubmitting = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = res.message;
        _isSubmitting = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Error de red: $e';
      _isSubmitting = false;
      notifyListeners();
      return false;
    }
  }
}
