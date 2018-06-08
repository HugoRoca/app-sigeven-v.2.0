<?php
//Activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
}else{

require 'header.php';

if ($_SESSION["escritorio"] == 1) {

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
                                    <h4 style="font-size: 17px;"><strong></strong></h4>
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
                                    <h4 style="font-size: 17px;"><strong></strong></h4>
                                    <p>Ventas</p>
                                </div>
                                <!--div class="icon"><i class="ion ion-bag"></i></div-->
                                <a href="venta.php" class="small-box-footer">
                                    Ventas <i class="fa fa-arrow-circle-right"></i>
                                </a>
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

<script src="scripts/categoria.js"></script>
<?php
}

ob_end_flush();

?>