<?php
    !isset($_POST) ? die('acceso denegado'):'';
    require 'Configuracion_Coneccion/conexion.class.php';
    $db=new Conexion();
    session_start();

    if(isset($_SESSION['usuCI'])){
        $ciActual =$_SESSION['usuCI'];
    }
    
    if(isset($_SESSION['cod_libro_compras_seleccionada'])){
        $codLibro =$_SESSION['cod_libro_compras_seleccionada'];
    }

    //Libro Compras
    if(isset($_POST['lc_txt_fecha_factura_o_DUI'])){
        $fecha_factura_o_DUI = $_POST['lc_txt_fecha_factura_o_DUI'];
    }
    if(isset($_POST['lc_txt_nit_proveedor'])){
        $nit_proveedor = $_POST['lc_txt_nit_proveedor'];
    }
    if(isset($_POST['lc_txt_nombre_o_razon_social'])){
        $nombre_o_razon_social = $_POST['lc_txt_nombre_o_razon_social'];
    }
    if(isset($_POST['lc_txt_num_factura'])){
        $num_factura = $_POST['lc_txt_num_factura'];
    }
    if(isset($_POST['lc_txt_num_DUI'])){
        $num_DUI = $_POST['lc_txt_num_DUI'];
    }
    if(isset($_POST['lc_txt_num_autorisacion'])){
        $num_autorisacion = $_POST['lc_txt_num_autorisacion'];
    }
    if(isset($_POST['lc_txt_importe_total_compra'])){
        $importe_total_compra = $_POST['lc_txt_importe_total_compra'];
    }
    if(isset($_POST['lc_txt_importe_no_sujeto_credito_fiscal'])){
        $importe_no_sujeto_credito_fiscal = $_POST['lc_txt_importe_no_sujeto_credito_fiscal'];
    }
    if(isset($_POST['lc_txt_subtotal'])){
        $subtotal = $_POST['lc_txt_subtotal'];
    }
    if(isset($_POST['lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA'])){
        $descuentos_bonificaciones_y_rebajas_sujetas_IVA = $_POST['lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA'];
    }
    if(isset($_POST['lc_txt_importe_base_credito_fiscal'])){
        $importe_base_credito_fiscal = $_POST['lc_txt_importe_base_credito_fiscal'];
    }
    if(isset($_POST['lc_txt_credito_fiscal'])){
        $credito_fiscal = $_POST['lc_txt_credito_fiscal'];
    }
    if(isset($_POST['lc_txt_codigo_control'])){
        $codigo_control = $_POST['lc_txt_codigo_control'];
    }
    if(isset($_POST['lc_txt_tipo_compra'])){
        $tipo_compra = $_POST['lc_txt_tipo_compra'];
    }

    if(isset($_GET['buscar_factura_texto'])){
        $buscar_factura_texto = $_GET['buscar_factura_texto'];
    }
    if(isset($_GET['columna_Ordenar'])){
        $columna_Ordenar = $_GET['columna_Ordenar'];
    }


    if(isset($_POST['registrar_factura_lista_libro_compras'])){
        if ($ciActual != "" 
        && $codLibro != "" 
        && $fecha_factura_o_DUI != "" 
        && $nit_proveedor != "" 
        && $nombre_o_razon_social != "" 
        && $num_factura != "" 
        && $num_DUI != "" 
        && $num_autorisacion != "" 
        && $importe_total_compra != "" 
        && $importe_no_sujeto_credito_fiscal != "" 
        && $subtotal != "" 
        && $descuentos_bonificaciones_y_rebajas_sujetas_IVA != "" 
        && $importe_base_credito_fiscal != "" 
        && $credito_fiscal != "" 
        && $codigo_control != "" 
        && $tipo_compra != "") {
        registrar_factura_libro_ventas(
            $ciActual
            ,$codLibro
            ,$fecha_factura_o_DUI
            ,$nit_proveedor
            ,$nombre_o_razon_social
            ,$num_factura
            ,$num_DUI
            ,$num_autorisacion
            ,$importe_total_compra
            ,$importe_no_sujeto_credito_fiscal
            ,$subtotal
            ,$descuentos_bonificaciones_y_rebajas_sujetas_IVA
            ,$importe_base_credito_fiscal
            ,$credito_fiscal
            ,$codigo_control
            ,$tipo_compra
            );
        }
    }
    
    function registrar_factura_libro_ventas(
    $lc_ciActual
    ,$lc_codLibro
    ,$lc_fecha_factura_o_DUI
    ,$lc_nit_proveedor
    ,$lc_nombre_o_razon_social
    ,$lc_num_factura
    ,$lc_num_DUI
    ,$lc_num_autorisacion
    ,$lc_importe_total_compra
    ,$lc_importe_no_sujeto_credito_fiscal
    ,$lc_subtotal
    ,$lc_descuentos_bonificaciones_y_rebajas_sujetas_IVA
    ,$lc_importe_base_credito_fiscal
    ,$lc_credito_fiscal
    ,$lc_codigo_control
    ,$lc_tipo_compra){
    global $db;

    $query = "INSERT INTO `facturas_compras`(
        `fecha_factura_o_DUI`
        , `nit_proveedor`
        , `nombre_o_razon_social`
        , `num_factura`
        , `num_DUI`
        , `num_autorisacion`
        , `importe_total_compra`
        , `importe_no_sujeto_credito_fiscal`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        , `importe_base_credito_fiscal`
        , `credito_fiscal`
        , `codigo_control`
        , `tipo_compra`
        , `ci_usuario`
        , `cod_libro_compras`) 
        VALUES (
        '$lc_fecha_factura_o_DUI'
        ,'$lc_nit_proveedor'
        ,'$lc_nombre_o_razon_social'
        ,'$lc_num_factura'
        ,'$lc_num_DUI'
        ,'$lc_num_autorisacion'
        ,'$lc_importe_total_compra'
        ,'$lc_importe_no_sujeto_credito_fiscal'
        ,'$lc_subtotal'
        ,'$lc_descuentos_bonificaciones_y_rebajas_sujetas_IVA'
        ,'$lc_importe_base_credito_fiscal'
        ,'$lc_credito_fiscal'
        ,'$lc_codigo_control'
        ,'$lc_tipo_compra'
        ,'$lc_ciActual'
        ,'$lc_codLibro')";

        $db->query($query);
        if($db->affected_rows<=0){
            echo "<script>
                     window.location.href='listaFacturasLibroVentas.php?tituloMensajeModal=Error Registrar Factura&mensajeModal=No se registro la factura inténtelo nuevamente.';
                  </script>";
        }
        else{
            echo "<script>
                     window.location.href='listaFacturasLibroVentas.php?tituloMensajeModal=Factura Registrada&mensajeModal=La factura se registro exitosamente.';
                  </script>";
        }
    }

    if(isset($_POST['modificar_factura_lista_libro_compras'])){
        
        $nit_proveedor_actual = $_POST['lc_txt_nit_proveedor_actual'];
        $num_factura_actual = $_POST['lc_txt_num_factura_actual'];
        $num_autorisacion_actual = $_POST['lc_txt_num_autorisacion_actual'];

        $query = "UPDATE `facturas_compras` 
        SET `fecha_factura_o_DUI`= '$fecha_factura_o_DUI'
        ,`nit_proveedor`= '$nit_proveedor'
        ,`nombre_o_razon_social`= '$nombre_o_razon_social'
        ,`num_factura`= '$num_factura'
        ,`num_DUI`= '$num_DUI'
        ,`num_autorisacion`= '$num_autorisacion'
        ,`importe_total_compra`= '$importe_total_compra'
        ,`importe_no_sujeto_credito_fiscal`= '$importe_no_sujeto_credito_fiscal'
        ,`subtotal`= '$subtotal'
        ,`descuentos_bonificaciones_y_rebajas_sujetas_IVA`= '$descuentos_bonificaciones_y_rebajas_sujetas_IVA'
        ,`importe_base_credito_fiscal`= '$importe_base_credito_fiscal'
        ,`credito_fiscal`= '$credito_fiscal'
        ,`codigo_control`= '$codigo_control'
        ,`tipo_compra`= '$tipo_compra'
        WHERE `nit_proveedor`= '$nit_proveedor_actual' AND
        `num_factura`= '$num_factura_actual' AND
        `num_autorisacion`= '$num_autorisacion_actual'";
        $db->query($query);
        if($db->affected_rows<=0){
            echo 'Error Modificar';
        }
        else{
            echo 'Modificacion exitosa';
        }
    }

    if(isset($_POST['eliminar_factura_lista_libro_compras'])){
        $query = "DELETE FROM `facturas_compras`
        WHERE nit_proveedor = '$nit_proveedor' 
        AND num_factura = '$num_factura' 
        AND num_autorisacion = '$num_autorisacion'";
        $db->query($query);
        if($db->affected_rows<=0){
            echo 'error';
        }
        else{
            echo 'Eliminar_factura_lista_libro_compras exitoso';
        }
    }

    if(isset($_GET['lc_listar_facturas_registradas'])){
        $query = "SELECT * FROM `facturas_compras` WHERE `cod_libro_compras`='$codLibro'";
        listar_facturas($query);
    }

    if(isset($_GET['ordenar_factura_lista_libro_compras'])){
        $query = "SELECT * FROM `facturas_compras` WHERE `cod_libro_compras`='$codLibro' ORDER BY $columna_Ordenar";
        listar_facturas($query);
    }

    if(isset($_GET['buscar_factura_lista_libro_compras'])){
        $query = "SELECT *
        FROM `facturas_compras`
        WHERE (`cod_libro_compras` = '$codLibro')
        AND (`fecha_factura_o_DUI` like '%$buscar_factura_texto%'
        OR `nit_proveedor` like '%$buscar_factura_texto%'
        OR `nombre_o_razon_social` like '%$buscar_factura_texto%'
        OR `num_factura` like '%$buscar_factura_texto%'
        OR `num_DUI` like '%$buscar_factura_texto%'
        OR `num_autorisacion` like '%$buscar_factura_texto%'
        OR `codigo_control` like '%$buscar_factura_texto%'
        OR `tipo_compra` like '%$buscar_factura_texto%')";
        listar_facturas($query);
    }

    if (isset($_GET['lc_mostrar_listar_facturas_registradas'])) {
        $query_mostrar_exportar_facturas_libro_compras = $_SESSION['query_mostrar_exportar_facturas_libro_compras'];
        listar_facturas($query_mostrar_exportar_facturas_libro_compras);
    }

    function listar_facturas($query) {
        $_SESSION['query_mostrar_exportar_facturas_libro_compras'] = $query;
        global $db;
        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('Query Failed');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
            'fecha_factura_o_DUI' => $row['fecha_factura_o_DUI'],
            'nit_proveedor' => $row['nit_proveedor'],
            'nombre_o_razon_social' => $row['nombre_o_razon_social'],
            'num_factura' => $row['num_factura'],
            'num_DUI' => $row['num_DUI'],
            'num_autorisacion' => $row['num_autorisacion'],
            'importe_total_compra' => $row['importe_total_compra'],
            'importe_no_sujeto_credito_fiscal' => $row['importe_no_sujeto_credito_fiscal'],
            'subtotal' => $row['subtotal'],
            'descuentos_bonificaciones_y_rebajas_sujetas_IVA' => $row['descuentos_bonificaciones_y_rebajas_sujetas_IVA'],
            'importe_base_credito_fiscal' => $row['importe_base_credito_fiscal'],
            'credito_fiscal' => $row['credito_fiscal'],
            'codigo_control' => $row['codigo_control'],
            'tipo_compra' => $row['tipo_compra'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
?>


