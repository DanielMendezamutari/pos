import 'package:flutter/material.dart';
import '../../../core/app_theme.dart';
import '../view_models/comanda_view_model.dart';

class ComandaView extends StatefulWidget {
  final ComandaViewModel viewModel;

  const ComandaView({super.key, required this.viewModel});

  @override
  State<ComandaView> createState() => _ComandaViewState();
}

class _ComandaViewState extends State<ComandaView> {
  final TextEditingController _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      widget.viewModel.loadCatalog();
    });
  }

  void _showCartSheet() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: AppColors.surface,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(24)),
      ),
      builder: (ctx) {
        return ListenableBuilder(
          listenable: widget.viewModel,
          builder: (context, _) {
            final vm = widget.viewModel;
            return Container(
              padding: const EdgeInsets.fromLTRB(20, 16, 20, 24),
              constraints: BoxConstraints(
                maxHeight: MediaQuery.of(context).size.height * 0.85,
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Handle bar
                  Center(
                    child: Container(
                      width: 40,
                      height: 4,
                      decoration: BoxDecoration(
                        color: AppColors.surfaceVariant,
                        borderRadius: BorderRadius.circular(2),
                      ),
                    ),
                  ),
                  const SizedBox(height: 14),

                  // Sheet Header
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text(
                            'Confirmar Comanda',
                            style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.white),
                          ),
                          Text(
                            'Destino: ${vm.selectedMesa?.nombre ?? 'Barra'}',
                            style: const TextStyle(fontSize: 13, color: AppColors.primary),
                          ),
                        ],
                      ),
                      TextButton.icon(
                        onPressed: () {
                          vm.clearCart();
                          Navigator.pop(ctx);
                        },
                        icon: const Icon(Icons.delete_outline, size: 18, color: AppColors.danger),
                        label: const Text('Vaciar', style: TextStyle(color: AppColors.danger, fontSize: 13)),
                      ),
                    ],
                  ),
                  const Divider(color: AppColors.surfaceVariant, height: 20),

                  // Cart items list
                  Expanded(
                    child: vm.cart.isEmpty
                        ? const Center(
                            child: Text('No hay productos en el pedido', style: TextStyle(color: AppColors.textMuted)),
                          )
                        : ListView.separated(
                            itemCount: vm.cart.length,
                            separatorBuilder: (_, _) => const Divider(color: AppColors.surfaceVariant, height: 1),
                            itemBuilder: (context, index) {
                              final item = vm.cart[index];
                              return Padding(
                                padding: const EdgeInsets.symmetric(vertical: 8.0),
                                child: Row(
                                  children: [
                                    Expanded(
                                      child: Column(
                                        crossAxisAlignment: CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            item.producto.nombre,
                                            style: const TextStyle(
                                              fontWeight: FontWeight.w600,
                                              color: Colors.white,
                                              fontSize: 14,
                                            ),
                                          ),
                                          Text(
                                            'Bs. ${item.producto.precio.toStringAsFixed(2)} c/u',
                                            style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                                          ),
                                        ],
                                      ),
                                    ),
                                    // Quantity selector
                                    Row(
                                      children: [
                                        IconButton(
                                          icon: const Icon(Icons.remove_circle_outline, color: AppColors.accent, size: 22),
                                          onPressed: () => vm.decreaseQuantity(item),
                                        ),
                                        Text(
                                          '${item.cantidad}',
                                          style: const TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.bold,
                                            color: Colors.white,
                                          ),
                                        ),
                                        IconButton(
                                          icon: const Icon(Icons.add_circle_outline, color: AppColors.primary, size: 22),
                                          onPressed: () => vm.addToCart(item.producto),
                                        ),
                                      ],
                                    ),
                                    SizedBox(
                                      width: 65,
                                      child: Text(
                                        'Bs. ${item.subtotal.toStringAsFixed(2)}',
                                        textAlign: TextAlign.end,
                                        style: const TextStyle(
                                          fontWeight: FontWeight.bold,
                                          color: AppColors.accent,
                                          fontSize: 14,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              );
                            },
                          ),
                  ),

                  const SizedBox(height: 12),

                  // Payment method selector
                  const Text(
                    'Método de Pago con el que cobra la mesera:',
                    style: TextStyle(color: AppColors.textSecondary, fontSize: 12, fontWeight: FontWeight.w500),
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      Expanded(
                        child: ChoiceChip(
                          label: const Center(child: Text('💵 Efectivo')),
                          selected: vm.metodoPago == 'EFECTIVO',
                          selectedColor: AppColors.primary.withValues(alpha: 0.25),
                          backgroundColor: AppColors.surfaceVariant,
                          labelStyle: TextStyle(
                            color: vm.metodoPago == 'EFECTIVO' ? AppColors.primaryLight : Colors.white70,
                            fontWeight: FontWeight.bold,
                          ),
                          onSelected: (_) => vm.setMetodoPago('EFECTIVO'),
                        ),
                      ),
                      const SizedBox(width: 8),
                      Expanded(
                        child: ChoiceChip(
                          label: const Center(child: Text('📱 QR')),
                          selected: vm.metodoPago == 'QR',
                          selectedColor: AppColors.accent.withValues(alpha: 0.25),
                          backgroundColor: AppColors.surfaceVariant,
                          labelStyle: TextStyle(
                            color: vm.metodoPago == 'QR' ? AppColors.accent : Colors.white70,
                            fontWeight: FontWeight.bold,
                          ),
                          onSelected: (_) => vm.setMetodoPago('QR'),
                        ),
                      ),
                    ],
                  ),

                  const SizedBox(height: 16),

                  // Total & Send Button
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      const Text(
                        'Total a Pagar:',
                        style: TextStyle(fontSize: 16, color: AppColors.textSecondary),
                      ),
                      Text(
                        'Bs. ${vm.cartTotal.toStringAsFixed(2)}',
                        style: const TextStyle(
                          fontSize: 22,
                          fontWeight: FontWeight.bold,
                          color: AppColors.accent,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 14),

                  SizedBox(
                    width: double.infinity,
                    height: 52,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary,
                        foregroundColor: Colors.white,
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                        elevation: 4,
                      ),
                      onPressed: vm.isSubmitting || vm.cart.isEmpty
                          ? null
                          : () async {
                              final scaffoldMessenger = ScaffoldMessenger.of(context);
                              final navigator = Navigator.of(ctx);
                              final ok = await vm.sendComanda();
                              if (!mounted) return;
                              if (ok) {
                                navigator.pop();
                                scaffoldMessenger.showSnackBar(
                                  SnackBar(
                                    backgroundColor: Colors.green.shade800,
                                    content: Row(
                                      children: [
                                        const Icon(Icons.check_circle, color: Colors.white),
                                        const SizedBox(width: 10),
                                        Expanded(
                                          child: Text(
                                            vm.successMessage ?? 'Comanda enviada a caja',
                                            style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                                          ),
                                        ),
                                      ],
                                    ),
                                    duration: const Duration(seconds: 3),
                                  ),
                                );
                              } else {
                                scaffoldMessenger.showSnackBar(
                                  SnackBar(
                                    backgroundColor: Colors.red.shade800,
                                    content: Row(
                                      children: [
                                        const Icon(Icons.error_outline, color: Colors.white),
                                        const SizedBox(width: 10),
                                        Expanded(
                                          child: Text(
                                            vm.errorMessage ?? 'Error al enviar comanda a caja',
                                            style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                                          ),
                                        ),
                                      ],
                                    ),
                                    duration: const Duration(seconds: 4),
                                  ),
                                );
                              }
                            },
                      child: vm.isSubmitting
                          ? const CircularProgressIndicator(color: Colors.white)
                          : const Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Icon(Icons.send_rounded),
                                SizedBox(width: 8),
                                Text(
                                  'ENVIAR A CAJA PARA COBRAR',
                                  style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold, letterSpacing: 0.8),
                                ),
                              ],
                            ),
                    ),
                  ),
                ],
              ),
            );
          },
        );
      },
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
            title: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                const Icon(Icons.person, size: 18, color: AppColors.primary),
                const SizedBox(width: 6),
                Text(
                  vm.meseraNombre,
                  style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                ),
                Text(
                  ' • ${vm.sucursalNombre}',
                  style: const TextStyle(fontSize: 12, color: AppColors.textSecondary),
                ),
              ],
            ),
            actions: [
              IconButton(
                icon: const Icon(Icons.refresh),
                onPressed: vm.loadCatalog,
                tooltip: 'Actualizar catálogo',
              ),
            ],
          ),
          body: Column(
            children: [
              // 1. Table Selector Carousel
              Container(
                height: 48,
                margin: const EdgeInsets.symmetric(vertical: 6),
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  padding: const EdgeInsets.symmetric(horizontal: 14),
                  itemCount: vm.mesas.length,
                  itemBuilder: (context, index) {
                    final mesa = vm.mesas[index];
                    final isSelected = vm.selectedMesa?.id == mesa.id;
                    return Padding(
                      padding: const EdgeInsets.only(right: 8),
                      child: ChoiceChip(
                        avatar: Icon(
                          Icons.table_restaurant,
                          size: 16,
                          color: isSelected ? Colors.white : AppColors.textSecondary,
                        ),
                        label: Text(mesa.nombre),
                        selected: isSelected,
                        selectedColor: AppColors.primary,
                        backgroundColor: AppColors.surface,
                        labelStyle: TextStyle(
                          color: isSelected ? Colors.white : AppColors.textSecondary,
                          fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                        ),
                        onSelected: (_) => vm.selectMesa(mesa),
                      ),
                    );
                  },
                ),
              ),

              // 2. Search Box
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 4),
                child: TextField(
                  controller: _searchController,
                  onChanged: vm.setSearchQuery,
                  style: const TextStyle(color: Colors.white, fontSize: 14),
                  decoration: InputDecoration(
                    hintText: 'Buscar cerveza, trago, combo...',
                    hintStyle: const TextStyle(color: AppColors.textMuted, fontSize: 13),
                    prefixIcon: const Icon(Icons.search, color: AppColors.textSecondary, size: 20),
                    suffixIcon: _searchController.text.isNotEmpty
                        ? IconButton(
                            icon: const Icon(Icons.close, size: 18, color: AppColors.textSecondary),
                            onPressed: () {
                              _searchController.clear();
                              vm.setSearchQuery('');
                            },
                          )
                        : null,
                    filled: true,
                    fillColor: AppColors.surface,
                    contentPadding: const EdgeInsets.symmetric(vertical: 0, horizontal: 16),
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: BorderSide.none,
                    ),
                  ),
                ),
              ),

              // 3. Category Filter Chips
              Container(
                height: 40,
                margin: const EdgeInsets.symmetric(vertical: 6),
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  padding: const EdgeInsets.symmetric(horizontal: 14),
                  itemCount: vm.categorias.length,
                  itemBuilder: (context, index) {
                    final cat = vm.categorias[index];
                    final isSelected = vm.selectedCategoria == cat;
                    return Padding(
                      padding: const EdgeInsets.only(right: 6),
                      child: FilterChip(
                        label: Text(cat),
                        selected: isSelected,
                        selectedColor: AppColors.accent.withValues(alpha: 0.2),
                        backgroundColor: AppColors.surface,
                        checkmarkColor: AppColors.accent,
                        labelStyle: TextStyle(
                          color: isSelected ? AppColors.accent : AppColors.textMuted,
                          fontSize: 12,
                          fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                        ),
                        side: BorderSide(
                          color: isSelected ? AppColors.accent : Colors.transparent,
                        ),
                        onSelected: (_) => vm.selectCategoria(cat),
                      ),
                    );
                  },
                ),
              ),

              // 4. Products Grid
              Expanded(
                child: vm.isLoading
                    ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
                    : vm.errorMessage != null
                        ? Center(
                            child: Padding(
                              padding: const EdgeInsets.symmetric(horizontal: 24),
                              child: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  const Icon(Icons.cloud_off, size: 52, color: AppColors.danger),
                                  const SizedBox(height: 12),
                                  Text(
                                    vm.errorMessage!,
                                    textAlign: TextAlign.center,
                                    style: const TextStyle(color: Colors.white70, fontSize: 13),
                                  ),
                                  const SizedBox(height: 16),
                                  ElevatedButton.icon(
                                    onPressed: vm.loadCatalog,
                                    icon: const Icon(Icons.refresh, size: 18),
                                    label: const Text('Reintentar conexión'),
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: AppColors.primary,
                                      foregroundColor: Colors.white,
                                      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          )
                        : vm.filteredProductos.isEmpty
                            ? Center(
                                child: Column(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  children: [
                                    const Icon(Icons.inventory_2_outlined, size: 48, color: AppColors.textMuted),
                                    const SizedBox(height: 10),
                                    const Text(
                                      'No se encontraron productos',
                                      style: TextStyle(color: AppColors.textMuted, fontSize: 14),
                                    ),
                                    const SizedBox(height: 10),
                                    TextButton.icon(
                                      onPressed: vm.loadCatalog,
                                      icon: const Icon(Icons.refresh, size: 16),
                                      label: const Text('Recargar'),
                                    ),
                                  ],
                                ),
                              )
                        : GridView.builder(
                            padding: const EdgeInsets.fromLTRB(14, 6, 14, 80),
                            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                              crossAxisCount: 2,
                              childAspectRatio: 1.25,
                              crossAxisSpacing: 10,
                              mainAxisSpacing: 10,
                            ),
                            itemCount: vm.filteredProductos.length,
                            itemBuilder: (context, index) {
                              final prod = vm.filteredProductos[index];
                              return InkWell(
                                onTap: () => vm.addToCart(prod),
                                borderRadius: BorderRadius.circular(14),
                                child: Container(
                                  padding: const EdgeInsets.all(12),
                                  decoration: BoxDecoration(
                                    color: AppColors.surface,
                                    borderRadius: BorderRadius.circular(14),
                                    border: Border.all(
                                      color: prod.isCombo
                                          ? AppColors.accent.withValues(alpha: 0.4)
                                          : AppColors.surfaceVariant.withValues(alpha: 0.5),
                                    ),
                                  ),
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                        children: [
                                          Container(
                                            padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                                            decoration: BoxDecoration(
                                              color: prod.isCombo
                                                  ? AppColors.accent.withValues(alpha: 0.2)
                                                  : AppColors.surfaceVariant,
                                              borderRadius: BorderRadius.circular(6),
                                            ),
                                            child: Text(
                                              prod.isCombo ? 'COMBO' : prod.categoria,
                                              style: TextStyle(
                                                fontSize: 10,
                                                fontWeight: FontWeight.bold,
                                                color: prod.isCombo ? AppColors.accent : AppColors.textSecondary,
                                              ),
                                            ),
                                          ),
                                          const Icon(Icons.add_circle, color: AppColors.primary, size: 22),
                                        ],
                                      ),
                                      Text(
                                        prod.nombre,
                                        maxLines: 2,
                                        overflow: TextOverflow.ellipsis,
                                        style: const TextStyle(
                                          fontWeight: FontWeight.bold,
                                          fontSize: 13,
                                          color: Colors.white,
                                        ),
                                      ),
                                      Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                        children: [
                                          Text(
                                            'Bs. ${prod.precio.toStringAsFixed(2)}',
                                            style: const TextStyle(
                                              fontSize: 15,
                                              fontWeight: FontWeight.bold,
                                              color: AppColors.accent,
                                            ),
                                          ),
                                          if (!prod.isCombo)
                                            Text(
                                              'Stk: ${prod.stock.toInt()}',
                                              style: TextStyle(
                                                fontSize: 11,
                                                color: prod.stock <= 5 ? AppColors.danger : AppColors.textMuted,
                                              ),
                                            ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),
                              );
                            },
                          ),
              ),
            ],
          ),
          bottomSheet: vm.cartCount > 0
              ? Container(
                  padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
                  decoration: BoxDecoration(
                    color: AppColors.surface,
                    border: const Border(top: BorderSide(color: AppColors.surfaceVariant)),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withValues(alpha: 0.4),
                        blurRadius: 10,
                        offset: const Offset(0, -2),
                      ),
                    ],
                  ),
                  child: Row(
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                        decoration: BoxDecoration(
                          color: AppColors.primary.withValues(alpha: 0.2),
                          borderRadius: BorderRadius.circular(20),
                          border: Border.all(color: AppColors.primary),
                        ),
                        child: Text(
                          '${vm.cartCount} items',
                          style: const TextStyle(color: AppColors.primaryLight, fontWeight: FontWeight.bold),
                        ),
                      ),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Text('Total Pedido', style: TextStyle(fontSize: 11, color: AppColors.textSecondary)),
                            Text(
                              'Bs. ${vm.cartTotal.toStringAsFixed(2)}',
                              style: const TextStyle(
                                fontSize: 17,
                                fontWeight: FontWeight.bold,
                                color: AppColors.accent,
                              ),
                            ),
                          ],
                        ),
                      ),
                      ElevatedButton.icon(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.primary,
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                        ),
                        onPressed: _showCartSheet,
                        icon: const Icon(Icons.shopping_bag_outlined, size: 18),
                        label: const Text(
                          'VER PEDIDO',
                          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                        ),
                      ),
                    ],
                  ),
                )
              : null,
        );
      },
    );
  }
}
