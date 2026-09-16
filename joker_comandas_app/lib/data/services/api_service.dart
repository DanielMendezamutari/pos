import 'dart:convert';
import 'package:http/http.dart' as http;
import '../../domain/models/sucursal.dart';
import '../../domain/models/mesa.dart';
import '../../domain/models/producto.dart';
import '../../domain/models/comanda.dart';
import 'storage_service.dart';

class ApiResponse<T> {
  final bool success;
  final String message;
  final T? data;
  final int statusCode;

  ApiResponse({
    required this.success,
    required this.message,
    this.data,
    required this.statusCode,
  });
}

class ApiService {
  final StorageService storageService;

  ApiService(this.storageService);

  String get baseUrl => storageService.getBaseUrl();

  Map<String, String> _getHeaders() {
    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    final token = storageService.getToken();
    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
      headers['X-Token'] = token;
      headers['X-Authorization'] = 'Bearer $token';
    }
    return headers;
  }

  // 1. Health check to verify network / API reachability
  Future<bool> testConnection([String? customUrl]) async {
    String target = (customUrl ?? baseUrl).trim();
    if (target.endsWith('/')) {
      target = target.substring(0, target.length - 1);
    }
    final uri = Uri.parse('$target/config/health.php');
    try {
      final response = await http.get(uri).timeout(const Duration(seconds: 6));
      if (response.statusCode == 200) {
        return true;
      }
      return false;
    } catch (_) {
      return false;
    }
  }

  // 2. Get Branches and active cash register status
  Future<ApiResponse<List<Sucursal>>> getSucursales() async {
    final uri = Uri.parse('$baseUrl/catalog/sucursales.php');
    try {
      final response = await http.get(uri, headers: _getHeaders()).timeout(const Duration(seconds: 8));
      final json = jsonDecode(response.body);
      if (response.statusCode == 200 && json['sucursales'] != null) {
        final list = (json['sucursales'] as List)
            .map((s) => Sucursal.fromJson(s))
            .toList();
        return ApiResponse(
          success: true,
          message: 'Sucursales cargadas',
          data: list,
          statusCode: response.statusCode,
        );
      }
      return ApiResponse(
        success: false,
        message: json['error'] ?? 'Error al obtener sucursales',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'No se pudo conectar con el servidor ($e)',
        statusCode: 500,
      );
    }
  }

  // 3. Login with PIN
  Future<ApiResponse<Map<String, dynamic>>> loginPin(int codsucursal, String pin) async {
    final uri = Uri.parse('$baseUrl/auth/login_pin.php');
    try {
      final response = await http.post(
        uri,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'codsucursal': codsucursal,
          'pin': pin,
        }),
      ).timeout(const Duration(seconds: 8));

      final json = jsonDecode(response.body);
      if (response.statusCode == 200 && json['token'] != null) {
        // Save auth data
        await storageService.setToken(json['token']);
        await storageService.setSucursalId(codsucursal);
        if (json['mesera'] != null) {
          await storageService.setMeseraId(int.parse(json['mesera']['id'].toString()));
          await storageService.setMeseraNombre(json['mesera']['nombre'] ?? '');
          await storageService.setSucursalNombre(json['mesera']['sucursal'] ?? '');
        }

        return ApiResponse(
          success: true,
          message: 'Inicio de sesión exitoso',
          data: json,
          statusCode: 200,
        );
      }

      return ApiResponse(
        success: false,
        message: json['error'] ?? 'PIN incorrecto o sin turno abierto',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'Error de conexión: $e',
        statusCode: 500,
      );
    }
  }

  // 4. Get Tables for branch
  Future<ApiResponse<List<Mesa>>> getMesas(int codsucursal) async {
    final token = storageService.getToken() ?? '';
    final uri = Uri.parse('$baseUrl/catalog/mesas.php?codsucursal=$codsucursal&token=$token');
    try {
      final response = await http.get(uri, headers: _getHeaders()).timeout(const Duration(seconds: 8));
      final json = jsonDecode(response.body);
      if (response.statusCode == 200 && json['mesas'] != null) {
        final list = (json['mesas'] as List)
            .map((m) => Mesa.fromJson(m))
            .toList();
        return ApiResponse(
          success: true,
          message: 'Mesas cargadas',
          data: list,
          statusCode: 200,
        );
      }
      return ApiResponse(
        success: false,
        message: json['mensaje'] ?? json['error'] ?? 'Error al cargar mesas',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'Error de conexión: $e',
        statusCode: 500,
      );
    }
  }

  // 5. Get Products and Combos for branch
  Future<ApiResponse<Map<String, dynamic>>> getProductos(int codsucursal) async {
    final token = storageService.getToken() ?? '';
    final uri = Uri.parse('$baseUrl/catalog/productos.php?codsucursal=$codsucursal&token=$token');
    try {
      final response = await http.get(uri, headers: _getHeaders()).timeout(const Duration(seconds: 10));
      final json = jsonDecode(response.body);
      if (response.statusCode == 200) {
        List<Producto> productos = [];
        List<String> categorias = ['Todos'];

        if (json['productos'] != null) {
          for (var p in (json['productos'] as List)) {
            final prod = Producto.fromJson(p);
            productos.add(prod);
            if (prod.categoria.isNotEmpty &&
                !categorias.any((c) => c.toLowerCase() == prod.categoria.toLowerCase())) {
              categorias.add(prod.categoria);
            }
          }
        }

        return ApiResponse(
          success: true,
          message: 'Catálogo cargado',
          data: {
            'productos': productos,
            'categorias': categorias,
          },
          statusCode: 200,
        );
      }
      return ApiResponse(
        success: false,
        message: json['mensaje'] ?? json['error'] ?? 'Error al cargar productos',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'Error de conexión: $e',
        statusCode: 500,
      );
    }
  }

  // 6. Create Comanda
  Future<ApiResponse<Map<String, dynamic>>> crearComanda({
    required int? codmesa,
    required String mesaNombre,
    required List<Map<String, dynamic>> items,
    String metodoPago = 'EFECTIVO',
    String? notas,
  }) async {
    final uri = Uri.parse('$baseUrl/comandas/crear.php');
    try {
      final response = await http.post(
        uri,
        headers: _getHeaders(),
        body: jsonEncode({
          'codmesa': codmesa,
          'mesa_nombre': mesaNombre,
          'nombre_mesa': mesaNombre,
          'metodo_pago': metodoPago,
          'items': items,
          'notas': notas ?? '',
        }),
      ).timeout(const Duration(seconds: 10));

      final json = jsonDecode(response.body);
      final isSuccess = (response.statusCode == 200 || response.statusCode == 201) &&
          (json['success'] == true || json['status'] == 200);

      if (isSuccess) {
        return ApiResponse(
          success: true,
          message: json['mensaje'] ?? 'Comanda enviada a caja con éxito',
          data: json,
          statusCode: response.statusCode,
        );
      }
      return ApiResponse(
        success: false,
        message: json['mensaje'] ?? json['error'] ?? 'Error al enviar comanda',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'Error de red al enviar comanda: $e',
        statusCode: 500,
      );
    }
  }

  // 7. Get Shift History for currently logged in waitress
  Future<ApiResponse<Map<String, dynamic>>> getHistorialTurno() async {
    final token = storageService.getToken() ?? '';
    final uri = Uri.parse('$baseUrl/comandas/historial_mesera.php?token=$token');
    try {
      final response = await http.get(uri, headers: _getHeaders()).timeout(const Duration(seconds: 8));
      final json = jsonDecode(response.body);
      if (response.statusCode == 200 && (json['status'] == 200 || json['success'] == true)) {
        final resumen = ResumenTurno.fromJson(json['resumen'] ?? {});
        final comandas = (json['comandas'] as List? ?? [])
            .map((c) => Comanda.fromJson(c))
            .toList();

        return ApiResponse(
          success: true,
          message: 'Historial cargado',
          data: {
            'resumen': resumen,
            'comandas': comandas,
          },
          statusCode: 200,
        );
      }
      return ApiResponse(
        success: false,
        message: json['mensaje'] ?? json['error'] ?? 'Error al cargar historial',
        statusCode: response.statusCode,
      );
    } catch (e) {
      return ApiResponse(
        success: false,
        message: 'Error de conexión: $e',
        statusCode: 500,
      );
    }
  }
}
