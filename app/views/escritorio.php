<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["escritorio"] == 1) {

    require_once '../models/Consultas.php';
    $consulta = new Consultas();
    $rsptac = $consulta->totalCompraHoy();
    $regc = $rsptac->fetch_object();
    $totalc = 'S/. ' . $regc->total_compra;

    $rsptav = $consulta->totalVentaHoy();
    $regv = $rsptav->fetch_object();
    $totalv = 'S/. ' . $regv->total_venta;

    //Datos para mostrar el graficos de barras de las compras
    $compras10 = $consulta->comprasUltimos_10Dias();
    $fechasc = '';
    $totalesc = '';

    while ($regfechac = $compras10->fetch_object()) {
        $fechasc = $fechasc.'"'.$regfechac->fecha.'",';
        $totalesc = $totalesc.$regfechac->total.',';
    }

    //Quitamos la última coma
    $fechasc = substr($fechasc, 0, -1);
    $totalesc = substr($totalesc, 0, -1);

    //Datos para mostrar el graficos de barras de las ventas
    $ventas12 = $consulta->ventasUltimos_12Meses();
    $fechasv = '';
    $totalesv = '';

    while ($reffechav = $ventas12->fetch_object()) {
        $fechasv = $fechasv.'"'.$reffechav->fecha.'",';
        $totalesv = $totalesv.$reffechav->total.',';
    }

    //Quitamos la última coma
    $fechasv = substr($fechasv, 0, -1);
    $totalesv = substr($totalesv, 0, -1);

?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">
                            Graficos
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h4 style="font-size: 17px;"><strong><?php echo $totalc; ?></strong></h4>
                                    <p>Compras</p>
                                </div>
                                <!--div class="icon"><i class="ion ion-bag"></i></div-->
                                <a href="ingreso.php" class="small-box-footer">
                                    Compras <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4 style="font-size: 17px;"><strong><?php echo $totalv; ?></strong></h4>
                                    <p>Ventas</p>
                                </div>
                                <!--div class="icon"><i class="ion ion-bag"></i></div-->
                                <a href="ventas.php" class="small-box-footer">
                                    Ventas <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="panel body">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Compras de los últimos 10 días
                                    </div>
                                    <div class="box-body">
                                        <canvas id="compras" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        Ventas de los últimos 12 meses
                                    </div>
                                    <div class="box-body">
                                        <canvas id="ventas" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
}
else{
    require 'noacceso.php';
}
    require 'footer.php';
?>

<script src="../assets/js/chart.min.js"></script>
<script src="../assets/js/chart.bundle.min.js"></script>

<script>
var ctx = document.getElementById("compras").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: '# Compras en S/ de los últimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
////
var ctx = document.getElementById("ventas").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: '# Ventas en S/ de los últimos 12 meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

</script>
<?php
}

ob_end_flush();

?>