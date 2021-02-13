<?php
    !isset($_POST) ? die('acceso denegado'):'';
    require 'Configuracion_Coneccion/conexion.class.php';
    $db=new Conexion();
    session_start();

    if(isset($_SESSION['usuCI'])){
        $ciActual =$_SESSION['usuCI'];
    }

    if(isset($_SESSION['nit_empresa_seleccionada'])){
        $nit =$_SESSION['nit_empresa_seleccionada'];
    }

    if(isset($_SESSION['cod_libro_ventas_seleccionado'])){
        $codLibro =$_SESSION['cod_libro_ventas_seleccionado'];
    }

    if(isset($_POST['libro_ventas_nombre'])){
        $libro_ventas_nombre = $_POST['libro_ventas_nombre'];
    } 

    if(isset($_POST['libro_ventas_codigo'])){
        $libro_ventas_codigo = $_POST['libro_ventas_codigo'];
    }

    if(isset($_POST['crear_libro_ventas'])){

        $query ="INSERT INTO `libro_ventas`
        (`nombre`
        , `importe_total_venta`
        , `importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`
        , `exportaciones_y_operaciones_exentas`
        , `ventas_gravadas_tasa_cero`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        ,`importe_base_debito_fiscal`
        , `debito_fiscal`
        , `nit_empresa`) 
        VALUES 
        ('$libro_ventas_nombre'
        ,'0'
        ,'0'
        ,'0'
        ,'0'
        ,'0'
        ,'0'
        ,'0'
        ,'0'
        ,'$nit')";
        $db->query($query);

        if($db->affected_rows<=0){
            echo "Error";
        }
        else{
            echo "Exitoso";
        }
        
    }

    if(isset($_GET['listar_Libro_Ventas'])){
        $query = "SELECT lv.cod_libro_ventas,lv.nombre,lv.fecha_creacion
        FROM `empresa` e
        INNER JOIN `libro_ventas` lv ON e.nit_empresa = lv.nit_empresa
        INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
        INNER JOIN `usuario`u ON u.ci_usuario = re.ci_administrador
        WHERE u.ci_usuario = $ciActual AND e.nit_empresa = $nit";

        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('Query Failed');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
                'cod_libro_ventas' => $row['cod_libro_ventas'],
                'nombre' => $row['nombre'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if(isset($_POST['modificar_Libro_Ventas'])){
        $query = "UPDATE `libro_ventas` 
        SET `nombre`='$libro_ventas_nombre' 
        WHERE `cod_libro_ventas`='$libro_ventas_codigo'";

        $db->query($query);
        if($db->affected_rows<=0){
            die('Error Modificar');
        }
        else{
            echo 'Modificacion exitosa';
        }
    }

    if(isset($_GET['lv_modificar_libro_ventas'])){
        $query = "UPDATE `empresa` e
        INNER JOIN `libro_ventas` lv ON e.nit_empresa = lv.nit_empresa
        INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
        INNER JOIN `usuario`u ON u.ci_usuario = re.ci_administrador,
        (SELECT sum(fv.`importe_total_venta`) as importe_total_venta,
        sum(fv.`importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`) as importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA,
        sum(fv.`exportaciones_y_operaciones_exentas`) as exportaciones_y_operaciones_exentas,
        sum(fv.`ventas_gravadas_tasa_cero`) as ventas_gravadas_tasa_cero,
        sum(fv.`subtotal`) as subtotal,
        sum(fv.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`) as descuentos_bonificaciones_y_rebajas_sujetas_IVA, 
        sum(fv.`importe_base_debito_fiscal`) as importe_base_debito_fiscal,
        sum(fv.`debito_fiscal`) as debito_fiscal
        FROM `facturas_ventas` fv
        WHERE `cod_libro_ventas`='$codLibro') fv
        SET lv.`importe_total_venta`=fv.`importe_total_venta`
        ,lv.`importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`=fv.`importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`
        ,lv.`exportaciones_y_operaciones_exentas`=fv.`exportaciones_y_operaciones_exentas`
        ,lv.`ventas_gravadas_tasa_cero`=fv.`ventas_gravadas_tasa_cero`
        ,lv.`subtotal`=fv.`subtotal`
        ,lv.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`=fv.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        ,lv.`importe_base_debito_fiscal`=fv.`importe_base_debito_fiscal`
        ,lv.`debito_fiscal`=fv.`debito_fiscal`
        WHERE e.nit_empresa = $nit
        AND `cod_libro_ventas`='$codLibro'";

        $db->query($query);
        if($db->affected_rows<=0){
            echo('Error Modificar Libro Ventas');
        }
        else{
            echo "Sumatoria Modificar Libro Ventas Exitoso";
        }
    }

    if (isset($_GET['lv_mostrar_datos_libro_ventas'])) {
        $query = "SELECT `fecha_creacion`
        , `nombre`
        , `importe_total_venta`
        , `importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA`
        , `exportaciones_y_operaciones_exentas`
        , `ventas_gravadas_tasa_cero`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        , `importe_base_debito_fiscal`
        , `debito_fiscal`
        , `nit_empresa` FROM `libro_ventas`
        WHERE `cod_libro_ventas` =  $codLibro";

        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('lv_mostrar_datos_libro_ventas fallo');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
                'fecha_creacion' => $row['fecha_creacion'],
                'nombre' => $row['nombre'],
                'importe_total_venta' => $row['importe_total_venta'],
                'importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA' => $row['importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA'],
                'exportaciones_y_operaciones_exentas' => $row['exportaciones_y_operaciones_exentas'],
                'ventas_gravadas_tasa_cero' => $row['ventas_gravadas_tasa_cero'],
                'subtotal' => $row['subtotal'],
                'importe_base_debito_fiscal' => $row['importe_base_debito_fiscal'],
                'debito_fiscal' => $row['debito_fiscal'],
                'descuentos_bonificaciones_y_rebajas_sujetas_IVA' => $row['descuentos_bonificaciones_y_rebajas_sujetas_IVA'],
                'nit_empresa' => $row['nit_empresa'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if (isset($_GET['lv_mostrar_cantidad_facturas'])) {
        $query = "SELECT COUNT(*) 
        FROM `facturas_ventas`
        WHERE `cod_libro_ventas` =  $codLibro";
        
        $res=$db->query($query);
        if($db->affected_rows<=0){
            echo 'lv_mostrar_cantidad_facturas fallo' ;
        }

        $row = mysqli_fetch_array($res);

        echo $row[0];
    }

    if(isset($_POST['eliminar_Libro_Ventas'])){
        $query_eliminar_libro_ventas = "DELETE fv,lv
        FROM `facturas_ventas` fv
        RIGHT JOIN `libro_ventas` lv 
        ON fv.cod_libro_ventas = lv.cod_libro_ventas
        WHERE lv.cod_libro_ventas = $libro_ventas_codigo";
        
        $db->query($query_eliminar_libro_ventas);
        if($db->affected_rows<=0){
            echo 'error eliminar_Libro_Ventas';
        }
        else{
            unset($_SESSION['cod_libro_ventas_seleccionado']);
            echo 'eliminar_Libro_Ventas exitoso';
        }
    }

?>