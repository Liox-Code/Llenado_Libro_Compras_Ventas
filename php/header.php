<?php
  session_start();
  if( !isset($_SESSION['usuCI']) ){
      header("location:iniciarSesion.php");
      exit();
  }
  if( !isset($_SESSION['usuRol']) ){
      header("location:iniciarSesion.php");
      exit();
  }
  if( !isset($_SESSION['usuEstado']) ){
    header("location:iniciarSesion.php");
      exit();
  }
  else {
    if ($_SESSION['usuEstado'] == 0) {
      header("location:iniciarSesion.php?tituloMensajeModal=Error Login&mensajeModal=Cuenta fue Eliminada.");
      exit();
    }
  }
  if(isset($_SESSION['cod_libro_compras_seleccionada']) ){
    $cod_libro_compras_seleccionada = $_SESSION['cod_libro_compras_seleccionada'];
  }
  if(isset($_SESSION['cod_libro_ventas_seleccionado']) ){
    $cod_libro_ventas_seleccionada = $_SESSION['cod_libro_ventas_seleccionado'];
  }
  require 'Configuracion_Coneccion/conexion.class.php';
  $db=new Conexion();
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/tablas.css">
    <link rel="stylesheet" href="../css/iniciarSesion.css">
    <link rel="stylesheet" href="../css/validacion.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/css_registrar_factura.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous">
    </script>

    <!-- modal -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>

    <header>
      <nav>
        <?php
          $Opciones_Tipo_Usuario = "";
          if($_SESSION["usuRol"]=='administrador'){
            $Opciones_Tipo_Usuario .= "
              <div class='dropdown_right'>
                <button class='dropbtn'>Opciones</button>
                <div class='dropdown-content'>
                  <a href='editarUsuario.php' class='dropdownBtn'>Editar Usuario</a>
                  <a href='abm_usuarios.php?salir=si' class='dropdownBtn'>Cerrar</a>
                  <a href ='abm_usuarios.php?eliminar_Usuario=true' class='dropdownBtn'>Eliminar</a>
                </div>
              </div>";
          }
          if($_SESSION["usuRol"]=='empleado_empresa_cliente'){
            $Opciones_Tipo_Usuario .= "
              <div class='dropdown_right'>
                <button class='dropbtn'>Opciones</button>
                <div class='dropdown-content'>
                  <a href='abm_usuarios.php?salir=si' class='dropdownBtn'>Cerrar Sesion</a>
                </div>
              </div>";
          }

          $Opciones_Tipo_Usuario .= "
          <div class='dropdown_right'>
            <button class='dropbtn'>Listado</button>
              <div class='dropdown-content'>";

          if(isset($_SESSION['cod_libro_compras_seleccionada']) ){
            $Opciones_Tipo_Usuario .= "
            <a href='listaFacturasLibroCompras.php' class='dropdownBtn' id='btn_lista_factura_compras' btn_lista_factura_compras='$cod_libro_compras_seleccionada'>Facturas Libro Compras</a>";
          }
          if(isset($_SESSION['cod_libro_ventas_seleccionado']) ){
            $Opciones_Tipo_Usuario .= "
            <a href='listaFacturasLibroVentas.php' class='dropdownBtn' id='btn_lista_factura_ventas' btn_lista_factura_ventas='$cod_libro_ventas_seleccionada'>Facturas Libro Ventas</a>";
          }
          if($_SESSION["usuRol"]=='administrador'){
            $Opciones_Tipo_Usuario .= "
                <a href='listaEmpleadosEmpresas.php' class='dropdownBtn'>Lista Empleados</a>
                <a href='listaEmpresasClientes.php' class='dropdownBtn'>Lista Empresas</a>
              </div>
            </div>";
          }
          else{
            $Opciones_Tipo_Usuario .= "
              </div>
            </div>";
          }
          if(isset($_SESSION['cod_libro_compras_seleccionada']) ){
            $Opciones_Tipo_Usuario .= "
            <a href='exportar_Libro_Compras.php' class='btn_right'>Exportar Libro Compras</a>";
          }
          if(isset($_SESSION['cod_libro_ventas_seleccionado']) ){
            $Opciones_Tipo_Usuario .= "
            <a href='exportar_Libro_Ventas.php' class='btn_right'>Exportar Libro Ventas</a>";
          }
          
          
          echo $Opciones_Tipo_Usuario;
        ?>
      </nav>
    </header>
    <?php
        function mensajeAdvertenciaModal($tituloMensajeModal,$mensajeModal) { 
          echo "<div id='modal' class='modal'>
                  <div class='modal-contenedor'>
                    <div class='modal-cabecera'>
                      <span class='boton_cerrar' onclick='cerrarModal()'>&times;</span>
                      <h2 class='modal_titulo'>".$tituloMensajeModal."</h2>
                    </div>
                    <div class='modal-contenido'>
                      <p>".$mensajeModal."</p>
                    </div>
                  </div>
                </div><script>mostrarModal();</script>";
        }
        ?>
  <div class="cuerpoWeb">
    <div class="cuerpoWebElementos">
