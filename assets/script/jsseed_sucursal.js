$(document).ready(function() {
    
    // Cargar estado al iniciar
    cargarEstadoSucursal();

    // Evento al cambiar de sucursal
    $('#selectSucursal').on('change', function() {
        cargarEstadoSucursal();
    });

    // Botón Recargar
    $('#btnRecargarEstado').on('click', function() {
        cargarEstadoSucursal();
    });

    // Botón Ejecutar Seed
    $('#btnEjecutarSeed').on('click', function() {
        var codsucursal = $('#selectSucursal').val();
        var nomSucursal = $('#selectSucursal option:selected').text();
        var montoinicial = $('#montoInicialSeed').val();
        var stock_unidades = $('#stockUnidadesSeed').val();

        swal({
            title: "¿Ejecutar Seed de Pruebas?",
            text: "Se generarán usuarios, cajeros, cajas, apertura de caja en vivo, mesas de billar y stock para la sucursal seleccionada:\n\n" + nomSucursal,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "¡Sí, Ejecutar Seed!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'seed_sucursal.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'ejecutar_seed',
                        codsucursal: codsucursal,
                        montoinicial: montoinicial,
                        stock_unidades: stock_unidades
                    },
                    success: function(resp) {
                        if (resp.status === 'success') {
                            var rep = resp.reporte || {};
                            var detalleHtml = "Usuarios Creados/Actualizados: " + (rep.credenciales ? rep.credenciales.length : 4) + "\n" +
                                              "Cajas Creadas: " + (rep.cajas_creadas || 0) + "\n" +
                                              "Cajas Abiertas en Vivo: " + (rep.cajas_abiertas || 0) + "\n" +
                                              "Mesas de Billar / Barra: " + (rep.mesas_creadas || 0) + "\n" +
                                              "Productos con Stock: " + (rep.productos_stock || 0) + "\n" +
                                              "Clientes de Prueba: " + (rep.clientes_creados || 0);

                            swal({
                                title: "¡Seed Ejecutado con Éxito!",
                                text: resp.mensaje + "\n\n" + detalleHtml + "\n\nPuedes ingresar de inmediato con el usuario PRUEBATARDE (clave: 123456).",
                                type: "success"
                            });

                            cargarEstadoSucursal();

                            $.toast({
                                heading: '¡Datos Generados!',
                                text: 'El entorno de pruebas está completamente listo para operar.',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 5000,
                                stack: 6
                            });
                        } else {
                            swal("Error al ejecutar Seed", resp.mensaje || "Ocurrió un error inesperado.", "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        swal("Error del Servidor", "No se pudo conectar con el servidor: " + error, "error");
                    }
                });
            }
        });
    });

    // Botón Resetear Seed
    $('#btnResetearSeed').on('click', function() {
        var codsucursal = $('#selectSucursal').val();
        var nomSucursal = $('#selectSucursal option:selected').text();

        swal({
            title: "¿Resetear Datos de Prueba?",
            text: "Se eliminarán las cajas, arqueos, usuarios de prueba y se reiniciará el stock a 0 en la sucursal de prueba:\n\n" + nomSucursal,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "¡Sí, Resetear Todo!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'seed_sucursal.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        accion: 'resetear',
                        codsucursal: codsucursal
                    },
                    success: function(resp) {
                        if (resp.status === 'success') {
                            swal("¡Reseteo Exitoso!", resp.mensaje, "success");
                            cargarEstadoSucursal();
                        } else {
                            swal("Aviso", resp.mensaje, "error");
                        }
                    },
                    error: function() {
                        swal("Error", "Error de comunicación con el servidor.", "error");
                    }
                });
            }
        });
    });

    // Copiar credenciales al portapapeles
    $(document).on('click', '.btn-copiar', function() {
        var user = $(this).data('user');
        var pass = $(this).data('pass');
        var texto = "Usuario: " + user + " | Clave: " + pass;

        if (navigator.clipboard) {
            navigator.clipboard.writeText(texto).then(function() {
                $.toast({
                    heading: 'Copiado',
                    text: 'Credenciales copiadas al portapapeles: ' + texto,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'info',
                    hideAfter: 3000
                });
            });
        } else {
            prompt("Copia las credenciales:", texto);
        }
    });

    // Función para obtener y renderizar el estado
    function cargarEstadoSucursal() {
        var codsucursal = $('#selectSucursal').val();

        $('#numUsuarios, #numCajas, #numArqueos, #numMesas, #numProductos, #numClientes').html('<i class="fa fa-spin fa-spinner"></i>');

        $.ajax({
            url: 'seed_sucursal.php',
            type: 'POST',
            dataType: 'json',
            data: {
                accion: 'resumen',
                codsucursal: codsucursal
            },
            success: function(resp) {
                if (resp.status === 'success' && resp.data) {
                    var d = resp.data;

                    // Usuarios
                    var totalUsers = (d.usuarios ? d.usuarios.length : 0);
                    $('#numUsuarios').text(totalUsers);
                    $('#descUsuarios').text(totalUsers > 0 ? totalUsers + ' registrados' : 'Ninguno registrado');

                    // Cajas
                    var totalCajas = (d.cajas ? d.cajas.length : 0);
                    $('#numCajas').text(totalCajas);
                    $('#descCajas').text(totalCajas > 0 ? totalCajas + ' cajas creadas' : 'Sin cajas');

                    // Arqueos abiertos
                    var totalArq = (d.arqueosAbiertos ? d.arqueosAbiertos.length : 0);
                    if (totalArq > 0) {
                        $('#numArqueos').html('<span class="text-success"><i class="fa fa-check"></i> ' + totalArq + '</span>');
                        $('#descArqueos').text('¡Caja abierta lista!');
                    } else {
                        $('#numArqueos').html('<span class="text-danger"><i class="fa fa-times"></i> 0</span>');
                        $('#descArqueos').text('Cajas cerradas');
                    }

                    // Mesas
                    var totalMesas = (d.mesas ? d.mesas.length : 0);
                    $('#numMesas').text(totalMesas);
                    $('#descMesas').text(totalMesas > 0 ? totalMesas + ' mesas activas' : 'Sin mesas');

                    // Productos
                    var prodStock = d.productos_stock || 0;
                    var prodTotal = d.productos_total || 0;
                    $('#numProductos').text(prodStock + ' / ' + prodTotal);
                    $('#descProductos').text(prodStock > 0 ? 'Con existencia' : 'Todos en 0');

                    // Clientes
                    var totalCli = d.clientes_total || 0;
                    $('#numClientes').text(totalCli);
                    $('#descClientes').text(totalCli > 0 ? totalCli + ' registrados' : 'Sin clientes');
                }
            },
            error: function() {
                $('#numUsuarios, #numCajas, #numArqueos, #numMesas, #numProductos, #numClientes').text('Error');
            }
        });
    }

});
