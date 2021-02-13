<?php
    !isset($_POST) ? die('acceso denegado'):'';
    require 'Configuracion_Coneccion/conexion.class.php';
    $db=new Conexion();
    session_start();

    if(isset($_SESSION['usuCI'])){
        $ciActual =$_SESSION['usuCI'];
    }

    //Libro Compras
    if(isset($_GET['lista_empresas_nit'])){
        $nit = $_GET['lista_empresas_nit'];
    }
    if(isset($_POST['lista_empresas_nit'])){
        $nit = $_POST['lista_empresas_nit'];
    }

    if(isset($_POST['lista_empresas_nombre'])){
        $nombre = $_POST['lista_empresas_nombre'];
    }

    if(isset($_POST['registrar_empresa_cliente'])){
        if ($ciActual != ""
        && $nit != "" 
        && $nombre != "" ) {
        registrar_empresa_cliente(
            $ciActual
            ,$nit
            ,$nombre
            );
        }
    }

    function registrar_empresa_cliente(
    $lista_empresa_ciActual
    ,$lista_empresa_nit
    ,$lista_empresa_nombre)
    {
        global $db;

        $query_crear_empresa = "INSERT INTO `empresa`(
            `nit_empresa`
            , `nombre_empresa`) 
            VALUES (
            '$lista_empresa_nit'
            ,'$lista_empresa_nombre')";

        $db->query($query_crear_empresa);

        if($db->affected_rows<=0){
            echo "Error crear_empresa";
        }
        else{
            $query_crear_registra_empresa = "INSERT INTO `registra_empresa`
                (`ci_administrador`
                , `nit_empresa`) 
                VALUES (
                '$lista_empresa_ciActual'
                ,'$lista_empresa_nit')";

            $db->query($query_crear_registra_empresa);
            if($db->affected_rows<=0){
                echo "Error crear_registra_empresa";
            }
            else {
                echo "Exitoso";
            }
        }
    }

    if(isset($_GET['le_listar_empresas_clientes'])){
        $query = "SELECT e.`nit_empresa`, e.`nombre_empresa` 
        FROM `empresa` e 
        INNER JOIN `registra_empresa` re ON e.nit_empresa = re.nit_empresa 
        WHERE re.ci_administrador = '$ciActual'";

        $res=$db->query($query);
        if($db->affected_rows<=0){
            echo('Error Listar Empresas');
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
    
    if(isset($_POST['modificar_empresa_lista'])){
        $nit_actual = $_POST['lista_empresas_nit_actual'];

        $query_modificar_empresa = "UPDATE `empresa` 
        SET `nit_empresa`= '$nit'
        ,`nombre_empresa`= '$nombre'
        WHERE `nit_empresa`= '$nit_actual'";        

        $db->query($query_modificar_empresa);

        if($db->affected_rows<=0){
            die('Error Modificar Empresa');
        }
        else{
            $query_modificar_registra_empresa = "UPDATE `registra_empresa` 
            SET `nit_empresa`='$nit' 
            WHERE `ci_administrador` = '$ciActual' AND `nit_empresa`= '$nit_actual'";        
    
            $db->query($query_modificar_registra_empresa);
    
            if($db->affected_rows<=0){
                die('Error Modificar registra_empresa');
            }
            else{
                echo 'Modificacion exitosa registra_empresa';
            }

            $query_modificar_libro_compras ="UPDATE `libro_compras` 
            SET `nit_empresa`='$nit' WHERE `nit_empresa`= '$nit_actual'";
    
            $db->query($query_modificar_libro_compras);

            if($db->affected_rows<=0){
                die('Error Modificar libro_compras');
            }
            else{
                echo 'Modificacion exitosa libro_compras';
            }

            $query_modificar_libro_ventas ="UPDATE `libro_ventas` 
            SET `nit_empresa`='$nit' WHERE `nit_empresa`= '$nit_actual'";
    
            $db->query($query_modificar_libro_ventas);

            if($db->affected_rows<=0){
                die('Error Modificar libro_ventas');
            }
            else{
                echo 'Modificacion exitosa libro_ventas';
            }
        }
    }
    if(isset($_POST['eliminar_empresa_lista'])){

        $query_eliminar_empresa = "DELETE fc,fv,lc,lv,e,re
            FROM `facturas_ventas` fv
            RIGHT JOIN `libro_ventas` lv 
            ON fv.cod_libro_ventas = lv.cod_libro_ventas
            RIGHT JOIN `empresa` e
            ON e.nit_empresa = lv.nit_empresa
            LEFT JOIN `libro_compras` lc
            ON e.nit_empresa = lc.nit_empresa
            LEFT JOIN `facturas_compras` fc
            ON fc.cod_libro_compras = lc.cod_libro_compras
            LEFT JOIN `registra_empresa` re
            ON re.nit_empresa = e.nit_empresa
            WHERE e.nit_empresa = $nit AND re.ci_administrador = $ciActual";

        $db->query($query_eliminar_empresa);

        if($db->affected_rows<=0){
            echo 'error eliminar_empresa';
        }
        else{
            echo 'Empresa Eliminada exitosamente';
        }
    }

    if(isset($_GET['listar_libros_compras_ventas'])){
        //INCOMPLETO WHERE CI_USUARIO=1

        $query = "SELECT lc.nombre,lc.fecha_creacion,lv.nombre,lv.fecha_creacion
        FROM `empresa` e
        INNER JOIN `libro_compras` lc ON lc.nit_empresa = e.nit_empresa
        INNER JOIN `libro_ventas` lv ON lv.nit_empresa = e.nit_empresa
        WHERE e.nit_empresa = $nit";
        //echo $query;

        $res=$db->query($query);
        if($db->affected_rows<=0){
            die('Query Failed Listar Libro Compras');
        }
        $json = array();
        while($row = mysqli_fetch_array($res)) {
            $json[] = array(
            'fecha_creacion' => $row['fecha_creacion'],
            'nombre' => $row['nombre'],
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
?>