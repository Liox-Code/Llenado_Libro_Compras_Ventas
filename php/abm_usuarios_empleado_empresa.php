<?php
  !isset($_POST) ? die('acceso denegado'):'';
  require 'Configuracion_Coneccion/conexion.class.php';
  $db=new Conexion();
  session_start();

  if(isset($_SESSION['usuCI'])){
    $ci_Administrador=$_SESSION['usuCI'];
  }  
  if(isset($_POST['usu_emp_Ci'])){
    $ci_empleado=$_POST['usu_emp_Ci'];
  }
  if(isset($_POST['usu_emp_Nombre'])){
    $nombre=$_POST['usu_emp_Nombre'];
  }
  if(isset($_POST['usu_emp_Apellido'])){
    $apellido=$_POST['usu_emp_Apellido'];
  }
  if(isset($_POST['usu_emp_NombreUsuario'])){
    $nombreUsuario=$_POST['usu_emp_NombreUsuario'];
  }
  if(isset($_POST['usu_emp_Contraseña'])){
    $contraseña=$_POST['usu_emp_Contraseña'];
  }
  if(isset($_POST['usu_emp_Nit_Empresa'])){
    $nit_Empresa=$_POST['usu_emp_Nit_Empresa'];
  }
  if(isset($_POST['usu_emp_Cod_Libro_Compras'])){
    $cod_Libro_Compras=$_POST['usu_emp_Cod_Libro_Compras'];
  }
  if(isset($_POST['usu_emp_Cod_Libro_Ventas'])){
    $cod_Libro_Ventas=$_POST['usu_emp_Cod_Libro_Ventas'];
  }

  if(isset($_POST['registrar_empleado_empresa_cliente'])){
    if($ci_empleado!="" && $nombre!="" && $apellido!="" && $nombreUsuario!="" && $contraseña!=""){
      $query="INSERT INTO `usuario` 
      (`ci_usuario`
      , `nombre`
      , `apellido`
      , `nombre_usuario`
      , `clave`
      , `cod_rol`
      , `estado`) 
      VALUES ('$ci_empleado'
      ,'$nombre'
      ,'$apellido'
      ,'$nombreUsuario'
      ,'$contraseña'
      ,'2'
      ,'1')";
      
      $db->query($query);

      if($db->affected_rows<0){
        echo 'ERROR registrar_empleado_empresa_cliente';
      }else {
        $query="INSERT INTO `trabaja_empresa`
        (`ci_administrador`
        , `ci_empleado_empresa_cliente`
        , `nit_empresa`
        , `cod_libro_compras`
        , `cod_libro_ventas`) 
        VALUES 
        ('$ci_Administrador'
        ,'$ci_empleado'
        ,'$nit_Empresa'
        ,'$cod_Libro_Compras'
        ,'$cod_Libro_Ventas')";
        echo $query;
        $db->query($query);
  
        if($db->affected_rows<0){
          echo 'ERRORr trabaja_empresa';
        }else {
          echo 'trabaja_empresa exitoso';
          echo 'registrar_empleado_empresa_cliente exitoso';
  
        }
      }
    }
    else {
      echo "<script>
               window.location.href='registrarUsuario.php?tituloMensajeModal=Error registrar&mensajeModal=Contraseña diferente ingrese de nuevo.';
            </script>";
    }
  }

  if(isset($_GET['l_emp_listar_empleados_empresas_clientes'])){
    $query = "SELECT 
    ue.`ci_usuario`
    , ue.`nombre`
    , ue.`apellido`
    , ue.`nombre_usuario`
    , ue.`clave`
    , e.`nit_empresa`
    , e.`nombre_empresa`
    , lc.`cod_libro_compras`
    , lc.`nombre` as nombre_lcompras
    , lv.`cod_libro_ventas`
    , lv.`nombre` as nombre_lventas
    FROM `usuario` u 
    INNER JOIN `trabaja_empresa` re ON u.ci_usuario = re.ci_administrador
    INNER JOIN `usuario` ue ON ue.ci_usuario = re.ci_empleado_empresa_cliente
    LEFT JOIN `empresa` e ON e.nit_empresa = re.nit_empresa
    LEFT JOIN libro_compras lc ON re.cod_libro_compras = lc.cod_libro_compras
    LEFT JOIN libro_ventas lv ON re.cod_libro_ventas = lv.cod_libro_ventas
    WHERE re.ci_administrador = $ci_Administrador";

    $res=$db->query($query);

    if($db->affected_rows<=0){
        die('Query Failed l_emp_listar_empleados_empresas_clientes');
    }
    $json = array();
    while($row = mysqli_fetch_array($res)) {
        $json[] = array(
        'ci_usuario' => $row['ci_usuario'],
        'nombre' => $row['nombre'],
        'apellido' => $row['apellido'],
        'nombre_usuario' => $row['nombre_usuario'],
        'clave' => $row['clave'],
        'nit_empresa' => $row['nit_empresa'],
        'nombre_empresa' => $row['nombre_empresa'],
        'cod_libro_compras' => $row['cod_libro_compras'],
        'nombre_lcompras' => $row['nombre_lcompras'],
        'cod_libro_ventas' => $row['cod_libro_ventas'],
        'nombre_lventas' => $row['nombre_lventas'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }

  if(isset($_GET['dr_bx_listar_Empresas'])){
    $query = "SELECT e.`nit_empresa`, e.`nombre_empresa`
    FROM `registra_empresa` re
    INNER JOIN `empresa` e 
    ON re.nit_empresa = e.nit_empresa
    INNER JOIN `usuario` u 
    ON re.ci_administrador = u.ci_usuario    
    WHERE u.ci_usuario = $ci_Administrador";

    $res=$db->query($query);

    if($db->affected_rows<=0){
        die('Query Failed dr_bx_listar_Libros_Empresas');
    }
    $json = array();
    while($row = mysqli_fetch_array($res)) {
        $json[] = array(
          'nit_empresa' => $row['nit_empresa'],
          'nombre_empresa' => $row['nombre_empresa'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }


  if(isset($_GET['dr_bx_listar_Libro_Compras'])){
    $nit_empresa = $_GET['nit_empresa'];
    $query = "SELECT lc.`cod_libro_compras`, lc.`nombre`
    FROM `empresa` e
    INNER JOIN `libro_compras` lc ON e.nit_empresa = lc.nit_empresa
    INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
    INNER JOIN `usuario`u ON u.ci_usuario = re.ci_administrador
    WHERE u.ci_usuario = $ci_Administrador AND e.`nit_empresa` = $nit_empresa";

    $res=$db->query($query);

    if($db->affected_rows<=0){
        die('Query Failed dr_bx_listar_Libro_Compras');
    }
    $json = array();
    while($row = mysqli_fetch_array($res)) {
        $json[] = array(
          'cod_libro_compras' => $row['cod_libro_compras'],
          'nombre' => $row['nombre'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }

  if(isset($_GET['dr_bx_listar_Libros_Ventas'])){
    $nit_empresa = $_GET['nit_empresa'];
    $query = "SELECT lv.`cod_libro_ventas`, lv.`nombre`
    FROM `empresa` e
    INNER JOIN `libro_ventas` lv ON e.nit_empresa = lv.nit_empresa
    INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
    INNER JOIN `usuario`u ON u.ci_usuario = re.ci_administrador
    WHERE u.ci_usuario = $ci_Administrador AND e.`nit_empresa` = $nit_empresa";

    $res=$db->query($query);

    if($db->affected_rows<=0){
        die('Query Failed dr_bx_listar_Libro_Compras');
    }
    $json = array();
    while($row = mysqli_fetch_array($res)) {
        $json[] = array(
          'cod_libro_ventas' => $row['cod_libro_ventas'],
          'nombre' => $row['nombre'],
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
  }

  if(isset($_POST['modificar_empleado_lista'])){
    $Ci_actual = $_POST['usu_emp_Ci_actual'];
    
    $query = "UPDATE `usuario` 
    SET `ci_usuario`='$ci_empleado'
    ,`nombre`='$nombre'
    ,`apellido`='$apellido'
    ,`nombre_usuario`='$nombreUsuario'
    ,`clave`='$contraseña'
    WHERE `ci_usuario` = '$Ci_actual'";
    $db->query($query);

    if($db->affected_rows<=0){
        echo 'Error modificar_empleado_lista';
    }
    else{

      $query="UPDATE facturas_ventas fv
      SET fv.`ci_usuario` = '$ci_empleado'
      WHERE fv.`ci_usuario`='$Ci_actual'";
      $db->query($query);

      if($db->affected_rows<=0){
          echo 'Error Modificacion facturas_ventas';
      }
      else{
          echo 'Modificacion exitosa facturas_ventas';
      }

      $query="UPDATE facturas_compras fc
      SET fc.`ci_usuario` = '$ci_empleado'
      WHERE fc.`ci_usuario`='$Ci_actual'";
      $db->query($query);

      if($db->affected_rows<=0){
          echo 'Error Modificacion facturas_compras';
      }
      else{
          echo 'Modificacion exitosa facturas_compras';
      }
    
      $query_trabaja_empresa = "UPDATE `trabaja_empresa`
      SET `ci_empleado_empresa_cliente`= '$ci_empleado'
      ,`nit_empresa`= '$nit_Empresa'
      ,`cod_libro_compras`= '$cod_Libro_Compras'
      ,`cod_libro_ventas`=  '$cod_Libro_Ventas'
      WHERE `ci_empleado_empresa_cliente` = '$Ci_actual'";
  
      $db->query($query_trabaja_empresa);
  
      if($db->affected_rows<=0){
          echo 'Error Modificacion trabaja_empresa';
      }
      else{
          echo 'Modificacion exitosa trabaja_empresa';
      }
    }
    
    $query_trabaja_empresa = "UPDATE `trabaja_empresa`
    SET `nit_empresa`= '$nit_Empresa'
    ,`cod_libro_compras`= '$cod_Libro_Compras'
    ,`cod_libro_ventas`=  '$cod_Libro_Ventas'
    WHERE `ci_empleado_empresa_cliente` = '$Ci_actual'";

    $db->query($query_trabaja_empresa);

    if($db->affected_rows<=0){
        echo 'Error Modificacion trabaja_empresa';
    }
    else{
        echo 'Modificacion exitosa trabaja_empresa';
    }
  }

  if(isset($_POST['eliminar_empleado_lista'])){
    $query = "DELETE u,te
    FROM `usuario` u
    INNER JOIN  `trabaja_empresa` te 
    ON u.`ci_usuario` = te.`ci_empleado_empresa_cliente`
    WHERE te.ci_administrador = $ci_Administrador AND te.ci_empleado_empresa_cliente = '$ci_empleado'";
    //$query = "DELETE FROM `usuario` WHERE ci_usuario = '$ci_empleado'";
    echo $query;
    $db->query($query);
    if($db->affected_rows<=0){
      echo 'ERROR eliminar_empleado_lista';
    }
    else{
        echo 'eliminar_empleado_lista Exitoso';
    }
  }
?>
