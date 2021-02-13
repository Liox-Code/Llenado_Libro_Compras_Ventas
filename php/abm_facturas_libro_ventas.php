<?php
    !isset($_POST) ? die('acceso denegado'):'';
    require 'Configuracion_Coneccion/conexion.class.php';
    $db=new Conexion();
    session_start();

    if(isset($_SESSION['usuCI'])){
        $ciActual =$_SESSION['usuCI'];
    }

    if(isset($_SESSION['cod_libro_ventas_seleccionado'])){
        $codLibro = $_SESSION['cod_libro_ventas_seleccionado'];
    }

    //Libro Ventas
    if(isset($_POST['lv_txt_Fecha_Factura'])){
        $fechaFactura=$_POST['lv_txt_Fecha_Factura'];
    }
    if(isset($_POST['lv_txt_Num_Factura'])){
        $numFactura=$_POST['lv_txt_Num_Factura'];
    }
    if(isset($_POST['lv_txt_Num_Autorizacion'])){
        $numAutorizacion=$_POST['lv_txt_Num_Autorizacion'];
    }
    if(isset($_POST['lv_txt_Estado'])){
        $estado=$_POST['lv_txt_Estado'];
    }
    if(isset($_POST['lv_txt_Nit_CI_Cliente'])){
        $nitCiCliente=$_POST['lv_txt_Nit_CI_Cliente'];
    }
    if(isset($_POST['lv_txt_Nombre_Razon_Social'])){
        $nombreRazonSocial=$_POST['lv_txt_Nombre_Razon_Social'];
    }
    if(isset($_POST['lv_txt_Importe_Total_Venta'])){
        $importeTotalVenta=$_POST['lv_txt_Importe_Total_Venta'];
    }
    if(isset($_POST['lv_txt_Importe_No_Sujeto_IVA'])){
        $importeNoSujetoIva=$_POST['lv_txt_Importe_No_Sujeto_IVA'];
    }
    if(isset($_POST['lv_txt_Exportaciones_y_Operaciones_Exentas'])){
        $exportacionesOperacionesExentas=$_POST['lv_txt_Exportaciones_y_Operaciones_Exentas'];
    }
    if(isset($_POST['lv_txt_Ventas_Gravadas_Tasa_Cero'])){
        $ventasGravadasTasaCero=$_POST['lv_txt_Ventas_Gravadas_Tasa_Cero'];
    }
    if(isset($_POST['lv_txt_Subtotal'])){
        $subtotal=$_POST['lv_txt_Subtotal'];
    }
    if(isset($_POST['lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA'])){
        $descuentosBonificacionesRebajasSujetasIVA=$_POST['lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA'];
    }
    if(isset($_POST['lv_txt_Importe_Base_Débito_Fiscal'])){
        $importeBaseDébitoFiscal=$_POST['lv_txt_Importe_Base_Débito_Fiscal'];
    }
    if(isset($_POST['lv_txt_Débito_Fiscal'])){
        $débitoFiscal=$_POST['lv_txt_Débito_Fiscal'];
    }
    if(isset($_POST['lv_txt_Código_Control'])){
        $códigoControl=$_POST['lv_txt_Código_Control'];
    }

    if(isset($_GET['buscar_factura_texto'])){
        $buscar_factura_texto = $_GET['buscar_factura_texto'];
    }
    if(isset($_GET['columna_Ordenar'])){
        $columna_Ordenar=$_GET['columna_Ordenar'];
    }

    if(isset($_POST['registrar_factura_lista_libro_ventas'])){
        if ($ciActual != "" && $codLibro != "" && $fechaFactura != "" && $numFactura != "" && $numAutorizacion != "" && $estado != "" && $nitCiCliente != "" && $nombreRazonSocial != "" && $importeTotalVenta != "" && $importeNoSujetoIva != "" && $exportacionesOperacionesExentas != "" && $ventasGravadasTasaCero != "" && $subtotal != "" && $descuentosBonificacionesRebajasSujetasIVA != "" && $importeBaseDébitoFiscal != "" && $débitoFiscal != "" && $códigoControl != "" && $ciActual != "") {
            registrar_factura_libro_ventas(
            $ciActual
            ,$codLibro
            ,$fechaFactura
            ,$numFactura
            ,$numAutorizacion
            ,$estado
            ,$nitCiCliente
            ,$nombreRazonSocial
            ,$importeTotalVenta
            ,$importeNoSujetoIva
            ,$exportacionesOperacionesExentas
            ,$ventasGravadasTasaCero
            ,$subtotal
            ,$descuentosBonificacionesRebajasSujetasIVA
            ,$importeBaseDébitoFiscal
            ,$débitoFiscal
            ,$códigoControl
            );
        }
    }
    
    function registrar_factura_libro_ventas($lvCiActual,$lvCodLibro,$lvFechaFactura,$lvNumFactura,$lvNumAutorizacion,$lvEstado,$lvNitCiCliente,$lvNombreRazonSocial,$lvImporteTotalVenta,$lvImporteNoSujetoIva,$lvExportacionesOperacionesExentas,$lvVentasGravadasTasaCero,$lvSubtotal,$lvDescuentosBonificacionesRebajasSujetasIVA,$lvImporteBaseDébitoFiscal,$lvDébitoFiscal,$lvCódigoControl){
        global $db;
        $query = "INSERT INTO `facturas_ventas`(
        `fecha_factura`
        , `num_factura`
        , `num_autorisacion`
        , `estado`
        , `nit_ci_cliente`
        , `nombre_o_razon_social`
        , `importe_total_venta`
        , `importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`
        , `exportaciones_y_operaciones_exentas`
        , `ventas_gravadas_tasa_cero`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        , `importe_base_debito_fiscal`
        , `debito_fiscal`
        , `codigo_control`
        , `ci_usuario`
        , `cod_libro_ventas`) 
        VALUES (
        '$lvFechaFactura'
        ,'$lvNumFactura'
        ,'$lvNumAutorizacion'
        ,'$lvEstado'
        ,'$lvNitCiCliente'
        ,'$lvNombreRazonSocial'
        ,'$lvImporteTotalVenta'
        ,'$lvImporteNoSujetoIva'
        ,'$lvExportacionesOperacionesExentas'
        ,'$lvVentasGravadasTasaCero'
        ,'$lvSubtotal'
        ,'$lvDescuentosBonificacionesRebajasSujetasIVA'
        ,'$lvImporteBaseDébitoFiscal'
        ,'$lvDébitoFiscal'
        ,'$lvCódigoControl'
        ,'$lvCiActual'
        ,'$lvCodLibro')";
        $db->query($query);
        if($db->affected_rows<=0){
            echo "Error registrar_factura_libro_ventas";
        }
        else{
            echo "registrar_factura_libro_ventas  Exitoso";
        }
    }

    if(isset($_POST['modificar_factura_lista_libro_ventas'])){
        
        $num_Factura_actual=$_POST['lv_txt_Num_Factura_actual'];
        $num_Autorizacion_actual=$_POST['lv_txt_Num_Autorizacion_actual'];
        $nit_CI_Cliente_actual=$_POST['lv_txt_Nit_CI_Cliente_actual'];

        $query = "UPDATE `facturas_ventas` 
        SET `fecha_factura`= '$fechaFactura'
        ,`num_factura`= '$numFactura'
        ,`num_autorisacion`= '$numAutorizacion'
        ,`estado`= '$estado'
        ,`nit_ci_cliente`= '$nitCiCliente'
        ,`nombre_o_razon_social`= '$nombreRazonSocial'
        ,`importe_total_venta`= '$importeTotalVenta'
        ,`importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`= '$importeNoSujetoIva'
        ,`exportaciones_y_operaciones_exentas`= '$exportacionesOperacionesExentas'
        ,`ventas_gravadas_tasa_cero`= '$ventasGravadasTasaCero'
        ,`subtotal`= '$subtotal'
        ,`descuentos_bonificaciones_y_rebajas_sujetas_IVA`= '$descuentosBonificacionesRebajasSujetasIVA'
        ,`importe_base_debito_fiscal`= '$importeBaseDébitoFiscal'
        ,`debito_fiscal`= '$débitoFiscal'
        ,`codigo_control`= '$códigoControl'
        WHERE `num_factura`= '$num_Factura_actual' AND
        `num_autorisacion`= '$num_Autorizacion_actual' AND
        `nit_ci_cliente`= '$nit_CI_Cliente_actual'";
        $db->query($query);
        if($db->affected_rows<=0){
            die('Error Modificar');
        }
        else{
            echo 'Modificacion exitosa';
        }
    }

    if(isset($_POST['eliminar_factura_lista_libro_ventas'])){
        $query = "DELETE FROM `facturas_ventas` WHERE num_factura = '$numFactura' AND num_autorisacion = '$numAutorizacion' AND nit_ci_cliente = '$nitCiCliente'";
        $db->query($query);
        if($db->affected_rows<=0){
            echo $query.'error eliminar_factura_lista_libro_ventas';
        }
        else{
            echo $query;
        }
    }

    if(isset($_GET['lv_listar_facturas_registradas'])){
        $query = "SELECT * FROM `facturas_ventas` WHERE `cod_libro_ventas`='$codLibro'";
        listar_facturas($query);
    }

    if(isset($_GET['ordenar_factura_lista_libro_ventas'])){
        $query = "SELECT * FROM `facturas_ventas` WHERE `cod_libro_ventas`='$codLibro' ORDER BY $columna_Ordenar";
        listar_facturas($query);
    }

    if(isset($_GET['buscar_factura_lista_libro_ventas'])){
        $query = "SELECT *
        FROM `facturas_ventas`
        WHERE (`cod_libro_ventas` = '$codLibro')
        AND (`fecha_factura` like '%$buscar_factura_texto%'
        OR `num_factura` like '%$buscar_factura_texto%'
        OR `num_autorisacion` like '%$buscar_factura_texto%'
        OR `estado` like '%$buscar_factura_texto%'
        OR `nit_ci_cliente` like '%$buscar_factura_texto%'
        OR `nombre_o_razon_social` like '%$buscar_factura_texto%'
        OR `codigo_control` like '%$buscar_factura_texto%')";
        listar_facturas($query);
    }

    if (isset($_GET['lv_mostrar_facturas_registradas_exportar'])) {
        $query_mostrar_exportar_facturas_libro_ventas = $_SESSION['query_mostrar_exportar_facturas_libro_ventas'];
        listar_facturas($query_mostrar_exportar_facturas_libro_ventas);
    }

    function listar_facturas($query) {
        $_SESSION['query_mostrar_exportar_facturas_libro_ventas'] = $query;
        global $db;
        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('Query Failed');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
            'fecha_factura' => $row['fecha_factura'],
            'num_factura' => $row['num_factura'],
            'num_autorisacion' => $row['num_autorisacion'],
            'estado' => $row['estado'],
            'nit_ci_cliente' => $row['nit_ci_cliente'],
            'nombre_o_razon_social' => $row['nombre_o_razon_social'],
            'importe_total_venta' => $row['importe_total_venta'],
            'importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA' => $row['importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA'],
            'exportaciones_y_operaciones_exentas' => $row['exportaciones_y_operaciones_exentas'],
            'ventas_gravadas_tasa_cero' => $row['ventas_gravadas_tasa_cero'],
            'subtotal' => $row['subtotal'],
            'descuentos_bonificaciones_y_rebajas_sujetas_IVA' => $row['descuentos_bonificaciones_y_rebajas_sujetas_IVA'],
            'importe_base_debito_fiscal' => $row['importe_base_debito_fiscal'],
            'debito_fiscal' => $row['debito_fiscal'],
            'codigo_control' => $row['codigo_control'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
?>


