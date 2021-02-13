$(document).ready(function() {

  listar_empresas_clientes();

  function datos_Empresa(){
    const datosEmpresasCliente = {
        lista_empresas_nit: $('#lista_empresas_nit').val(),
        lista_empresas_nombre: $('#lista_empresas_nombre').val(),
    };
    return datosEmpresasCliente;
  }
  
  $('#registrar_empresa_cliente_lista').submit(e => {
    e.preventDefault();
    const datosEmpresasCliente = datos_Empresa();
    datosEmpresasCliente.registrar_empresa_cliente = true;
    const url ='abm_empresas_cliente.php';
    $.post(url, datosEmpresasCliente, (response) => {
      console.log(response);
      listar_empresas_clientes();
    });
  });

  function listar_empresas_clientes() {
    const le_listar_empresas_clientes = true;
    $.get('abm_empresas_cliente.php', {le_listar_empresas_clientes}, (response) => {
      //console.log(response);
      let datos_Empresa = '';
      try {
        const empresa = JSON.parse(response);
        empresa.forEach(dato_Empresa => {
          datos_Empresa += `
              <tr>
                  <td><div class='dato_Empresa_mod' id ='validar_solo_numeros' cantidad_maxima_caracteres='15'>${dato_Empresa.nit_empresa}</div></td>
                  <td><div class='dato_Empresa_mod' cantidad_maxima_caracteres='50'>${dato_Empresa.nombre_empresa}</div></td>
                  <td>
                      <span class='habilitar_modificar_empresa_lista'><a href='#' nit_empresa='${dato_Empresa.nit_empresa}'><img src='../img/editar.png' class='imgABM'></a></span>
                      <span class='modificar_empresa_lista'> <a href='#' nit_empresa='${dato_Empresa.nit_empresa}'> Guardar</a></span>
                      <span class='cancelar_modificar_empresa_lista'> <a href='#' nit_empresa='${dato_Empresa.nit_empresa}'> Cancelar</a></span>
                  </td>
                  <td><a href='#' class='eliminar_empresa_lista' nit_empresa='${dato_Empresa.nit_empresa}'><img src='../img/eliminar.png' class='imgABM'></a></td>
                  <td><a href=listaLibroCompras.php?nit_empresa=${dato_Empresa.nit_empresa} class='ir_lista_libro_compras' nit_empresa='${dato_Empresa.nit_empresa}'>Lista Libro Compras</a></td>
                  <td><a href=listaLibroVentas.php?nit_empresa=${dato_Empresa.nit_empresa} class='ir_lista_libro_ventas' nit_empresa='${dato_Empresa.nit_empresa}'>Lista Libro Ventas</a></td>

              </tr>
              `;
        });
      }
      catch(e) {
          console.log('Error',response);
      }
      finally {
          $('#lista_empresa_cliente').html(datos_Empresa);
          $(document).find('.modificar_empresa_lista').hide();
          $(document).find('.cancelar_modificar_empresa_lista').hide();
      }
    });
  }

  $(document).on('click', '.habilitar_modificar_empresa_lista', function(event)  {
    event.preventDefault();
    var fila_tabla = $(this).closest('tr');

    fila_tabla.find('.habilitar_modificar_empresa_lista').hide();
    fila_tabla.find('.modificar_empresa_lista').show();
    fila_tabla.find('.cancelar_modificar_empresa_lista').show();

    fila_tabla.find('.dato_Empresa_mod')
    .attr('contenteditable', 'true')
    .css('padding','3px')		
            
    fila_tabla.find('.dato_Empresa_mod').each(function() 
    {  
        $(this).attr('valor_Original', $(this).html());
    }); 
  });

  $(document).on('click', '.modificar_empresa_lista', function(event)  {
    event.preventDefault();
    var fila_tabla = $(this).closest('tr');

    var btn = $(this).find('a');

    fila_tabla.find('.habilitar_modificar_empresa_lista').show();
    fila_tabla.find('.modificar_empresa_lista').hide();
    fila_tabla.find('.cancelar_modificar_empresa_lista').hide();

    fila_tabla.find('.dato_Empresa_mod')
    .attr('contenteditable', 'false')
    .removeAttr('valor_Original')
    .css('padding','')

    const datos_Empresas_A_Modificar = {
      lista_empresas_nit:         fila_tabla.find('.dato_Empresa_mod').eq(0).text(),
      lista_empresas_nombre:      fila_tabla.find('.dato_Empresa_mod').eq(1).text(),
      lista_empresas_nit_actual:  btn.attr('nit_empresa'),
      modificar_empresa_lista:    true,
    };

      const url ='abm_empresas_cliente.php';
      $.post(url, datos_Empresas_A_Modificar, (response) => {
          console.log(response);
          listar_empresas_clientes();
      });
  });

  $(document).on('click', '.cancelar_modificar_empresa_lista', function(event)  {
    event.preventDefault();
    var fila_tabla = $(this).closest('tr');
    fila_tabla.find('.habilitar_modificar_empresa_lista').show();
    fila_tabla.find('.modificar_empresa_lista').hide();
    fila_tabla.find('.cancelar_modificar_empresa_lista').hide();

    fila_tabla.find('.dato_Empresa_mod')
    .attr('contenteditable', 'false')
    .css('padding','')
    
    fila_tabla.find('.dato_Empresa_mod').each(function() 
    {
      $(this).html($(this).attr('valor_Original'));
    }); 
  });
  
  $(document).on('click', '.eliminar_empresa_lista', (event) => {
    event.preventDefault();

    const element = $(this)[0].activeElement;
    const datosEmpresa = {
        lista_empresas_nit :      $(element).attr('nit_empresa'),
        eliminar_empresa_lista :   true
    }

    const url ='abm_empresas_cliente.php';
    $.post(url,datosEmpresa, (response) => {
        console.log(response);
        listar_empresas_clientes();
    });
  });
});