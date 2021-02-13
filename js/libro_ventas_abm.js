$(document).ready(function() {

    listar_Libros_Ventas();

    $('#registrar_libro_ventas').submit(e => {
        e.preventDefault();
        
        const datosLibroVentas = {
            libro_ventas_nombre:    $('#nombre_libro_ventas').val(),
            crear_libro_ventas :    true,
        };

        const url ='abm_libro_ventas.php';
        $.post(url, datosLibroVentas, (response) => {
            console.log(response);
            listar_Libros_Ventas();
        });
    });

    function listar_Libros_Ventas() {
        const listar_Libro_Ventas = true;
        var $cod_Libro_Venta_Seleccionado = 0;
        if($(document).find('#btn_lista_factura_ventas').length > 0){
            $cod_Libro_Venta_Seleccionado = $(document).find('#btn_lista_factura_ventas').attr('btn_lista_factura_ventas');
        }
        $.get('abm_libro_ventas.php', {listar_Libro_Ventas}, (response) => {
            let datos_Libro_Ventas = '';
            try {
                const libro_ventas = JSON.parse(response);
                libro_ventas.forEach(dato_Libro_Ventas => {
                    datos_Libro_Ventas += `
                        <tr>
                            <td><div class='dato_Libro_Ventas_mod'>${dato_Libro_Ventas.nombre}</div></td>
                            <td><div>${dato_Libro_Ventas.fecha_creacion}</div></td>
                            <td>
                                <span class='habilitar_modificar_Libro_Ventas'><a href='#' cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'><img src='../img/editar.png' class='imgABM'></a></span>
                                <span class='modificar_Libro_Ventas'><a href='#' cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'> Guardar</a></span>
                                <span class='cancelar_modificar_Libro_Ventas'><a href='#' cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'> Cancelar</a></span>
                            </td>
                            <td><a href='#' class='eliminar_Libro_Ventas' cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'><img src='../img/eliminar.png' class='imgABM'></a></td>`;
                        
                        if ($cod_Libro_Venta_Seleccionado == dato_Libro_Ventas.cod_libro_ventas) {
                            datos_Libro_Ventas += `<td><a href=listaFacturasLibroVentas.php?cod_libro_ventas=${dato_Libro_Ventas.cod_libro_ventas} cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'><img src='../img/checked.png' class='imgABM'></a></td>`;
                        }
                        else{
                            datos_Libro_Ventas += `<td><a href=listaFacturasLibroVentas.php?cod_libro_ventas=${dato_Libro_Ventas.cod_libro_ventas} cod_libro_ventas='${dato_Libro_Ventas.cod_libro_ventas}'><img src='../img/empty.png' class='imgABM'></a></td>`;
                        }
                    datos_Libro_Ventas += `</tr>`;
                });
            }
            catch(e) {
                console.log('Error listar_Libros_Ventas');
            }
            finally {
                $('#lista_libro_ventas').html(datos_Libro_Ventas);
                $(document).find('.modificar_Libro_Ventas').hide();
                $(document).find('.cancelar_modificar_Libro_Ventas').hide(); 
            }
        });
    }

    $(document).on('click', '.habilitar_modificar_Libro_Ventas', function(event)  {
      event.preventDefault();
      var fila_tabla = $(this).closest('tr');
  
      fila_tabla.find('.habilitar_modificar_Libro_Ventas').hide();
      fila_tabla.find('.modificar_Libro_Ventas').show();
      fila_tabla.find('.cancelar_modificar_Libro_Ventas').show();
  
      fila_tabla.find('.dato_Libro_Ventas_mod')
      .attr('contenteditable', 'true')
      .css('padding','3px')		
              
      fila_tabla.find('.dato_Libro_Ventas_mod').each(function() 
      {  
          $(this).attr('valor_Original', $(this).html());
      }); 
    });
  
    $(document).on('click', '.modificar_Libro_Ventas', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
    
        var btn = $(this).find('a');
    
        fila_tabla.find('.habilitar_modificar_Libro_Ventas').show();
        fila_tabla.find('.modificar_Libro_Ventas').hide();
        fila_tabla.find('.cancelar_modificar_Libro_Ventas').hide();
    
        fila_tabla.find('.dato_Libro_Ventas_mod')
        .attr('contenteditable', 'false')
        .removeAttr('valor_Original')
        .css('padding','')
    
        const datos_Libro_Ventas_A_Modificar = {
            libro_ventas_nombre:           fila_tabla.find('.dato_Libro_Ventas_mod').eq(0).text(),
            libro_ventas_codigo:           btn.attr('cod_libro_ventas'),
            modificar_Libro_Ventas:        true,
        };
        const url ='abm_libro_ventas.php';
        $.post(url, datos_Libro_Ventas_A_Modificar, (response) => {
            console.log(response);
        });
    });
  
    $(document).on('click', '.cancelar_modificar_Libro_Ventas', function(event)  {
      event.preventDefault();
      var fila_tabla = $(this).closest('tr');
      fila_tabla.find('.habilitar_modificar_Libro_Ventas').show();
      fila_tabla.find('.modificar_Libro_Ventas').hide();
      fila_tabla.find('.cancelar_modificar_Libro_Ventas').hide();
  
      fila_tabla.find('.dato_Libro_Ventas_mod')
      .attr('contenteditable', 'false')
      .css('padding','')
      
      fila_tabla.find('.dato_Libro_Ventas_mod').each(function() 
      {
        $(this).html($(this).attr('valor_Original'));
      }); 
    });

    $(document).on('click', '.eliminar_Libro_Ventas', (event) => {
      event.preventDefault();
  
      const element = $(this)[0].activeElement;
      const datosEmpresa = {
        libro_ventas_codigo :    $(element).attr('cod_libro_ventas'),
        eliminar_Libro_Ventas :  true,
      }
  
      const url ='abm_libro_ventas.php';
      $.post(url,datosEmpresa, (response) => {
          listar_Libros_Ventas();
      });
    });
});