$(document).ready(function() {
    listar_facturas();

    function listar_facturas() {
        const lv_listar_facturas_registradas = true;
        $.get('abm_facturas_libro_ventas.php', {lv_listar_facturas_registradas}, (response) => {
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                datos_factura += insertar_filas(factura);
            }
            catch(e) {
                console.log('Error listar_facturas');
            }
            finally {
                $('#lista_facturas_libro_ventas').html(datos_factura);
                $(document).find('.modificar_factura_lista_libro_ventas').hide();
                $(document).find('.cancelar_modificar_factura_lista_libro_ventas').hide(); 
            }
        });
        actualizar_Libro();
        mostrar_libro_ventas();
    }

    function actualizar_Libro(){
        const lv_modificar_libro_ventas = true;
        $.get('abm_libro_ventas.php', {lv_modificar_libro_ventas}, (response) => {
            console.log(response);
        });
    }

    function mostrar_libro_ventas() {
        const lv_mostrar_datos_libro_ventas = true;
        var tabla = $('.lblInformacion');
        $.get('abm_libro_ventas.php', {lv_mostrar_datos_libro_ventas}, (response) => {
            try {
                const libro_venta = JSON.parse(response);
                libro_venta.forEach(dato_libro_venta => {
                    tabla.find('.divInformacionDatos').eq(0).text(dato_libro_venta.nombre);
                    tabla.find('.divInformacionDatos').eq(1).text(dato_libro_venta.fecha_creacion);
                    tabla.find('.divInformacionDatos').eq(2).text(dato_libro_venta.importe_total_venta);
                    tabla.find('.divInformacionDatos').eq(4).text(dato_libro_venta.importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA);
                    tabla.find('.divInformacionDatos').eq(6).text(dato_libro_venta.exportaciones_y_operaciones_exentas);
                    tabla.find('.divInformacionDatos').eq(8).text(dato_libro_venta.ventas_gravadas_tasa_cero);
                    tabla.find('.divInformacionDatos').eq(3).text(dato_libro_venta.subtotal);
                    tabla.find('.divInformacionDatos').eq(5).text(dato_libro_venta.descuentos_bonificaciones_y_rebajas_sujetas_IVA);
                    tabla.find('.divInformacionDatos').eq(7).text(dato_libro_venta.importe_base_debito_fiscal);
                    tabla.find('.divInformacionDatos').eq(9).text(dato_libro_venta.debito_fiscal);
                });
            }
            catch(e) {
                console.log('Error lv_mostrar_datos_libro_ventas');
            }
        });
        const lv_mostrar_cantidad_facturas = true;
        $.get('abm_libro_ventas.php', {lv_mostrar_cantidad_facturas}, (response) => {
            tabla.find('.divInformacionDatos').eq(10).text(response);
        });
    }

    function datos_libro_ventas(){
        const datosFactura = {
            lv_txt_Fecha_Factura: $('#lv_txt_Fecha_Factura').val(),
            lv_txt_Num_Factura: $('#lv_txt_Num_Factura').val(),
            lv_txt_Num_Autorizacion: $('#lv_txt_Num_Autorizacion').val(),
            lv_txt_Estado: $('#lv_txt_Estado').val(),
            lv_txt_Nit_CI_Cliente: $('#lv_txt_Nit_CI_Cliente').val(),
            lv_txt_Nombre_Razon_Social: $('#lv_txt_Nombre_Razon_Social').val(),
            lv_txt_Importe_Total_Venta: $('#lv_txt_Importe_Total_Venta').val(),
            lv_txt_Importe_No_Sujeto_IVA: $('#lv_txt_Importe_No_Sujeto_IVA').val(),
            lv_txt_Exportaciones_y_Operaciones_Exentas: $('#lv_txt_Exportaciones_y_Operaciones_Exentas').val(),
            lv_txt_Ventas_Gravadas_Tasa_Cero: $('#lv_txt_Ventas_Gravadas_Tasa_Cero').val(),
            lv_txt_Subtotal: $('#lv_txt_Subtotal').val(),
            lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA: $('#lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA').val(),
            lv_txt_Importe_Base_Débito_Fiscal: $('#lv_txt_Importe_Base_Débito_Fiscal').val(),
            lv_txt_Débito_Fiscal: $('#lv_txt_Débito_Fiscal').val(),
            lv_txt_Código_Control: $('#lv_txt_Código_Control').val(),
        };
        return datosFactura;
    }

    function operaciones_automatizadas(
        Importe_Total_Venta
        ,Importe_No_Sujeto_IVA
        ,Exportaciones_y_Operaciones_Exentas
        ,Ventas_Gravadas_Tasa_Cero
        ,Descuentos_Bonificaciones_Rebajas_Sujetas_IVA){
        if(isNaN(Importe_Total_Venta)){
            Importe_Total_Venta = 0;
        }
        if(isNaN(Importe_No_Sujeto_IVA)){
            Importe_No_Sujeto_IVA = 0;
        }
        if(isNaN(Exportaciones_y_Operaciones_Exentas)){
            Exportaciones_y_Operaciones_Exentas = 0;
        }
        if(isNaN(Ventas_Gravadas_Tasa_Cero)){
            Ventas_Gravadas_Tasa_Cero = 0;
        }
        if(isNaN(Descuentos_Bonificaciones_Rebajas_Sujetas_IVA)){
            Descuentos_Bonificaciones_Rebajas_Sujetas_IVA = 0;
        }

        subtotal = (parseFloat(Importe_Total_Venta-Importe_No_Sujeto_IVA-Exportaciones_y_Operaciones_Exentas-Ventas_Gravadas_Tasa_Cero)).toFixed(2);
        $('#lv_txt_Subtotal').val(subtotal);
        Importe_Base_Débito_Fiscal = (parseFloat(subtotal - Descuentos_Bonificaciones_Rebajas_Sujetas_IVA)).toFixed(2);
        $('#lv_txt_Importe_Base_Débito_Fiscal').val(Importe_Base_Débito_Fiscal);
        Débito_Fiscal = (parseFloat(Importe_Base_Débito_Fiscal * 0.13)).toFixed(2);
        $('#lv_txt_Débito_Fiscal').val(Débito_Fiscal);
    }

    function insertar_filas(json_datos_factura){
        let datos_factura = '';
        json_datos_factura.forEach(dato_factura => {
            datos_factura += `
                <tr>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='10'>${dato_factura.fecha_factura}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='15'>${dato_factura.num_factura}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='15'>${dato_factura.num_autorisacion}</div></td>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='1'>${dato_factura.estado}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='13'>${dato_factura.nit_ci_cliente}</div></td>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='150'>${dato_factura.nombre_o_razon_social}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_total_venta}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.exportaciones_y_operaciones_exentas}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.ventas_gravadas_tasa_cero}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.subtotal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.descuentos_bonificaciones_y_rebajas_sujetas_IVA}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_base_debito_fiscal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.debito_fiscal}</div></td>
                    <td><div class='dato_factura_mod'>${dato_factura.codigo_control}</div></td>
                    <td>
                        <span class='habilitar_modificar_factura_lista_libro_ventas'><a href='#' num_Factura='${dato_factura.num_factura}' num_Autorizacion='${dato_factura.num_autorisacion}' nit_CI_Cliente='${dato_factura.nit_ci_cliente}'><img src='../img/editar.png' class='imgABM'></a></span>
                        <span class='modificar_factura_lista_libro_ventas'> <a href='#' num_Factura='${dato_factura.num_factura}' num_Autorizacion='${dato_factura.num_autorisacion}' nit_CI_Cliente='${dato_factura.nit_ci_cliente}'> Guardar</a></span>
                        <span class='cancelar_modificar_factura_lista_libro_ventas'> <a href='#' num_Factura='${dato_factura.num_factura}' num_Autorizacion='${dato_factura.num_autorisacion}' nit_CI_Cliente='${dato_factura.nit_ci_cliente}'> Cancelar</a></span>
                    </td>
                    <td><a href='#' class='eliminar_factura_lista_libro_ventas' num_Factura='${dato_factura.num_factura}' num_Autorizacion='${dato_factura.num_autorisacion}' nit_CI_Cliente='${dato_factura.nit_ci_cliente}'><img src='../img/eliminar.png' class='imgABM'></a></td>
                </tr>
                `;
        });
        return datos_factura;
    }
    
    $('#lv_txt_Importe_Total_Venta,#lv_txt_Importe_No_Sujeto_IVA,#lv_txt_Exportaciones_y_Operaciones_Exentas,#lv_txt_Ventas_Gravadas_Tasa_Cero,#lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA').keyup(e => {
        Importe_Total_Venta = parseFloat($('#lv_txt_Importe_Total_Venta').val());
        Importe_No_Sujeto_IVA = parseFloat($('#lv_txt_Importe_No_Sujeto_IVA').val());
        Exportaciones_y_Operaciones_Exentas = parseFloat($('#lv_txt_Exportaciones_y_Operaciones_Exentas').val());
        Ventas_Gravadas_Tasa_Cero = parseFloat($('#lv_txt_Ventas_Gravadas_Tasa_Cero').val());
        Descuentos_Bonificaciones_Rebajas_Sujetas_IVA = parseFloat($('#lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA').val());

        operaciones_automatizadas(
            Importe_Total_Venta
            ,Importe_No_Sujeto_IVA
            ,Exportaciones_y_Operaciones_Exentas
            ,Ventas_Gravadas_Tasa_Cero
            ,Descuentos_Bonificaciones_Rebajas_Sujetas_IVA
        );
    });

    $(document).on('click', '.btn_Ordenar', function(event)  {
        nombre_columna_ordenar = $(this).attr('name');
        const ordenar = {
            ordenar_factura_lista_libro_ventas:    true,
        };
        switch (nombre_columna_ordenar) {
            case "Fecha_Factura":
                ordenar.columna_Ordenar = "fecha_factura";
                break;
            case "Num_Factura":
                ordenar.columna_Ordenar = "num_factura";
                break;
            case "Num_Autorizacion":
                ordenar.columna_Ordenar = "num_autorisacion";
                break;
            case "Estado":
                ordenar.columna_Ordenar = "estado";
                break;   
            case "Nit_CI_Cliente":
                ordenar.columna_Ordenar = "nit_ci_cliente";
                break;
            case "Nombre_Razon_Social":
                ordenar.columna_Ordenar = "nombre_o_razon_social";
                break;
            case "Código_Control":
                ordenar.columna_Ordenar = "codigo_control";
                break;
        }
        const url ='abm_facturas_libro_ventas.php';
        $.get(url, ordenar, (response) => {
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                datos_factura += insertar_filas(factura);
            }
            catch(e) {
                    console.log("Error ordenar");
            }
            finally {
                    $('#lista_facturas_libro_ventas').html(datos_factura);
                    $(document).find('.modificar_factura_lista_libro_ventas').hide();
                    $(document).find('.cancelar_modificar_factura_lista_libro_ventas').hide();
            }
        });
    });

    $('.buscador_facturas').keyup(e => {
        const buscarFactura = {
            buscar_factura_texto: $('.buscador_facturas').val(),
            buscar_factura_lista_libro_ventas: true,
        };
        const url = "abm_facturas_libro_ventas.php";
        $.get(url, buscarFactura, (response) => {
            //console.log(response);
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                datos_factura += insertar_filas(factura);
            }
            catch(e) {
                    console.log("Error buscador_facturas");
            }
            finally {
                    $('#lista_facturas_libro_ventas').html(datos_factura);
                    $(document).find('.modificar_factura_lista_libro_ventas').hide();
                    $(document).find('.cancelar_modificar_factura_lista_libro_ventas').hide();
            }
        });
    });
    
    $('#registrar_factura_lista_libro_ventas').submit(e => {
        e.preventDefault();
        const datosFactura = datos_libro_ventas();
        datosFactura.registrar_factura_lista_libro_ventas = true;
        const url ='abm_facturas_libro_ventas.php';
        $.post(url, datosFactura, (response) => {
          console.log(response);
          //$('#registrar_factura_lista_libro_ventas').trigger('reset');
            listar_facturas();
        });
      });

    $(document).on('keyup', '.dato_factura_mod', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
        Importe_Total_Venta = parseFloat(fila_tabla.find('.dato_factura_mod').eq(6).text());
        Importe_No_Sujeto_IVA = parseFloat(fila_tabla.find('.dato_factura_mod').eq(7).text());
        Exportaciones_y_Operaciones_Exentas = parseFloat(fila_tabla.find('.dato_factura_mod').eq(8).text());
        Ventas_Gravadas_Tasa_Cero = parseFloat(fila_tabla.find('.dato_factura_mod').eq(9).text());
        Descuentos_Bonificaciones_Rebajas_Sujetas_IVA = parseFloat(fila_tabla.find('.dato_factura_mod').eq(11).text());

        if(isNaN(Importe_Total_Venta)){
            Importe_Total_Venta = 0;
        }
        if(isNaN(Importe_No_Sujeto_IVA)){
            Importe_No_Sujeto_IVA = 0;
        }
        if(isNaN(Exportaciones_y_Operaciones_Exentas)){
            Exportaciones_y_Operaciones_Exentas = 0;
        }
        if(isNaN(Ventas_Gravadas_Tasa_Cero)){
            Ventas_Gravadas_Tasa_Cero = 0;
        }
        if(isNaN(Descuentos_Bonificaciones_Rebajas_Sujetas_IVA)){
            Descuentos_Bonificaciones_Rebajas_Sujetas_IVA = 0;
        }

        Subtotal = (Importe_Total_Venta - Importe_No_Sujeto_IVA - Exportaciones_y_Operaciones_Exentas - Ventas_Gravadas_Tasa_Cero).toFixed(2);
        Importe_Base_Débito_Fiscal = (Subtotal - Descuentos_Bonificaciones_Rebajas_Sujetas_IVA).toFixed(2);
        Débito_Fiscal = (Importe_Base_Débito_Fiscal * 0.13).toFixed(2);

        fila_tabla.find('.dato_factura_mod').eq(10).text(Subtotal);
        fila_tabla.find('.dato_factura_mod').eq(12).text(Importe_Base_Débito_Fiscal);
        fila_tabla.find('.dato_factura_mod').eq(13).text(Débito_Fiscal);
    });

      $(document).on('click', '.habilitar_modificar_factura_lista_libro_ventas', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');

        fila_tabla.find('.habilitar_modificar_factura_lista_libro_ventas').hide();
        fila_tabla.find('.modificar_factura_lista_libro_ventas').show();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_ventas').show();

        fila_tabla.find('.dato_factura_mod')
		.attr('contenteditable', 'true')
        .css('padding','3px')		
                
        fila_tabla.find('.dato_factura_mod').each(function() 
		{  
			$(this).attr('valor_Original', $(this).html());
        });
        fila_tabla.find('.dato_factura_mod').eq(10).attr('contenteditable', 'false');
        fila_tabla.find('.dato_factura_mod').eq(12).attr('contenteditable', 'false');
        fila_tabla.find('.dato_factura_mod').eq(13).attr('contenteditable', 'false');
    });

    $(document).on('click', '.modificar_factura_lista_libro_ventas', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');

        var btn = $(this).find('a');

		fila_tabla.find('.habilitar_modificar_factura_lista_libro_ventas').show();
        fila_tabla.find('.modificar_factura_lista_libro_ventas').hide();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_ventas').hide();

		fila_tabla.find('.dato_factura_mod')
		.attr('contenteditable', 'false')
		.removeAttr('valor_Original')
        .css('padding','')

        const datos_Factura_A_Modificar = {
            lv_txt_Fecha_Factura:                                   fila_tabla.find('.dato_factura_mod').eq(0).text(),
            lv_txt_Num_Factura:                                     fila_tabla.find('.dato_factura_mod').eq(1).text(),
            lv_txt_Num_Autorizacion:                                fila_tabla.find('.dato_factura_mod').eq(2).text(),
            lv_txt_Estado:                                          fila_tabla.find('.dato_factura_mod').eq(3).text(),
            lv_txt_Nit_CI_Cliente:                                  fila_tabla.find('.dato_factura_mod').eq(4).text(),
            lv_txt_Nombre_Razon_Social:                             fila_tabla.find('.dato_factura_mod').eq(5).text(),
            lv_txt_Importe_Total_Venta:                             fila_tabla.find('.dato_factura_mod').eq(6).text(),
            lv_txt_Importe_No_Sujeto_IVA:                           fila_tabla.find('.dato_factura_mod').eq(7).text(),
            lv_txt_Exportaciones_y_Operaciones_Exentas:             fila_tabla.find('.dato_factura_mod').eq(8).text(),
            lv_txt_Ventas_Gravadas_Tasa_Cero:                       fila_tabla.find('.dato_factura_mod').eq(9).text(),
            lv_txt_Subtotal:                                        fila_tabla.find('.dato_factura_mod').eq(10).text(),
            lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA:   fila_tabla.find('.dato_factura_mod').eq(11).text(),
            lv_txt_Importe_Base_Débito_Fiscal:                      fila_tabla.find('.dato_factura_mod').eq(12).text(),
            lv_txt_Débito_Fiscal:                                   fila_tabla.find('.dato_factura_mod').eq(13).text(),
            lv_txt_Código_Control:                                  fila_tabla.find('.dato_factura_mod').eq(14).text(),
            lv_txt_Num_Factura_actual:                              btn.attr('num_Factura'),
            lv_txt_Num_Autorizacion_actual:                         btn.attr('num_Autorizacion'),
            lv_txt_Nit_CI_Cliente_actual:                           btn.attr('nit_CI_Cliente'),
            modificar_factura_lista_libro_ventas:                   true,
        };
        const url ='abm_facturas_libro_ventas.php';
        console.log(datos_Factura_A_Modificar);
        $.post(url, datos_Factura_A_Modificar, (response) => {
            console.log(response);
            actualizar_Libro();
            mostrar_libro_ventas();
        });

    });

    $(document).on('click', '.cancelar_modificar_factura_lista_libro_ventas', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
        
        fila_tabla.find('.habilitar_modificar_factura_lista_libro_ventas').show();
        fila_tabla.find('.modificar_factura_lista_libro_ventas').hide();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_ventas').hide();

        fila_tabla.find('.dato_factura_mod')
		.attr('contenteditable', 'false')
        .css('padding','')
      
        fila_tabla.find('.dato_factura_mod').each(function() 
		{
            $(this).html($(this).attr('valor_Original'));
		}); 

    });

    $(document).on('click', '.eliminar_factura_lista_libro_ventas', (event) => {
        event.preventDefault();
        const element = $(this)[0].activeElement;
        const datosFactura = {
            lv_txt_Num_Factura : $(element).attr('num_Factura'),
            lv_txt_Num_Autorizacion : $(element).attr('num_Autorizacion'),
            lv_txt_Nit_CI_Cliente : $(element).attr('nit_CI_Cliente'),
            eliminar_factura_lista_libro_ventas : true
        }
        const url ='abm_facturas_libro_ventas.php';
        $.post(url,datosFactura, (response) => {
            var rowCount2 = $('.ListadoFacturas tr').length;
            console.log(rowCount2);
            listar_facturas();
        });
    });
});