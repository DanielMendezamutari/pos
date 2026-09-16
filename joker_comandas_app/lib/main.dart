import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'data/services/storage_service.dart';
import 'data/services/api_service.dart';
import 'ui/core/app_theme.dart';
import 'ui/features/auth/view_models/login_view_model.dart';
import 'ui/features/auth/views/login_view.dart';
import 'ui/features/home/home_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Dark navigation bar and status bar
  SystemChrome.setSystemUIOverlayStyle(
    const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.light,
      systemNavigationBarColor: AppColors.background,
      systemNavigationBarIconBrightness: Brightness.light,
    ),
  );

  final storage = await StorageService.init();
  final api = ApiService(storage);

  runApp(JokerComandasApp(
    storageService: storage,
    apiService: api,
  ));
}

class JokerComandasApp extends StatelessWidget {
  final StorageService storageService;
  final ApiService apiService;

  const JokerComandasApp({
    super.key,
    required this.storageService,
    required this.apiService,
  });

  @override
  Widget build(BuildContext context) {
    final hasToken = storageService.getToken() != null && storageService.getToken()!.isNotEmpty;

    return MaterialApp(
      title: 'Joker Comandas',
      debugShowCheckedModeBanner: false,
      theme: AppTheme.darkTheme,
      home: hasToken
          ? const HomeScreen()
          : LoginView(
              viewModel: LoginViewModel(
                apiService: apiService,
                storageService: storageService,
              ),
            ),
    );
  }
}
