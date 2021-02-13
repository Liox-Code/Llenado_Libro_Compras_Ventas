<?php
  !isset($_POST) ? die('acceso denegado'):'';
  require 'Configuracion_Coneccion/conexion.class.php';
  $db=new Conexion();
  session_start();

  if(isset($_SESSION['usuCI'])){
    $ciActual=$_SESSION['usuCI'];
  }  
  if(isset($_POST['txtCi'])){
    $ci=$_POST['txtCi'];
  }
  if(isset($_POST['txtNombre'])){
    $nombre=$_POST['txtNombre'];
  }
  if(isset($_POST['txtApellido'])){
    $apellido=$_POST['txtApellido'];
  }
  if(isset($_POST['txtNombreUsuario'])){
    $nombreUsuario=$_POST['txtNombreUsuario'];
  }
  if(isset($_POST['txtContraseña'])){
    $contraseña=$_POST['txtContraseña'];
  }
  if(isset($_POST['txtConfirmarContraseña'])){
    $confirmarContraseña=$_POST['txtConfirmarContraseña'];
  }

  if(isset($_POST['registrar'])){
    if($contraseña==$confirmarContraseña && $ci!="" && $nombre!="" && $apellido!="" && $nombreUsuario!="" && $contraseña!=""){
      $query="INSERT INTO `usuario` 
      (`ci_usuario`
      , `nombre`
      , `apellido`
      , `nombre_usuario`
      , `clave`
      , `cod_rol`
      , `estado`) 
      VALUES ('$ci'
      ,'$nombre'
      ,'$apellido'
      ,'$nombreUsuario'
      ,'$contraseña'
      ,'1'
      ,'1')";
      $db->query($query);
      if($db->affected_rows<0){
        echo $query,"ERROR";
        echo "<script>
                 window.location.href='registrarUsuario.php?tituloMensajeModal=Error Crear Cuenta&mensajeModal=Usuario ya existente.';
              </script>";
      }else {
        echo "<script>
                 window.location.href='iniciarSesion.php?tituloMensajeModal=Cuenta Creada Exitosamente&mensajeModal=Su cuenta fue creada exitosamente.';
              </script>";
      }
    }
    else {
      echo "Error campos vacios";
    }
  }
  if(isset($_POST['iniciarSecion'])){

    $query = "SELECT u.`nombre_usuario`,u.`clave`,u.`ci_usuario`,r.`nombre_rol`,u.`estado`
    FROM `usuario` u
    INNER JOIN `rol` r ON r.cod_rol = u.cod_rol
    WHERE `nombre_usuario`='$nombreUsuario' and `clave`='$contraseña'";
    /*$query = "SELECT u.`nombre_usuario`
    , u.`clave`
    , u.`ci_usuario`
    , r.`nombre_rol`
    , u.`estado`
    , e.`nit_empresa`
    , lc.`cod_libro_compras`
    , lv.`cod_libro_ventas`
    FROM `usuario` u 
    INNER JOIN `rol` r ON r.cod_rol = u.cod_rol
    LEFT JOIN `trabaja_empresa` re ON u.ci_usuario = re.ci_empleado_empresa_cliente
    LEFT JOIN `empresa` e ON e.nit_empresa = re.nit_empresa
    LEFT JOIN libro_compras lc ON re.cod_libro_compras = lc.cod_libro_compras
    LEFT JOIN libro_ventas lv ON re.cod_libro_ventas = lv.cod_libro_ventas
    WHERE `nombre_usuario`='$nombreUsuario' and `clave`='$contraseña'";*/

    $res=$db->query($query);
    $datos=mysqli_num_rows($res);

    if($db->affected_rows<=0){
      echo $query , 'error';
      echo "<script>
               window.location.href='iniciarSesion.php?tituloMensajeModal=Error Login&mensajeModal=La nombre de usuario o contraseña es incorrecto.';
            </script>";
    }
    else{
      $row=mysqli_fetch_array($res);
      $_SESSION['usuCI']=$row[2];
      $_SESSION['usuRol']=$row[3];
      $_SESSION['usuEstado']=$row[4];
      if($_SESSION["usuRol"] == 'empleado_empresa_cliente'){
        $_SESSION['nit_empresa_seleccionada']=$row[5];
        $_SESSION['cod_libro_compras_seleccionada']=$row[6];
        $_SESSION['cod_libro_ventas_seleccionado']=$row[7];
      }
      header("location: menuPrincipal.php");
    }
  }



  if(isset($_POST['modificar'])){

    if($nombre!="" && $apellido!="" && $nombreUsuario!="" && $contraseña!=""){
      $query="UPDATE `usuario` u
      SET u.`ci_usuario` = '$ci'
      ,  u.`nombre`='$nombre'
      ,  u.`apellido`='$apellido'
      ,  u.`nombre_usuario`='$nombreUsuario' 
      ,  u.`clave`='$contraseña'
      WHERE u.`ci_usuario`='$ciActual'";

      $db->query($query);
      if($db->affected_rows<=0){
        echo "<script>
                  window.location.href='editarUsuario.php?tituloMensajeModal=Error Modificación&mensajeModal=Error en la modificación de la cuenta.';
              </script>";
      }
      else{
        $_SESSION['usuCI'] = $ci;
        $query="UPDATE registra_empresa rempr
        SET rempr.`ci_administrador` = '$ci'
        WHERE rempr.`ci_administrador`='$ciActual'";
        $db->query($query);
        
        $query="UPDATE trabaja_empresa re
        SET re.`ci_administrador` = '$ci'
        WHERE re.`ci_administrador`='$ciActual'";
        $db->query($query);
        
        $query="UPDATE facturas_ventas fv
        SET fv.`ci_usuario` = '$ci'
        WHERE fv.`ci_usuario`='$ciActual'";
        $db->query($query);
        
        $query="UPDATE facturas_compras fc
        SET fc.`ci_usuario` = '$ci'
        WHERE fc.`ci_usuario`='$ciActual'";
        $db->query($query);

        echo "<script>
                  window.location.href='menuPrincipal.php?tituloMensajeModal=Modificación Exitosa&mensajeModal=Cuenta modificada exitosamente.';
              </script>";
      }
    }
    else{
      echo "<script>
                window.location.href='editarUsuario.php?tituloMensajeModal=Error Modificación&mensajeModal=No lleno todos los campos.';
            </script>";
    }
  }

  if(isset($_GET['eliminar_Usuario'])){
    $query="UPDATE `usuario` SET `estado`='0' WHERE `ci_usuario`='$ciActual'";
    $db->query($query);
    echo $query;
    if($db->affected_rows<0){
      echo "<script>
                window.location.href='menuPrincipal.php?tituloMensajeModal=Error Eliminar Cuenta&mensajeModal=No se pudo eliminar la cuenta.';
            </script>";
    }
    else{
      echo "<script>
                window.location.href='iniciarSesion.php?tituloMensajeModal=Eliminarcion exitosa&mensajeModal=Se elimino la cuenta del sistema.';
            </script>";
    }
  }

  if(isset($_GET['salir'])){
    session_unset();
    session_destroy();
    echo "<script>
            window.location.href='iniciarSesion.php';
          </script>";
  }
?>