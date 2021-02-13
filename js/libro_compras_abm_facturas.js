$(document).ready(function() {
    listar_facturas();

    function listar_facturas() {
        const lc_listar_facturas_registradas = true;
        $.get('abm_facturas_libro_compras.php', {lc_listar_facturas_registradas}, (response) => {
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                datos_factura += insertar_filas(factura);
            }
            catch(e) {
                console.log(response);
            }
            finally {
                $('#lista_facturas_libro_compras').html(datos_factura);
                $(document).find('.modificar_factura_lista_libro_compras').hide();
                $(document).find('.cancelar_modificar_factura_lista_libro_compras').hide(); 
            }
        });
        actualizar_Libro();
        mostrar_libro_compras();
    }

    function actualizar_Libro(){
        const lc_modificar_libro_compras = true;
        $.get('abm_libro_compras.php', {lc_modificar_libro_compras}, (response) => {
            console.log(response);
        });
    }

    function mostrar_libro_compras() {
        const lc_mostrar_datos_libro_compras = true;
        var tabla = $('.lblInformacion');
        $.get('abm_libro_compras.php', {lc_mostrar_datos_libro_compras}, (response) => {
            try {
                const libro_compra = JSON.parse(response);
                libro_compra.forEach(dato_libro_compra => {
                    tabla.find('.divInformacionDatos').eq(0).text(dato_libro_compra.nombre);
                    tabla.find('.divInformacionDatos').eq(1).text(dato_libro_compra.fecha_creacion);
                    tabla.find('.divInformacionDatos').eq(2).text(dato_libro_compra.importe_total_compra);
                    tabla.find('.divInformacionDatos').eq(4).text(dato_libro_compra.importe_no_sujeto_credito_fiscal);
                    tabla.find('.divInformacionDatos').eq(6).text(dato_libro_compra.subtotal);
                    tabla.find('.divInformacionDatos').eq(3).text(dato_libro_compra.descuentos_bonificaciones_y_rebajas_sujetas_IVA);
                    tabla.find('.divInformacionDatos').eq(5).text(dato_libro_compra.importe_base_credito_fiscal);
                    tabla.find('.divInformacionDatos').eq(7).text(dato_libro_compra.credito_fiscal);
                });
            }
            catch(e) {
                console.log('Error lc_mostrar_datos_libro_compras');
            }
        });
        const lc_mostrar_cantidad_facturas = true;
        $.get('abm_libro_compras.php', {lc_mostrar_cantidad_facturas}, (response) => {
            tabla.find('.divInformacionDatos').eq(8).text(response);
        });
    }

    function datos_libro_compras(){
        const datosFactura = {
            lc_txt_fecha_factura_o_DUI: $('#lc_txt_fecha_factura_o_DUI').val(),
            lc_txt_nit_proveedor: $('#lc_txt_nit_proveedor').val(),
            lc_txt_nombre_o_razon_social: $('#lc_txt_nombre_o_razon_social').val(),
            lc_txt_num_factura: $('#lc_txt_num_factura').val(),
            lc_txt_num_DUI: $('#lc_txt_num_DUI').val(),
            lc_txt_num_autorisacion: $('#lc_txt_num_autorisacion').val(),
            lc_txt_importe_total_compra: $('#lc_txt_importe_total_compra').val(),
            lc_txt_importe_no_sujeto_credito_fiscal: $('#lc_txt_importe_no_sujeto_credito_fiscal').val(),
            lc_txt_subtotal: $('#lc_txt_subtotal').val(),
            lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA: $('#lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA').val(),
            lc_txt_importe_base_credito_fiscal: $('#lc_txt_importe_base_credito_fiscal').val(),
            lc_txt_credito_fiscal: $('#lc_txt_credito_fiscal').val(),
            lc_txt_codigo_control: $('#lc_txt_codigo_control').val(),
            lc_txt_tipo_compra: $('#lc_txt_tipo_compra').val(),
        };
        return datosFactura;
    }

    function operaciones_automatizadas(importe_total_compra,importe_no_sujeto_credito_fiscal,descuentos_bonificaciones_y_rebajas_sujetas_IVA,subtotal){
        if(isNaN(importe_total_compra)){
            importe_total_compra = 0;
        }
        if(isNaN(importe_no_sujeto_credito_fiscal)){
            importe_no_sujeto_credito_fiscal = 0; 
        }
        if(isNaN(descuentos_bonificaciones_y_rebajas_sujetas_IVA)){
            descuentos_bonificaciones_y_rebajas_sujetas_IVA = 0;
        }
        subtotal = (importe_total_compra - importe_no_sujeto_credito_fiscal).toFixed(2);
        $('#lc_txt_subtotal').val(subtotal);
        importe_base_credito_fiscal = (subtotal - descuentos_bonificaciones_y_rebajas_sujetas_IVA).toFixed(2);
        $('#lc_txt_importe_base_credito_fiscal').val(importe_base_credito_fiscal);
        credito_fiscal = (importe_base_credito_fiscal * 0.13).toFixed(2);
        $('#lc_txt_credito_fiscal').val(credito_fiscal);
    }
    
    function insertar_filas(json_datos_factura){
        let datos_factura = '';
        json_datos_factura.forEach(dato_factura => {
            datos_factura += `
                <tr>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='10'>${dato_factura.fecha_factura_o_DUI}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='13'>${dato_factura.nit_proveedor}</div></td>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='150'>${dato_factura.nombre_o_razon_social}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='15'>${dato_factura.num_factura}</div></td>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='16'>${dato_factura.num_DUI}</div></td>
                    <td><div class='dato_factura_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='15'>${dato_factura.num_autorisacion}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_total_compra}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_no_sujeto_credito_fiscal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.subtotal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.descuentos_bonificaciones_y_rebajas_sujetas_IVA}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.importe_base_credito_fiscal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_solo_decimales' cantidad_maxima_caracteres='13'>${dato_factura.credito_fiscal}</div></td>
                    <td><div class='dato_factura_mod' id = 'validar_guiones_obligatorios' cantidad_maxima_caracteres='17'>${dato_factura.codigo_control}</div></td>
                    <td><div class='dato_factura_mod' cantidad_maxima_caracteres='1'>${dato_factura.tipo_compra}</div></td>
                    <td>
                        <span class='habilitar_modificar_factura_lista_libro_compras'><a href='#' nit_proveedor='${dato_factura.nit_proveedor}' num_factura='${dato_factura.num_factura}' num_autorisacion='${dato_factura.num_autorisacion}'><img src='../img/editar.png' class='imgABM'></a></span>
                        <span class='modificar_factura_lista_libro_compras'> <a href='#' nit_proveedor='${dato_factura.nit_proveedor}' num_factura='${dato_factura.num_factura}' num_autorisacion='${dato_factura.num_autorisacion}'> Guardar</a></span>
                        <span class='cancelar_modificar_factura_lista_libro_compras'> <a href='#' nit_proveedor='${dato_factura.nit_proveedor}' num_factura='${dato_factura.num_factura}' num_autorisacion='${dato_factura.num_autorisacion}'> Cancelar</a></span>
                    </td>
                    <td><a href='#' class='eliminar_factura_lista_libro_compras' nit_proveedor='${dato_factura.nit_proveedor}' num_factura='${dato_factura.num_factura}' num_autorisacion='${dato_factura.num_autorisacion}'><img src='../img/eliminar.png' class='imgABM'></a></td>
                </tr>
                `;
        });
        return datos_factura;
    }

    $('#lc_txt_importe_total_compra, #lc_txt_importe_no_sujeto_credito_fiscal, #lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA').keyup(e => {
        importe_total_compra = parseFloat($('#lc_txt_importe_total_compra').val());
        importe_no_sujeto_credito_fiscal = parseFloat($('#lc_txt_importe_no_sujeto_credito_fiscal').val());
        descuentos_bonificaciones_y_rebajas_sujetas_IVA = parseFloat($('#lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA').val());
        operaciones_automatizadas(
            importe_total_compra
            ,importe_no_sujeto_credito_fiscal
            ,descuentos_bonificaciones_y_rebajas_sujetas_IVA
        );
    });

    $(document).on('click', '.btn_Ordenar', function(event)  {
        nombre_columna_ordenar = $(this).attr('name');
        const ordenar = {
            ordenar_factura_lista_libro_compras:    true,
        };
        switch (nombre_columna_ordenar) {
            case "fecha_factura_o_DUI":
                ordenar.columna_Ordenar = "fecha_factura_o_DUI";
                break;
            case "nit_proveedor":
                ordenar.columna_Ordenar = "nit_proveedor";
                break;
            case "nombre_o_razon_social":
                ordenar.columna_Ordenar = "nombre_o_razon_social";
                break;
            case "num_factura":
                ordenar.columna_Ordenar = "num_factura";
                break;   
            case "num_DUI":
                ordenar.columna_Ordenar = "num_DUI";
                break;
            case "num_autorisacion":
                ordenar.columna_Ordenar = "num_autorisacion";
                break;
            case "codigo_control":
                ordenar.columna_Ordenar = "codigo_control";
                break;
            case "tipo_compra":
                ordenar.columna_Ordenar = "tipo_compra";
                break;
        }
        const url ='abm_facturas_libro_compras.php';
        $.get(url, ordenar, (response) => {
            console.log(response);
            let datos_factura = '';
          try {
            const factura = JSON.parse(response);
            datos_factura += insertar_filas(factura);
          }
          catch(e) {
                console.log("Error ordenar");
          }
          finally {
                $('#lista_facturas_libro_compras').html(datos_factura);
                $(document).find('.modificar_factura_lista_libro_compras').hide();
                $(document).find('.cancelar_modificar_factura_lista_libro_compras').hide();
          }
        });
    });

    $('.buscador_facturas').keyup(e => {
        const buscarFactura = {
            buscar_factura_texto: $('.buscador_facturas').val(),
            buscar_factura_lista_libro_compras: true,
        };
        url = "abm_facturas_libro_compras.php";
        $.get(url, buscarFactura, (response) => {
            console.log(response);
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                datos_factura += insertar_filas(factura);
            }
            catch(e) {
                    console.log("Error ordenar");
            }
            finally {
                    $('#lista_facturas_libro_compras').html(datos_factura);
                    $(document).find('.modificar_factura_lista_libro_compras').hide();
                    $(document).find('.cancelar_modificar_factura_lista_libro_compras').hide();
            }
        });
    });

    $('#registrar_factura_lista_libro_compras').submit(e => {
        e.preventDefault();
        const datosFactura = datos_libro_compras();
        datosFactura.registrar_factura_lista_libro_compras = true;
        const url ='abm_facturas_libro_compras.php';
        $.post(url, datosFactura, (response) => {
            listar_facturas();
        });
    });

    $(document).on('keyup', '.dato_factura_mod', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
        importe_total_compra = parseFloat(fila_tabla.find('.dato_factura_mod').eq(6).text());
        importe_no_sujeto_credito_fiscal = parseFloat(fila_tabla.find('.dato_factura_mod').eq(7).text());
        descuentos_bonificaciones_y_rebajas_sujetas_IVA = parseFloat(fila_tabla.find('.dato_factura_mod').eq(9).text());
        if(isNaN(importe_total_compra)){
            importe_total_compra = 0;
        }
        if(isNaN(importe_no_sujeto_credito_fiscal)){
            importe_no_sujeto_credito_fiscal = 0; 
        }
        if(isNaN(descuentos_bonificaciones_y_rebajas_sujetas_IVA)){
            descuentos_bonificaciones_y_rebajas_sujetas_IVA = 0;
        }

        subtotal = (importe_total_compra - importe_no_sujeto_credito_fiscal).toFixed(2);
        importe_base_credito_fiscal = (subtotal - descuentos_bonificaciones_y_rebajas_sujetas_IVA).toFixed(2);
        credito_fiscal = (importe_base_credito_fiscal * 0.13).toFixed(2);

        fila_tabla.find('.dato_factura_mod').eq(8).text((subtotal).toFixed(2));
        fila_tabla.find('.dato_factura_mod').eq(10).text((importe_base_credito_fiscal).toFixed(2));
        fila_tabla.find('.dato_factura_mod').eq(11).text((credito_fiscal).toFixed(2));
    });

    $(document).on('click', '.habilitar_modificar_factura_lista_libro_compras', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');

        fila_tabla.find('.habilitar_modificar_factura_lista_libro_compras').hide();
        fila_tabla.find('.modificar_factura_lista_libro_compras').show();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_compras').show();

        fila_tabla.find('.dato_factura_mod')
        .attr('contenteditable', 'true')
        .css('padding','3px')		
                
        fila_tabla.find('.dato_factura_mod').each(function() 
        {  
            $(this).attr('valor_Original', $(this).html());
        });
        fila_tabla.find('.dato_factura_mod').eq(8).attr('contenteditable', 'false');
        fila_tabla.find('.dato_factura_mod').eq(10).attr('contenteditable', 'false');
        fila_tabla.find('.dato_factura_mod').eq(11).attr('contenteditable', 'false');
    });

    $(document).on('click', '.modificar_factura_lista_libro_compras', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');

        var btn = $(this).find('a');

		fila_tabla.find('.habilitar_modificar_factura_lista_libro_compras').show();
        fila_tabla.find('.modificar_factura_lista_libro_compras').hide();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_compras').hide();

		fila_tabla.find('.dato_factura_mod')
		.attr('contenteditable', 'false')
		.removeAttr('valor_Original')
        .css('padding','')

        const datos_Factura_A_Modificar = {
            lc_txt_fecha_factura_o_DUI:                             fila_tabla.find('.dato_factura_mod').eq(0).text(),
            lc_txt_nit_proveedor:                                   fila_tabla.find('.dato_factura_mod').eq(1).text(),
            lc_txt_nombre_o_razon_social:                           fila_tabla.find('.dato_factura_mod').eq(2).text(),
            lc_txt_num_factura:                                     fila_tabla.find('.dato_factura_mod').eq(3).text(),
            lc_txt_num_DUI:                                         fila_tabla.find('.dato_factura_mod').eq(4).text(),
            lc_txt_num_autorisacion:                                fila_tabla.find('.dato_factura_mod').eq(5).text(),
            lc_txt_importe_total_compra:                            fila_tabla.find('.dato_factura_mod').eq(6).text(),
            lc_txt_importe_no_sujeto_credito_fiscal:                fila_tabla.find('.dato_factura_mod').eq(7).text(),
            lc_txt_subtotal:                                        fila_tabla.find('.dato_factura_mod').eq(8).text(),
            lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA: fila_tabla.find('.dato_factura_mod').eq(9).text(),
            lc_txt_importe_base_credito_fiscal:                     fila_tabla.find('.dato_factura_mod').eq(10).text(),
            lc_txt_credito_fiscal:                                  fila_tabla.find('.dato_factura_mod').eq(11).text(),
            lc_txt_codigo_control:                                  fila_tabla.find('.dato_factura_mod').eq(12).text(),
            lc_txt_tipo_compra:                                     fila_tabla.find('.dato_factura_mod').eq(13).text(),
            lc_txt_nit_proveedor_actual:                            btn.attr('nit_proveedor'),
            lc_txt_num_factura_actual:                              btn.attr('num_factura'),
            lc_txt_num_autorisacion_actual:                         btn.attr('num_autorisacion'),
            modificar_factura_lista_libro_compras:                  true,
        };
        const url ='abm_facturas_libro_compras.php';
        $.post(url, datos_Factura_A_Modificar, (response) => {
            console.log(response);
            actualizar_Libro();
            mostrar_libro_compras();
        });
    });

    $(document).on('click', '.cancelar_modificar_factura_lista_libro_compras', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
        fila_tabla.find('.habilitar_modificar_factura_lista_libro_compras').show();
        fila_tabla.find('.modificar_factura_lista_libro_compras').hide();
        fila_tabla.find('.cancelar_modificar_factura_lista_libro_compras').hide();

        fila_tabla.find('.dato_factura_mod')
		.attr('contenteditable', 'false')
        .css('padding','')
      
        fila_tabla.find('.dato_factura_mod').each(function() 
		{
            $(this).html($(this).attr('valor_Original'));
		}); 

    });

    $(document).on('click', '.eliminar_factura_lista_libro_compras', (event) => {
        event.preventDefault();

        const element = $(this)[0].activeElement;
        const datosFactura = {
            lc_txt_nit_proveedor : $(element).attr('nit_proveedor'),
            lc_txt_num_factura : $(element).attr('num_factura'),
            lc_txt_num_autorisacion : $(element).attr('num_autorisacion'),
            eliminar_factura_lista_libro_compras : true
        }

        const url ='abm_facturas_libro_compras.php';
        $.post(url,datosFactura, (response) => {
            console.log(response);
            listar_facturas();
        });
    });
});