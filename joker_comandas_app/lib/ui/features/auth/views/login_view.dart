import 'package:flutter/material.dart';
import '../../../core/app_theme.dart';
import '../../../../domain/models/sucursal.dart';
import '../view_models/login_view_model.dart';
import '../../home/home_screen.dart';

class LoginView extends StatefulWidget {
  final LoginViewModel viewModel;

  const LoginView({super.key, required this.viewModel});

  @override
  State<LoginView> createState() => _LoginViewState();
}

class _LoginViewState extends State<LoginView> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      widget.viewModel.init();
    });
  }

  void _showSettingsDialog() {
    final controller = TextEditingController(text: widget.viewModel.currentBaseUrl);
    bool isTesting = false;
    bool? testSuccess;
    String? testMessage;

    showDialog(
      context: context,
      builder: (ctx) => StatefulBuilder(
        builder: (context, setModalState) => AlertDialog(
          backgroundColor: AppColors.surface,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
          title: const Row(
            children: [
              Icon(Icons.settings, color: AppColors.accent),
              SizedBox(width: 8),
              Text('Servidor Ribersoft POS', style: TextStyle(fontSize: 18, color: Colors.white)),
            ],
          ),
          content: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  'Seleccione o ingrese la dirección del servidor:',
                  style: TextStyle(color: AppColors.textSecondary, fontSize: 13),
                ),
                const SizedBox(height: 12),
                TextField(
                  controller: controller,
                  style: const TextStyle(color: Colors.white, fontSize: 13),
                  decoration: InputDecoration(
                    filled: true,
                    fillColor: AppColors.background,
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                    labelText: 'URL de la API',
                    labelStyle: const TextStyle(color: AppColors.textSecondary),
                  ),
                ),
                const SizedBox(height: 12),

                // Presets
                Wrap(
                  spacing: 6,
                  runSpacing: 6,
                  children: [
                    ActionChip(
                      backgroundColor: Colors.blue.withValues(alpha: 0.2),
                      side: const BorderSide(color: Colors.blueAccent),
                      avatar: const Icon(Icons.wifi, size: 14, color: Colors.blueAccent),
                      label: const Text('WiFi (192.168.0.7)', style: TextStyle(color: Colors.white, fontSize: 11, fontWeight: FontWeight.bold)),
                      onPressed: () {
                        setModalState(() {
                          controller.text = 'http://192.168.0.7/pos/api';
                          testSuccess = null;
                          testMessage = null;
                        });
                      },
                    ),
                    ActionChip(
                      backgroundColor: Colors.blue.withValues(alpha: 0.15),
                      side: const BorderSide(color: Colors.blueGrey),
                      avatar: const Icon(Icons.wifi, size: 14, color: Colors.lightBlueAccent),
                      label: const Text('WiFi (192.168.1.70)', style: TextStyle(color: Colors.white, fontSize: 11)),
                      onPressed: () {
                        setModalState(() {
                          controller.text = 'http://192.168.1.70/pos/api';
                          testSuccess = null;
                          testMessage = null;
                        });
                      },
                    ),
                    ActionChip(
                      backgroundColor: AppColors.surfaceVariant,
                      avatar: const Icon(Icons.cloud_outlined, size: 14, color: AppColors.accent),
                      label: const Text('Nube (joker.ribersoft.com)', style: TextStyle(color: Colors.white, fontSize: 11)),
                      onPressed: () {
                        setModalState(() {
                          controller.text = 'https://joker.ribersoft.com/api';
                          testSuccess = null;
                          testMessage = null;
                        });
                      },
                    ),
                    ActionChip(
                      backgroundColor: AppColors.surfaceVariant,
                      avatar: const Icon(Icons.computer, size: 14, color: AppColors.textMuted),
                      label: const Text('pos.test (Solo en PC)', style: TextStyle(color: Colors.white70, fontSize: 11)),
                      onPressed: () {
                        setModalState(() {
                          controller.text = 'http://pos.test/api';
                          testSuccess = null;
                          testMessage = null;
                        });
                      },
                    ),
                  ],
                ),

                const SizedBox(height: 14),

                // Button "PROBAR CONEXIÓN"
                SizedBox(
                  width: double.infinity,
                  height: 42,
                  child: OutlinedButton.icon(
                    style: OutlinedButton.styleFrom(
                      foregroundColor: AppColors.accent,
                      side: const BorderSide(color: AppColors.accent),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                    ),
                    onPressed: isTesting
                        ? null
                        : () async {
                            setModalState(() {
                              isTesting = true;
                              testSuccess = null;
                              testMessage = null;
                            });

                            final ok = await widget.viewModel.testCustomUrl(controller.text);

                            setModalState(() {
                              isTesting = false;
                              testSuccess = ok;
                              testMessage = ok
                                  ? '¡Conexión Exitosa con el Servidor!'
                                  : 'No se pudo conectar. Verifique que el celular esté en el mismo WiFi que la computadora.';
                            });
                          },
                    icon: isTesting
                        ? const SizedBox(
                            width: 16,
                            height: 16,
                            child: CircularProgressIndicator(strokeWidth: 2, color: AppColors.accent),
                          )
                        : const Icon(Icons.network_check, size: 18),
                    label: Text(
                      isTesting ? 'Probando...' : 'PROBAR CONEXIÓN',
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 12),
                    ),
                  ),
                ),

                if (testMessage != null) ...[
                  const SizedBox(height: 10),
                  Container(
                    padding: const EdgeInsets.all(10),
                    decoration: BoxDecoration(
                      color: testSuccess == true
                          ? Colors.green.withValues(alpha: 0.15)
                          : Colors.red.withValues(alpha: 0.15),
                      borderRadius: BorderRadius.circular(8),
                      border: Border.all(
                        color: testSuccess == true ? Colors.green : Colors.red,
                      ),
                    ),
                    child: Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Icon(
                          testSuccess == true ? Icons.check_circle : Icons.error,
                          size: 18,
                          color: testSuccess == true ? Colors.greenAccent : Colors.redAccent,
                        ),
                        const SizedBox(width: 8),
                        Expanded(
                          child: Text(
                            testMessage!,
                            style: TextStyle(
                              fontSize: 12,
                              color: testSuccess == true ? Colors.greenAccent : Colors.redAccent,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],

                const SizedBox(height: 10),
                const Text(
                  '💡 Nota: Los celulares no reconocen "pos.test". Para conectar el celular por WiFi use la opción "WiFi Local (192.168.0.34)".',
                  style: TextStyle(fontSize: 11, color: AppColors.textMuted),
                ),
              ],
            ),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(ctx),
              child: const Text('Cancelar', style: TextStyle(color: AppColors.textMuted)),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.primary,
                foregroundColor: Colors.white,
              ),
              onPressed: () {
                Navigator.pop(ctx);
                widget.viewModel.updateBaseUrl(controller.text);
              },
              child: const Text('Guardar y Reconectar'),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildKeypadButton(String label, {VoidCallback? onTap, IconData? icon}) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(40),
        splashColor: AppColors.primary.withValues(alpha: 0.2),
        child: Container(
          width: 72,
          height: 72,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: AppColors.surface,
            border: Border.all(color: AppColors.surfaceVariant.withValues(alpha: 0.6), width: 1.5),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.25),
                blurRadius: 6,
                offset: const Offset(0, 3),
              ),
            ],
          ),
          child: Center(
            child: icon != null
                ? Icon(icon, color: Colors.white, size: 28)
                : Text(
                    label,
                    style: const TextStyle(
                      color: Colors.white,
                      fontSize: 26,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return ListenableBuilder(
      listenable: widget.viewModel,
      builder: (context, _) {
        final vm = widget.viewModel;

        return Scaffold(
          body: SafeArea(
            child: SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  // Top bar with Settings and Connection Status
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                        decoration: BoxDecoration(
                          color: vm.isConnected ? Colors.green.withValues(alpha: 0.15) : Colors.red.withValues(alpha: 0.15),
                          borderRadius: BorderRadius.circular(12),
                          border: Border.all(
                            color: vm.isConnected ? Colors.green : Colors.red,
                            width: 1,
                          ),
                        ),
                        child: Row(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            Icon(
                              Icons.circle,
                              size: 10,
                              color: vm.isConnected ? Colors.greenAccent : Colors.redAccent,
                            ),
                            const SizedBox(width: 6),
                            Text(
                              vm.isConnected ? 'ONLINE' : 'SIN CONEXIÓN',
                              style: TextStyle(
                                fontSize: 11,
                                fontWeight: FontWeight.bold,
                                color: vm.isConnected ? Colors.greenAccent : Colors.redAccent,
                              ),
                            ),
                          ],
                        ),
                      ),
                      IconButton(
                        icon: const Icon(Icons.settings_outlined, color: AppColors.textSecondary),
                        onPressed: _showSettingsDialog,
                        tooltip: 'Configurar Servidor',
                      ),
                    ],
                  ),

                  const SizedBox(height: 10),

                  // 3D Circular Joker Logo
                  Container(
                    width: 115,
                    height: 115,
                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      border: Border.all(color: AppColors.accent.withValues(alpha: 0.8), width: 3),
                      boxShadow: [
                        BoxShadow(
                          color: AppColors.accent.withValues(alpha: 0.2),
                          blurRadius: 16,
                          spreadRadius: 2,
                        ),
                      ],
                    ),
                    child: ClipOval(
                      child: Image.asset(
                        'assets/images/joker_logo.jpg',
                        fit: BoxFit.cover,
                        errorBuilder: (context, error, stackTrace) => Container(
                          color: AppColors.surface,
                          child: const Icon(Icons.sports_bar, size: 50, color: AppColors.accent),
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 14),

                  const Text(
                    'JOKER BILLAR & BAR',
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.w900,
                      letterSpacing: 1.5,
                      color: Colors.white,
                    ),
                  ),
                  const Text(
                    'Comandas Móviles para Meseras',
                    style: TextStyle(fontSize: 13, color: AppColors.textSecondary),
                  ),

                  const SizedBox(height: 16),

                  // Branch selector dropdown
                  if (vm.sucursales.isNotEmpty) ...[
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 4),
                      decoration: BoxDecoration(
                        color: AppColors.surface,
                        borderRadius: BorderRadius.circular(14),
                        border: Border.all(color: AppColors.surfaceVariant),
                      ),
                      child: DropdownButtonHideUnderline(
                        child: DropdownButton<Sucursal>(
                          value: vm.selectedSucursal,
                          isExpanded: true,
                          dropdownColor: AppColors.surface,
                          icon: const Icon(Icons.arrow_drop_down, color: AppColors.primary),
                          items: vm.sucursales.map((suc) {
                            return DropdownMenuItem<Sucursal>(
                              value: suc,
                              child: Row(
                                children: [
                                  Icon(
                                    Icons.storefront,
                                    size: 18,
                                    color: suc.cajaAbierta ? AppColors.primary : AppColors.danger,
                                  ),
                                  const SizedBox(width: 8),
                                  Expanded(
                                    child: Text(
                                      suc.nombresucursal,
                                      style: const TextStyle(
                                        color: Colors.white,
                                        fontWeight: FontWeight.w600,
                                        fontSize: 14,
                                      ),
                                    ),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                    decoration: BoxDecoration(
                                      color: suc.cajaAbierta
                                          ? Colors.green.withValues(alpha: 0.2)
                                          : Colors.red.withValues(alpha: 0.2),
                                      borderRadius: BorderRadius.circular(8),
                                    ),
                                    child: Text(
                                      suc.cajaAbierta ? 'Caja Abierta' : 'Cerrada',
                                      style: TextStyle(
                                        fontSize: 11,
                                        color: suc.cajaAbierta ? Colors.greenAccent : Colors.redAccent,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          }).toList(),
                          onChanged: (val) {
                            if (val != null) vm.selectSucursal(val);
                          },
                        ),
                      ),
                    ),
                  ],

                  const SizedBox(height: 20),

                  // PIN Prompt
                  const Text(
                    'INGRESE SU PIN DE MESERA',
                    style: TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.bold,
                      letterSpacing: 1.1,
                      color: AppColors.textSecondary,
                    ),
                  ),

                  const SizedBox(height: 12),

                  // 4 Dots indicator
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: List.generate(4, (index) {
                      final isFilled = index < vm.pin.length;
                      return AnimatedContainer(
                        duration: const Duration(milliseconds: 200),
                        margin: const EdgeInsets.symmetric(horizontal: 10),
                        width: 18,
                        height: 18,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: isFilled ? AppColors.primary : Colors.transparent,
                          border: Border.all(
                            color: isFilled ? AppColors.primary : AppColors.border,
                            width: 2,
                          ),
                          boxShadow: isFilled
                              ? [
                                  BoxShadow(
                                    color: AppColors.primary.withValues(alpha: 0.5),
                                    blurRadius: 8,
                                    spreadRadius: 1,
                                  ),
                                ]
                              : [],
                        ),
                      );
                    }),
                  ),

                  const SizedBox(height: 12),

                  // Error or loading indicator
                  if (vm.isLoading) ...[
                    const Padding(
                      padding: EdgeInsets.symmetric(vertical: 8.0),
                      child: SizedBox(
                        height: 20,
                        width: 20,
                        child: CircularProgressIndicator(strokeWidth: 2, color: AppColors.primary),
                      ),
                    ),
                  ] else if (vm.errorMessage != null) ...[
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 12.0, vertical: 6.0),
                      child: Text(
                        vm.errorMessage!,
                        textAlign: TextAlign.center,
                        style: const TextStyle(color: AppColors.danger, fontSize: 13, fontWeight: FontWeight.w500),
                      ),
                    ),
                  ] else ...[
                    const SizedBox(height: 24),
                  ],

                  // Keypad Grid
                  SizedBox(
                    width: 260,
                    child: Column(
                      children: [
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            _buildKeypadButton('1', onTap: () => vm.appendDigit('1', _onLoginSuccess)),
                            _buildKeypadButton('2', onTap: () => vm.appendDigit('2', _onLoginSuccess)),
                            _buildKeypadButton('3', onTap: () => vm.appendDigit('3', _onLoginSuccess)),
                          ],
                        ),
                        const SizedBox(height: 12),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            _buildKeypadButton('4', onTap: () => vm.appendDigit('4', _onLoginSuccess)),
                            _buildKeypadButton('5', onTap: () => vm.appendDigit('5', _onLoginSuccess)),
                            _buildKeypadButton('6', onTap: () => vm.appendDigit('6', _onLoginSuccess)),
                          ],
                        ),
                        const SizedBox(height: 12),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            _buildKeypadButton('7', onTap: () => vm.appendDigit('7', _onLoginSuccess)),
                            _buildKeypadButton('8', onTap: () => vm.appendDigit('8', _onLoginSuccess)),
                            _buildKeypadButton('9', onTap: () => vm.appendDigit('9', _onLoginSuccess)),
                          ],
                        ),
                        const SizedBox(height: 12),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            _buildKeypadButton('C', onTap: vm.clearPin),
                            _buildKeypadButton('0', onTap: () => vm.appendDigit('0', _onLoginSuccess)),
                            _buildKeypadButton('', icon: Icons.backspace_outlined, onTap: vm.deleteDigit),
                          ],
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 24),

                  // Developer Branding Footer
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    decoration: BoxDecoration(
                      color: AppColors.surface.withValues(alpha: 0.5),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Column(
                      children: [
                        Text(
                          '<> Desarrollado por: ING. DANIEL MÉNDEZ',
                          style: TextStyle(
                            fontSize: 11,
                            fontWeight: FontWeight.bold,
                            color: AppColors.textSecondary,
                            letterSpacing: 0.8,
                          ),
                        ),
                        SizedBox(height: 2),
                        Text(
                          'Ribersoft POS v2.0 • Joker Billar',
                          style: TextStyle(fontSize: 10, color: AppColors.textMuted),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }

  void _onLoginSuccess() {
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(builder: (_) => const HomeScreen()),
    );
  }
}
