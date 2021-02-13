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

    if(isset($_SESSION['cod_libro_compras_seleccionada'])){
        $codLibro =$_SESSION['cod_libro_compras_seleccionada'];
    }

    if(isset($_POST['libro_compras_nombre'])){
        $libro_compras_nombre = $_POST['libro_compras_nombre'];
    }

    if(isset($_POST['libro_compras_codigo'])){
        $libro_compras_codigo = $_POST['libro_compras_codigo'];
    }

    if(isset($_POST['crear_libro_compras'])){
        $query ="INSERT INTO `libro_compras`
        (`nombre`
        , `importe_total_compra`
        , `importe_no_sujeto_credito_fiscal`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        , `importe_base_credito_fiscal`
        , `credito_fiscal`
        , `nit_empresa`) 
        VALUES 
        ('$libro_compras_nombre'
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

    if(isset($_GET['listar_Libro_Compras'])){
        $query = "SELECT lc.cod_libro_compras,lc.nombre,lc.fecha_creacion
        FROM `empresa` e
        INNER JOIN `libro_compras` lc ON e.nit_empresa = lc.nit_empresa
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
                'cod_libro_compras' => $row['cod_libro_compras'],
                'nombre' => $row['nombre'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if(isset($_POST['modificar_Libro_Compras'])){
        $query = "UPDATE `libro_compras` 
        SET `nombre`='$libro_compras_nombre' 
        WHERE `cod_libro_compras`='$libro_compras_codigo'";

        $db->query($query);
        if($db->affected_rows<=0){
            die('Error Modificar');
        }
        else{
            echo 'Modificacion exitosa';
        }
    }

    if(isset($_GET['lc_modificar_libro_compras'])){
        $query = "UPDATE `empresa` e
        INNER JOIN `libro_compras` lc ON e.nit_empresa = lc.nit_empresa
        INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
        INNER JOIN `usuario`u ON u.ci_usuario = re.ci_administrador , 
        (SELECT 
        sum(fc.`importe_total_compra`) as `importe_total_compra`,
        sum(fc.`importe_no_sujeto_credito_fiscal`) as `importe_no_sujeto_credito_fiscal`,
        sum(fc.`subtotal`) as `subtotal`,
        sum(fc.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`) as `descuentos_bonificaciones_y_rebajas_sujetas_IVA`,
        sum(fc.`importe_base_credito_fiscal`) as `importe_base_credito_fiscal`,
        sum(fc.`credito_fiscal`) as `credito_fiscal` 
        FROM `facturas_compras` fc
        WHERE `cod_libro_compras`='$codLibro') fc
        SET lc.`importe_total_compra`= fc.`importe_total_compra`
        ,lc.`importe_no_sujeto_credito_fiscal`= fc.`importe_no_sujeto_credito_fiscal`
        ,lc.`subtotal`= fc.`subtotal`
        ,lc.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`= fc.`descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        ,lc.`importe_base_credito_fiscal`= fc.`importe_base_credito_fiscal`
        ,lc.`credito_fiscal`= fc.`credito_fiscal`
        WHERE  e.nit_empresa = $nit
        AND lc.`cod_libro_compras` = $codLibro";

        $db->query($query);
        if($db->affected_rows<=0){
            die('Error Modificar Libro Compras');
        }
        else{
            echo "Sumatoria Modificar Libro Compras Exitoso";
        }
    }

    if (isset($_GET['lc_mostrar_datos_libro_compras'])) {
        $query = "SELECT `fecha_creacion`
        , `nombre`
        , `importe_total_compra`
        , `importe_no_sujeto_credito_fiscal`
        , `subtotal`
        , `descuentos_bonificaciones_y_rebajas_sujetas_IVA`
        , `importe_base_credito_fiscal`
        , `credito_fiscal`
        , `nit_empresa` FROM `libro_compras`
        WHERE `cod_libro_compras` =  $codLibro";

        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('lc_mostrar_datos_libro_compras fallo');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
                'fecha_creacion' => $row['fecha_creacion'],
                'nombre' => $row['nombre'],
                'importe_total_compra' => $row['importe_total_compra'],
                'importe_no_sujeto_credito_fiscal' => $row['importe_no_sujeto_credito_fiscal'],
                'subtotal' => $row['subtotal'],
                'descuentos_bonificaciones_y_rebajas_sujetas_IVA' => $row['descuentos_bonificaciones_y_rebajas_sujetas_IVA'],
                'importe_base_credito_fiscal' => $row['importe_base_credito_fiscal'],
                'credito_fiscal' => $row['credito_fiscal'],
                'nit_empresa' => $row['nit_empresa'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }    
    
    if (isset($_GET['lc_mostrar_cantidad_facturas'])) {
        $query = "SELECT COUNT(*) 
        FROM `facturas_compras`
        WHERE `cod_libro_compras` =  $codLibro";

        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('lc_mostrar_datos_libro_compras fallo');
        }

        $row = mysqli_fetch_array($res);

        echo $row[0];
    }

    if(isset($_POST['eliminar_Libro_Compras'])){

        $query_eliminar_Libro_Compras = "DELETE fc,lc
        FROM `facturas_compras` fc
        RIGHT JOIN `libro_compras` lc 
        ON fc.cod_libro_compras = lc.cod_libro_compras
        WHERE lc.cod_libro_compras = $libro_compras_codigo";

        $db->query($query_eliminar_Libro_Compras);

        if($db->affected_rows<=0){
            echo 'error eliminar_Libro_Compras';
        }
        else{
            unset($_SESSION['cod_libro_compras_seleccionada']);
            echo 'Libro compras eliminado correctamente';
        }
    }
    
    
?>