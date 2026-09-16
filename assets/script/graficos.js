/*Author: Ing. Ruben D. Chirinos R. Tlf: +58 0416-3422924, email: elsaiya@gmail.com*/

/*tipos de graficos
    bar
    horizontalBar
    line
    radar
    polarArea
    pie
    doughnut
    bubble
 Con pointRadius podr�s establecer el radio del punto.

fill: false, �> no aparecer� relleno por debajo de la l�nea.

showLine: false, �> no aparecer� la l�nea.

Es decir, si ponemos fill y showLine a false, tendremos un gr�fico de puntos, en lugar de un gr�fico
de l�neas. pointStyle: �circle�, �triangle�, �rect�, �rectRounded�, �rectRot�, �cross�, �crossRot�, �star�,
�line�, and �dash� Podr�a ser incluso una imagen.

spanGaps est� por defecto a false. Si lo ponemos a true, cuando te falte un valor en la l�nea, no se 
romper� la l�nea.*/

/* GRAFICO PARA VENTAS POR SUCURSALES ANUAL*/
function showGraphBarS(){
    {
        $.post("data.php?ProcesosxSucursales=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var compras = [];
            var cotizacion = [];
            var ventas = [];
            var myColors=[];

            for (var i in data) {
                id.push(data[i].codsucursal);
                name.push(data[i].nomsucursal);
                compras.push(data[i].sumcompras);
                cotizacion.push(data[i].sumcotizacion);
                ventas.push(data[i].sumventas);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                  label: "Compras",    
                  backgroundColor: ['#ff7676'],
                  borderWidth: 1,
                  data: compras
              },
              {
                  label: "Cotizaciones",
                  backgroundColor: ['#8EE1BC'],
                  borderWidth: 1,
                  data: cotizacion
              },
              {
                  label: "Ventas",
                  backgroundColor: ['#25AECD'],
                  borderWidth: 1,
                  data: ventas
              }
              ]
            };

            var graphTarget = $("#barChart");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}




function showGraphDoughnutPV(){
    {
        $.post("data.php?ProductosVendidos=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var total = [];

            for (var i in data) {
                id.push(data[i].codproducto);
                name.push(data[i].producto);
                total.push(data[i].cantidad);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                    backgroundColor: ["#ff7676", "#3e95cd","#3cba9f","#003399","#f0ad4e","#987DDB","#E8AC9E","#D3E37D"],
                    borderWidth: 1,
                    data: total
                }
                ]
            };

            var graphTarget = $("#DoughnutChart");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}



/* GRAFICO DE VENTAS POR VENDEDOR*/
function showGraphDoughnutVU(){
    {
        $.post("data.php?VentasxUsuarios=si",
        function (data)
        {
            console.log(data);
            var id = [];
            var name = [];
            var marks = [];
            var myColors=[];

            for (var i in data) {
                id.push(data[i].codigo);
                name.push(data[i].nombres);
                marks.push(data[i].total);
            }

            $.each(id, function( index,num ) {
                if (num == 1)
                    myColors[index]= "#f0ad4e";
                if (num == 2)
                    myColors[index]= "#ff7676";
                if (num == 3)
                    myColors[index]= "#E0E4CC";
                if (num == 4)
                    myColors[index]= "#3e95cd";
                if (num == 5)
                    myColors[index]= "#969788";
                if (num == 6)
                    myColors[index]= "#987DDB";
                if (num == 7)
                    myColors[index]= "#169696"; 
                if (num == 8)
                    myColors[index]= "#69D2E7";   
                if (num == 9)
                    myColors[index]= "#F38630";   
                if (num == 10)
                    myColors[index]= "#F82330";  
                if (num == 11)
                    myColors[index]= "#D3E37D";  
                if (num == 12)
                    myColors[index]= "#00FFFF";  
                if (num == 13)
                    myColors[index]= "#fff933";  
                if (num == 14)
                    myColors[index]= "#90ff33";  
                if (num == 15)
                    myColors[index]= "#E8AC9E";
            });

            var chartdata = {
                labels: name,
                datasets: [
                    {
                        label: 'Total en Ventas',
                        data: marks,  
                        backgroundColor: myColors,
                        borderWidth: 1
                    }
                ]
            };

            var graphTarget = $("#DoughnutChart2");
            //var steps = 3;

            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 5,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>" 
            });
        });
    }
}

/* GRAFICO DE VENTAS DE HOY POR SUCURSAL */
function showGraphVentasHoySucursal(){
    {
        $.post("data.php?VentasHoyPorSucursal=si",
        function (data)
        {
            console.log(data);
            var name = [];
            var total = [];
            var colores = ['#ff7676', '#3e95cd', '#3cba9f', '#f0ad4e', '#987DDB', '#E8AC9E', '#7DA5EA', '#8EE1BC', '#D3E37D', '#E399DA', '#F7BE81', '#FA5858'];

            for (var i in data) {
                name.push(data[i].nomsucursal);
                total.push(data[i].total);
            }

            var chartdata = {
                labels: name,
                datasets: [
                {
                    label: "Ventas de Hoy",
                    backgroundColor: colores,
                    borderWidth: 1,
                    data: total
                }
                ]
            };

            var graphTarget = $("#barChartVentasHoy");

            if (window.chartVentasHoy) {
                window.chartVentasHoy.destroy();
            }

            window.chartVentasHoy = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                responsive : true,
                animation: true,
                barValueSpacing : 2,
                barDatasetSpacing : 1,
                tooltipFillColor: "rgba(0,0,0,0.8)",
                multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
            });
        });
    }
}

/* ACTUALIZACION DE KPIs DEL DASHBOARD GENERAL */
function updateDashboardKPIs(){
    $.post("data.php?DashboardResumenGeneral=si",
    function (data)
    {
        console.log(data);
        if(data && data.length > 0){
            $("#kpi-ventas-monto").html(data[0].ventashoy);
            $("#kpi-ventas-cant").html(data[0].nventashoy);
            $("#kpi-compras-monto").html(data[0].comprashoy);
            $("#kpi-compras-cant").html(data[0].ncomprashoy);
            $("#kpi-credito-ventas").html(data[0].creditoventaspendiente);
            $("#kpi-credito-compras").html(data[0].creditocompraspendiente);
        }
    }, "json");

    updateDashboardControlInventario();
}

/* ACTUALIZACION DE KPIS DE CONTROL DE INVENTARIO Y RELEVOS */
function updateDashboardControlInventario(){
    $.get("data.php?DashboardControlInventario=si", function(res){
        if(res && res.kpis){
            var k = res.kpis;
            var faltPendUds = parseFloat(k.unidades_faltantes_pendientes) || 0;
            var costoPend = parseFloat(k.costo_faltante_pendiente) || 0;
            var cuadTotalUds = parseFloat(k.unidades_cuadradas_total) || 0;
            var sinConteo = parseInt(k.cajas_sin_conteo) || 0;
            var conteosPend = parseInt(k.conteos_con_pendientes) || 0;
            var conteosResueltos = parseInt(k.conteos_resueltos) || 0;

            if (faltPendUds > 0) {
                $("#kpi-inv-faltantes-uds").html("-" + faltPendUds.toFixed(0)).removeClass("text-success").addClass("text-danger font-weight-bold");
                var textoMonto = "Est. -Bs. " + costoPend.toFixed(2) + " pendiente";
                if (cuadTotalUds > 0) {
                    textoMonto += '<br><small class="text-info font-weight-bold"><i class="fa fa-check"></i> ' + cuadTotalUds.toFixed(0) + ' uds ya cuadradas</small>';
                }
                $("#kpi-inv-faltantes-monto").html(textoMonto).removeClass("text-muted text-success").addClass("text-danger font-weight-bold");
            } else {
                $("#kpi-inv-faltantes-uds").html("0").removeClass("text-danger font-weight-bold").addClass("text-success font-weight-bold");
                var textoCuad = (cuadTotalUds > 0) ? ("✓ " + cuadTotalUds.toFixed(0) + " uds Cuadradas/Ajustadas") : "100% Cuadrado";
                $("#kpi-inv-faltantes-monto").html(textoCuad).removeClass("text-danger font-weight-bold text-muted").addClass("text-success font-weight-bold");
            }

            $("#kpi-inv-total-conteos").html(k.total_conteos_hoy);
            if (sinConteo > 0) {
                $("#kpi-inv-cajas-alerta").html("⚠️ " + sinConteo + " caja(s) sin contar").removeClass("text-muted").addClass("badge badge-warning text-dark font-weight-bold");
            } else {
                $("#kpi-inv-cajas-alerta").html("Cajas al día").removeClass("badge badge-warning text-dark font-weight-bold").addClass("text-muted");
            }

            $("#kpi-inv-cuadrados").html(k.conteos_cuadrados_totales);
            if (conteosPend > 0) {
                var txtPend = '<span class="text-danger font-weight-bold">' + conteosPend + ' con faltante activo</span>';
                if (conteosResueltos > 0) {
                    txtPend += '<br><small class="text-info font-weight-bold">(' + conteosResueltos + ' cuadrados por ajuste/compra)</small>';
                }
                $("#kpi-inv-diferencias").html(txtPend);
            } else {
                var txtOk = '<span class="text-success font-weight-bold"><i class="fa fa-check"></i> Todos resueltos</span>';
                if (conteosResueltos > 0) {
                    txtOk += '<br><small class="text-info font-weight-bold">(' + conteosResueltos + ' cuadrados por ajuste/compra)</small>';
                }
                $("#kpi-inv-diferencias").html(txtOk);
            }

            if (k.dias_anteriores_faltantes_uds !== undefined && $("#btn_faltantes_anteriores").length > 0) {
                var antUds = parseFloat(k.dias_anteriores_faltantes_uds) || 0;
                $("#btn_faltantes_anteriores").html('<i class="fa fa-history"></i> Faltantes Días Anteriores (' + antUds.toFixed(0) + ' uds)');
            }
        }
    }, "json");
}