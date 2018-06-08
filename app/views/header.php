<?php

if (strlen(session_id()) < 1) {
  session_start();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIGEVEN 2.0 | Sistema de control de ventas</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../assets/css/skins/skin-blue.min.css">

  <!--DATATABLES-->
  <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../assets/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../assets/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">


  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="skin-blue layout-boxed sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper">
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <span class="logo-mini"><b>SGV</b>2</span>
      <span class="logo-lg"><b>SIGEVEN </b>2.0</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../Files/Usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nombre'];?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="../Files/Usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['nombre'];?>
                  <small>Sistema de gestión de ventas</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../Files/Usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nombre'];?></p>
          <a href=""><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">OPCIONES</li>
        <?php
          if ($_SESSION['escritorio'] == 1) {
            echo '<li>
                    <a href="escritorio.php"><i class="fa fa-tasks"></i> <span>Escritorio</span></a>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['almacen'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-university"></i> <span>Almacén</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Artículos</a></li>
                      <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                    </ul>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['compras'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-th"></i> <span>Compras</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Ingreso</a></li>
                      <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedor</a></li>
                    </ul>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-shopping-cart"></i> <span>Ventas</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventas.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                      <li><a href="cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                    </ul>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['acceso'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-folder"></i> <span>Aceso</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuario</a></li>
                      <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                    </ul>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['consultac'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-bar-chart"></i> <span>Consulta Compras</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a></li>
                    </ul>
                  </li>';
          }
        ?>
        <?php
          if ($_SESSION['consultav'] == 1) {
            echo '<li class="treeview">
                    <a href=""><i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>
                    </ul>
                  </li>';
          }
        ?>
      </ul>
    </section>
  </aside>
