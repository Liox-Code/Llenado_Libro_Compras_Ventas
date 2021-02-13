$(document).ready(function() {

    listar_Libros_Compras();

    $('#registrar_libro_compras').submit(e => {
        e.preventDefault();
        
        const datosLibroCompras = {
            libro_compras_nombre:     $('#nombre_libro_compras').val(),
            crear_libro_compras :     true
        };

        const url ='abm_libro_compras.php';
        $.post(url, datosLibroCompras, (response) => {
            console.log('registrar_libro_compras'+response);
            listar_Libros_Compras();
        });
    });
    
    function listar_Libros_Compras() {
        const listar_Libro_Compras = true;
        var $cod_Libro_Compra_Seleccionado = 0;
        if($(document).find('#btn_lista_factura_compras').length>0);{
            $cod_Libro_Compra_Seleccionado = $(document).find('#btn_lista_factura_compras').attr('btn_lista_factura_compras');
        }
        $.get('abm_libro_compras.php', {listar_Libro_Compras}, (response) => {
            //console.log(response);
            let datos_Libro_Compras = '';
            try {
                const libro_compras = JSON.parse(response);
                libro_compras.forEach(dato_Libro_Compras => {
                    datos_Libro_Compras += `
                        <tr>
                            <td><div class='dato_Libro_Compras_mod'>${dato_Libro_Compras.nombre}</div></td>
                            <td><div>${dato_Libro_Compras.fecha_creacion}</div></td>
                            <td>
                                <span class='habilitar_modificar_Libro_Compras'><a href='#' cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'><img src='../img/editar.png' class='imgABM'></a></span>
                                <span class='modificar_Libro_Compras'><a href='#' cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'> Guardar</a></span>
                                <span class='cancelar_modificar_Libro_Compras'><a href='#' cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'> Cancelar</a></span>
                            </td>
                            <td><a href='#' class='eliminar_Libro_Compras' cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'><img src='../img/eliminar.png' class='imgABM'></a></td>`;
                            
                            if ($cod_Libro_Compra_Seleccionado == dato_Libro_Compras.cod_libro_compras) {
                                datos_Libro_Compras += `<td><a href=listaFacturasLibroCompras.php?cod_libro_compras=${dato_Libro_Compras.cod_libro_compras} cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'><img src='../img/checked.png' class='imgABM'></a></td>`;
                            }
                            else{
                                datos_Libro_Compras += `<td><a href=listaFacturasLibroCompras.php?cod_libro_compras=${dato_Libro_Compras.cod_libro_compras} cod_libro_compras='${dato_Libro_Compras.cod_libro_compras}'><img src='../img/empty.png' class='imgABM'></a></td>`;
                            }
                            
                        datos_Libro_Compras += `</tr>`;
                });
            }
            catch(e) {
                console.log('Error listar_Libros_Compras');
            }
            finally {
                $('#lista_libro_compras').html(datos_Libro_Compras);
                $(document).find('.modificar_Libro_Compras').hide();
                $(document).find('.cancelar_modificar_Libro_Compras').hide(); 
            }
        });
    }

    $(document).on('click', '.habilitar_modificar_Libro_Compras', function(event)  {
      event.preventDefault();
      var fila_tabla = $(this).closest('tr');
  
      fila_tabla.find('.habilitar_modificar_Libro_Compras').hide();
      fila_tabla.find('.modificar_Libro_Compras').show();
      fila_tabla.find('.cancelar_modificar_Libro_Compras').show();
  
      fila_tabla.find('.dato_Libro_Compras_mod')
      .attr('contenteditable', 'true')
      .css('padding','3px')		
              
      fila_tabla.find('.dato_Libro_Compras_mod').each(function() 
      {  
          $(this).attr('valor_Original', $(this).html());
      }); 
    });
  
    $(document).on('click', '.modificar_Libro_Compras', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
    
        var btn = $(this).find('a');
    
        fila_tabla.find('.habilitar_modificar_Libro_Compras').show();
        fila_tabla.find('.modificar_Libro_Compras').hide();
        fila_tabla.find('.cancelar_modificar_Libro_Compras').hide();
    
        fila_tabla.find('.dato_Libro_Compras_mod')
        .attr('contenteditable', 'false')
        .removeAttr('valor_Original')
        .css('padding','')
    
        const datos_Libro_Compras_A_Modificar = {
            libro_compras_nombre:           fila_tabla.find('.dato_Libro_Compras_mod').eq(0).text(),
            libro_compras_codigo:           btn.attr('cod_libro_compras'),
            modificar_Libro_Compras:        true,
        };
        console.log(btn);
        console.log(datos_Libro_Compras_A_Modificar);
        const url ='abm_libro_compras.php';
        $.post(url, datos_Libro_Compras_A_Modificar, (response) => {
            console.log(response);
            listar_Libros_Compras();
        });
    });
  
    $(document).on('click', '.cancelar_modificar_Libro_Compras', function(event)  {
      event.preventDefault();
      var fila_tabla = $(this).closest('tr');
      fila_tabla.find('.habilitar_modificar_Libro_Compras').show();
      fila_tabla.find('.modificar_Libro_Compras').hide();
      fila_tabla.find('.cancelar_modificar_Libro_Compras').hide();
  
      fila_tabla.find('.dato_Libro_Compras_mod')
      .attr('contenteditable', 'false')
      .css('padding','')
      
      fila_tabla.find('.dato_Libro_Compras_mod').each(function() 
      {
        $(this).html($(this).attr('valor_Original'));
      }); 
    });
    
    $(document).on('click', '.eliminar_Libro_Compras', (event) => {
      event.preventDefault();
  
      const element = $(this)[0].activeElement;
      const datosEmpresa = {
          libro_compras_codigo :    $(element).attr('cod_libro_compras'),
          eliminar_Libro_Compras :  true,
      }
  
      const url ='abm_libro_compras.php';
      $.post(url,datosEmpresa, (response) => {
          console.log(response);
          listar_Libros_Compras();
      });
    });
});