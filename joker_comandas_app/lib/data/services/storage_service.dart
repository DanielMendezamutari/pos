import 'package:shared_preferences/shared_preferences.dart';

class StorageService {
  static const String _keyBaseUrl = 'api_base_url';
  static const String _keyToken = 'jwt_token';
  static const String _keySucursalId = 'codsucursal';
  static const String _keySucursalNombre = 'nombresucursal';
  static const String _keyMeseraId = 'codmesera';
  static const String _keyMeseraNombre = 'mesera_nombre';

  static const String defaultLocalUrl = 'http://192.168.0.2/pos/api';
  static const String defaultCloudUrl = 'https://joker.ribersoft.com/api';

  final SharedPreferences _prefs;

  StorageService(this._prefs);

  static Future<StorageService> init() async {
    final prefs = await SharedPreferences.getInstance();
    return StorageService(prefs);
  }

  String getBaseUrl() {
    return _prefs.getString(_keyBaseUrl) ?? defaultLocalUrl;
  }

  Future<void> setBaseUrl(String url) async {
    String cleanUrl = url.trim();
    if (cleanUrl.endsWith('/')) {
      cleanUrl = cleanUrl.substring(0, cleanUrl.length - 1);
    }
    await _prefs.setString(_keyBaseUrl, cleanUrl);
  }

  String? getToken() => _prefs.getString(_keyToken);

  Future<void> setToken(String token) async {
    await _prefs.setString(_keyToken, token);
  }

  int getSucursalId() => _prefs.getInt(_keySucursalId) ?? 3; // Default Ultra (3)

  Future<void> setSucursalId(int id) async {
    await _prefs.setInt(_keySucursalId, id);
  }

  String getSucursalNombre() => _prefs.getString(_keySucursalNombre) ?? 'Sucursal Ultra';

  Future<void> setSucursalNombre(String nombre) async {
    await _prefs.setString(_keySucursalNombre, nombre);
  }

  int? getMeseraId() => _prefs.getInt(_keyMeseraId);

  Future<void> setMeseraId(int id) async {
    await _prefs.setInt(_keyMeseraId, id);
  }

  String? getMeseraNombre() => _prefs.getString(_keyMeseraNombre);

  Future<void> setMeseraNombre(String nombre) async {
    await _prefs.setString(_keyMeseraNombre, nombre);
  }

  Future<void> clearAuth() async {
    await _prefs.remove(_keyToken);
    await _prefs.remove(_keyMeseraId);
    await _prefs.remove(_keyMeseraNombre);
  }
}
