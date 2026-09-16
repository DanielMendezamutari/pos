import 'package:flutter/material.dart';
import '../../../core/app_theme.dart';
import '../view_models/turno_view_model.dart';
import '../../auth/views/login_view.dart';
import '../../auth/view_models/login_view_model.dart';
import '../../../../data/services/api_service.dart';
import '../../../../data/services/storage_service.dart';

class TurnoView extends StatefulWidget {
  final TurnoViewModel viewModel;
  final StorageService storageService;
  final ApiService apiService;

  const TurnoView({
    super.key,
    required this.viewModel,
    required this.storageService,
    required this.apiService,
  });

  @override
  State<TurnoView> createState() => _TurnoViewState();
}

class _TurnoViewState extends State<TurnoView> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      widget.viewModel.loadHistorial();
    });
  }

  void _confirmLogout() {
    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        backgroundColor: AppColors.surface,
        title: const Text('Cerrar Sesión de Mesera', style: TextStyle(color: Colors.white, fontSize: 18)),
        content: const Text(
          '¿Desea salir de su sesión actual?',
          style: TextStyle(color: AppColors.textSecondary),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(ctx),
            child: const Text('Cancelar', style: TextStyle(color: AppColors.textMuted)),
          ),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: AppColors.danger),
            onPressed: () {
              Navigator.pop(ctx);
              widget.viewModel.logout(() {
                Navigator.of(context).pushAndRemoveUntil(
                  MaterialPageRoute(
                    builder: (_) => LoginView(
                      viewModel: LoginViewModel(
                        apiService: widget.apiService,
                        storageService: widget.storageService,
                      ),
                    ),
                  ),
                  (route) => false,
                );
              });
            },
            child: const Text('Salir', style: TextStyle(color: Colors.white)),
          ),
        ],
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
          appBar: AppBar(
            title: Text('Mi Turno: ${vm.meseraNombre}'),
            actions: [
              IconButton(
                icon: const Icon(Icons.refresh),
                onPressed: vm.loadHistorial,
                tooltip: 'Actualizar historial',
              ),
              IconButton(
                icon: const Icon(Icons.logout, color: AppColors.danger),
                onPressed: _confirmLogout,
                tooltip: 'Cerrar sesión',
              ),
            ],
          ),
          body: RefreshIndicator(
            color: AppColors.primary,
            onRefresh: vm.loadHistorial,
            child: vm.isLoading && vm.resumen == null
                ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
                : SingleChildScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    padding: const EdgeInsets.all(14),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // 1. Shift Balance Cards
                        Row(
                          children: [
                            Expanded(
                              child: Container(
                                padding: const EdgeInsets.all(14),
                                decoration: BoxDecoration(
                                  color: AppColors.surface,
                                  borderRadius: BorderRadius.circular(16),
                                  border: Border.all(color: Colors.green.withValues(alpha: 0.3)),
                                ),
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    const Row(
                                      children: [
                                        Icon(Icons.check_circle, color: Colors.greenAccent, size: 16),
                                        SizedBox(width: 6),
                                        Text('Cobrado en Caja', style: TextStyle(fontSize: 12, color: AppColors.textSecondary)),
                                      ],
                                    ),
                                    const SizedBox(height: 8),
                                    Text(
                                      'Bs. ${vm.resumen?.totalCobrado.toStringAsFixed(2) ?? "0.00"}',
                                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: Colors.greenAccent),
                                    ),
                                    Text(
                                      '${vm.resumen?.cantCobrada ?? 0} comandas',
                                      style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                            const SizedBox(width: 10),
                            Expanded(
                              child: Container(
                                padding: const EdgeInsets.all(14),
                                decoration: BoxDecoration(
                                  color: AppColors.surface,
                                  borderRadius: BorderRadius.circular(16),
                                  border: Border.all(color: Colors.amber.withValues(alpha: 0.3)),
                                ),
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    const Row(
                                      children: [
                                        Icon(Icons.hourglass_top, color: Colors.amberAccent, size: 16),
                                        SizedBox(width: 6),
                                        Text('Pendiente Caja', style: TextStyle(fontSize: 12, color: AppColors.textSecondary)),
                                      ],
                                    ),
                                    const SizedBox(height: 8),
                                    Text(
                                      'Bs. ${vm.resumen?.totalPendiente.toStringAsFixed(2) ?? "0.00"}',
                                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: Colors.amberAccent),
                                    ),
                                    Text(
                                      '${vm.resumen?.cantPendiente ?? 0} pendientes',
                                      style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ],
                        ),

                        const SizedBox(height: 20),

                        const Text(
                          'Comandas del Turno Actual',
                          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.white),
                        ),
                        const SizedBox(height: 10),

                        // 2. Orders Timeline List
                        if (vm.comandas.isEmpty)
                          Container(
                            width: double.infinity,
                            padding: const EdgeInsets.all(28),
                            decoration: BoxDecoration(
                              color: AppColors.surface,
                              borderRadius: BorderRadius.circular(16),
                            ),
                            child: const Column(
                              children: [
                                Icon(Icons.receipt_long, size: 48, color: AppColors.textMuted),
                                SizedBox(height: 10),
                                Text(
                                  'Aún no has registrado comandas en este turno',
                                  style: TextStyle(color: AppColors.textMuted, fontSize: 13),
                                ),
                              ],
                            ),
                          )
                        else
                          ListView.separated(
                            shrinkWrap: true,
                            physics: const NeverScrollableScrollPhysics(),
                            itemCount: vm.comandas.length,
                            separatorBuilder: (_, _) => const SizedBox(height: 10),
                            itemBuilder: (context, index) {
                              final cmd = vm.comandas[index];
                              return Container(
                                padding: const EdgeInsets.all(14),
                                decoration: BoxDecoration(
                                  color: AppColors.surface,
                                  borderRadius: BorderRadius.circular(16),
                                  border: Border.all(
                                    color: cmd.isCobrado
                                        ? Colors.green.withValues(alpha: 0.3)
                                        : Colors.amber.withValues(alpha: 0.4),
                                  ),
                                ),
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        Row(
                                          children: [
                                            Container(
                                              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                              decoration: BoxDecoration(
                                                color: AppColors.surfaceVariant,
                                                borderRadius: BorderRadius.circular(8),
                                              ),
                                              child: Text(
                                                cmd.mesaNombre,
                                                style: const TextStyle(
                                                  fontWeight: FontWeight.bold,
                                                  color: Colors.white,
                                                  fontSize: 13,
                                                ),
                                              ),
                                            ),
                                            const SizedBox(width: 8),
                                            Text(
                                              cmd.tiempoTranscurrido,
                                              style: const TextStyle(fontSize: 11, color: AppColors.textMuted),
                                            ),
                                          ],
                                        ),
                                        Container(
                                          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                                          decoration: BoxDecoration(
                                            color: cmd.isCobrado
                                                ? Colors.green.withValues(alpha: 0.2)
                                                : Colors.amber.withValues(alpha: 0.2),
                                            borderRadius: BorderRadius.circular(8),
                                          ),
                                          child: Text(
                                            cmd.isCobrado ? 'COBRADO' : 'PENDIENTE',
                                            style: TextStyle(
                                              fontSize: 11,
                                              fontWeight: FontWeight.bold,
                                              color: cmd.isCobrado ? Colors.greenAccent : Colors.amberAccent,
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                    const SizedBox(height: 8),
                                    // Items summary
                                    Wrap(
                                      spacing: 6,
                                      runSpacing: 4,
                                      children: cmd.items.map((it) {
                                        return Container(
                                          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                                          decoration: BoxDecoration(
                                            color: AppColors.surfaceVariant.withValues(alpha: 0.5),
                                            borderRadius: BorderRadius.circular(6),
                                          ),
                                          child: Text(
                                            '${it.cantidad}x ${it.producto.nombre}',
                                            style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                                          ),
                                        );
                                      }).toList(),
                                    ),
                                    const SizedBox(height: 10),
                                    Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text(
                                          'Pago: ${cmd.metodoPagoSugerido}',
                                          style: const TextStyle(fontSize: 12, color: AppColors.textMuted),
                                        ),
                                        Text(
                                          'Bs. ${cmd.total.toStringAsFixed(2)}',
                                          style: const TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.bold,
                                            color: AppColors.accent,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ],
                                ),
                              );
                            },
                          ),
                      ],
                    ),
                  ),
          ),
        );
      },
    );
  }
}
