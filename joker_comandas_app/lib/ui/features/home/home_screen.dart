import 'package:flutter/material.dart';
import '../../core/app_theme.dart';
import '../../../data/services/api_service.dart';
import '../../../data/services/storage_service.dart';
import '../comanda/view_models/comanda_view_model.dart';
import '../comanda/views/comanda_view.dart';
import '../turno/view_models/turno_view_model.dart';
import '../turno/views/turno_view.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _currentIndex = 0;

  late final StorageService _storageService;
  late final ApiService _apiService;
  late final ComandaViewModel _comandaViewModel;
  late final TurnoViewModel _turnoViewModel;
  bool _initialized = false;

  @override
  void initState() {
    super.initState();
    _initServices();
  }

  Future<void> _initServices() async {
    _storageService = await StorageService.init();
    _apiService = ApiService(_storageService);
    _comandaViewModel = ComandaViewModel(
      apiService: _apiService,
      storageService: _storageService,
    );
    _turnoViewModel = TurnoViewModel(
      apiService: _apiService,
      storageService: _storageService,
    );

    setState(() {
      _initialized = true;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (!_initialized) {
      return const Scaffold(
        backgroundColor: AppColors.background,
        body: Center(child: CircularProgressIndicator(color: AppColors.primary)),
      );
    }

    final pages = [
      ComandaView(viewModel: _comandaViewModel),
      TurnoView(
        viewModel: _turnoViewModel,
        storageService: _storageService,
        apiService: _apiService,
      ),
    ];

    return Scaffold(
      body: IndexedStack(
        index: _currentIndex,
        children: pages,
      ),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (idx) {
          setState(() {
            _currentIndex = idx;
          });
          if (idx == 1) {
            _turnoViewModel.loadHistorial();
          }
        },
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.sports_bar_outlined),
            activeIcon: Icon(Icons.sports_bar),
            label: 'Comandas',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.access_time_outlined),
            activeIcon: Icon(Icons.access_time_filled),
            label: 'Mi Turno',
          ),
        ],
      ),
    );
  }
}
