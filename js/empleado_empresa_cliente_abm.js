$(document).ready(function(){

    dr_bx_Empresas();
    listar_empleados_empresas_clientes();

    function datos_Empleado_Empresa_Cliente(){
        const datosEmpleadoEmpresasCliente = {
            usu_emp_Ci: $('#usu_emp_Ci').val(),
            usu_emp_Nombre: $('#usu_emp_Nombre').val(),
            usu_emp_Apellido: $('#usu_emp_Apellido').val(),
            usu_emp_NombreUsuario: $('#usu_emp_NombreUsuario').val(),
            usu_emp_Contraseña: $('#usu_emp_Contraseña').val(),
            usu_emp_Nit_Empresa:$( "#usu_emp_drbx_lista_empresas option:selected" ).val(),
            usu_emp_Cod_Libro_Compras:$( "#usu_emp_drbx_lista_libro_compras option:selected" ).val(),
            usu_emp_Cod_Libro_Ventas:$( "#usu_emp_drbx_lista_libro_ventas option:selected" ).val(),
        };
        return datosEmpleadoEmpresasCliente;
      }

    $('#registrar_empleado_empresa_cliente_lista').submit(e => {
        e.preventDefault();
        const datosEmpleadoEmpresaCliente = datos_Empleado_Empresa_Cliente();
        datosEmpleadoEmpresaCliente.registrar_empleado_empresa_cliente = true;
        const url ='abm_usuarios_empleado_empresa.php';
        $.post(url, datosEmpleadoEmpresaCliente, (response) => {
            console.log(response);
            //$('#registrar_factura_lista_libro_compras').trigger('reset');
            listar_empleados_empresas_clientes();
        });
    });

    $(document).on('click', '.habilitar_modificar_empleado_lista', function(event)  {
        event.preventDefault();

        var fila_tabla = $(this).closest('tr');

        var nit_empresa = $(fila_tabla).find('.drbx_lista_empresas option:selected').text();
        var valor_lc = $(fila_tabla).find('.drbx_lista_libro_compras option:selected').text();
        var valor_lv = $(fila_tabla).find('.drbx_lista_libro_ventas option:selected').text();

        fila_tabla.find('.habilitar_modificar_empleado_lista').hide();
        fila_tabla.find('.modificar_empleado_lista').show();
        fila_tabla.find('.cancelar_modificar_empleado_lista').show();

        fila_tabla.find('.dato_Empleado_mod')
        .attr('contenteditable', 'true')
        .css('padding','3px')
        $(fila_tabla).find('.drbx_lista_empresas').prop('disabled',false);
        $(fila_tabla).find('.drbx_lista_libro_compras').prop('disabled',false);
        $(fila_tabla).find('.drbx_lista_libro_ventas').prop('disabled',false);

        $(fila_tabla).find('.drbx_lista_empresas').attr('valor_Original',nit_empresa);
        $(fila_tabla).find('.drbx_lista_libro_compras').attr('valor_Original',valor_lc);
        $(fila_tabla).find('.drbx_lista_libro_ventas').attr('valor_Original',valor_lv);

        fila_tabla.find('.dato_Empleado_mod').each(function() 
        {  
            $(this).attr('valor_Original', $(this).html());
        }); 
    });
  
    $(document).on('click', '.modificar_empleado_lista', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');

        var btn = $(this).find('a');

        fila_tabla.find('.habilitar_modificar_empleado_lista').show();
        fila_tabla.find('.modificar_empleado_lista').hide();
        fila_tabla.find('.cancelar_modificar_empleado_lista').hide();

        fila_tabla.find('.dato_Empleado_mod')
        .attr('contenteditable', 'false')
        .removeAttr('valor_Original')
        .css('padding','')

        const datos_Empresas_A_Modificar = {
            usu_emp_Ci:                     fila_tabla.find('.dato_Empleado_mod').eq(0).text(),
            usu_emp_Nombre:                 fila_tabla.find('.dato_Empleado_mod').eq(1).text(),
            usu_emp_Apellido:               fila_tabla.find('.dato_Empleado_mod').eq(2).text(),
            usu_emp_NombreUsuario:          fila_tabla.find('.dato_Empleado_mod').eq(3).text(),
            usu_emp_Contraseña:             fila_tabla.find('.dato_Empleado_mod').eq(4).text(),
            usu_emp_Nit_Empresa:            fila_tabla.find('.drbx_lista_empresas option:selected').val(),
            usu_emp_Cod_Libro_Compras:      fila_tabla.find('.drbx_lista_libro_compras option:selected').val(),
            usu_emp_Cod_Libro_Ventas:       fila_tabla.find('.drbx_lista_libro_ventas option:selected').val(),
            usu_emp_Nombre_Empresa:         fila_tabla.find('.drbx_lista_empresas option:selected').text(),
            usu_emp_Nombre_Libro_Compras:   fila_tabla.find('.drbx_lista_libro_compras option:selected').text(),
            usu_emp_Nombre_Libro_Ventas:    fila_tabla.find('.drbx_lista_libro_ventas option:selected').text(),
            usu_emp_Ci_actual:              btn.attr('CI_usuario_emp'),
            modificar_empleado_lista:       true,
        };

        const url ='abm_usuarios_empleado_empresa.php';
        $.post(url, datos_Empresas_A_Modificar, (response) => {
            console.log(response);
        });
    });
  
    $(document).on('click', '.cancelar_modificar_empleado_lista', function(event)  {
        event.preventDefault();
        var fila_tabla = $(this).closest('tr');
        fila_tabla.find('.habilitar_modificar_empleado_lista').show();
        fila_tabla.find('.modificar_empleado_lista').hide();
        fila_tabla.find('.cancelar_modificar_empleado_lista').hide();
        
        var nit_empresa = $(fila_tabla).find('.drbx_lista_empresas').attr('valor_Original');
        var valor_lc = $(fila_tabla).find('.drbx_lista_libro_compras').attr('valor_Original');
        var valor_lv = $(fila_tabla).find('.drbx_lista_libro_ventas').attr('valor_Original');

        fila_tabla.find('.dato_Empleado_mod')
        .attr('contenteditable', 'false')
        .css('padding','')
        $(fila_tabla).find('.drbx_lista_empresas').prop('disabled',true);
        $(fila_tabla).find('.drbx_lista_libro_compras').prop('disabled',true);
        $(fila_tabla).find('.drbx_lista_libro_ventas').prop('disabled',true);
        
        $(fila_tabla).find('.drbx_lista_empresas option:selected').html(nit_empresa);
        $(fila_tabla).find('.drbx_lista_libro_compras option:selected').html(valor_lc);
        $(fila_tabla).find('.drbx_lista_libro_ventas option:selected').html(valor_lv);
        
        fila_tabla.find('.dato_Empleado_mod').each(function() 
        {
            $(this).html($(this).attr('valor_Original'));
        }); 
    });

    $(document).on('click', '.eliminar_empleado_lista', (event) => {
        event.preventDefault();

        const element = $(this)[0].activeElement;
        const datosEmpleado = {
            usu_emp_Ci :      $(element).attr('CI_usuario_emp'),
            eliminar_empleado_lista :   true
        }

        const url ='abm_usuarios_empleado_empresa.php';
        $.post(url,datosEmpleado, (response) => {
            console.log(response);
            listar_empleados_empresas_clientes();
        });
    });

    function dr_bx_Empresas() {
        const dr_bx_listar_Empresas = true;
        const url ='abm_usuarios_empleado_empresa.php';
        $.get(url, {dr_bx_listar_Empresas}, (response) => {
            let lista_empresas = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const empresa = JSON.parse(response);
                empresa.forEach(datos_Empresa => {
                    lista_empresas += `
                        <option value="${datos_Empresa.nit_empresa}">${datos_Empresa.nombre_empresa}</option>
                        `;
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                $('.drbx_lista_empresas').html(lista_empresas);
            }
        });
    };

    
    function dr_bx_Empresas_Seleccionada(dropbox_seleccionado,valor_empresa_seleccionada) {
        const dr_bx_listar_Empresas = true;
        var fila_tabla = $(dropbox_seleccionado).closest('tr');
        const url ='abm_usuarios_empleado_empresa.php';
        $.get(url, {dr_bx_listar_Empresas}, (response) => {
            let lista_empresas = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const empresa = JSON.parse(response);
                empresa.forEach(datos_Empresa => {
                    if(valor_empresa_seleccionada == datos_Empresa.nit_empresa){
                        lista_empresas += `
                            <option selected value="${datos_Empresa.nit_empresa}">${datos_Empresa.nombre_empresa}</option>
                            `;
                    }
                    else{
                        lista_empresas += `
                            <option value="${datos_Empresa.nit_empresa}">${datos_Empresa.nombre_empresa}</option>
                            `;
                    }
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                fila_tabla.find('.drbx_lista_empresas').html(lista_empresas);
            }
        });
    };

    function dropbox_listar_libros(fun_obj){
        var fila_tabla = $(fun_obj).closest('tr');
        const datos_libro_compras = {
            nit_empresa :$(fun_obj).val(),
            dr_bx_listar_Libro_Compras: true,
        } 
        const datos_libro_ventas = {
            nit_empresa :$(fun_obj).val(),
            dr_bx_listar_Libros_Ventas: true,
        }

        const url ='abm_usuarios_empleado_empresa.php';
        $.get(url, datos_libro_compras, (response) => {
            let lista_libro_compras = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const libro_compras = JSON.parse(response);
                libro_compras.forEach(dato_Libro_Compra => {
                    lista_libro_compras += `
                        <option value="${dato_Libro_Compra.cod_libro_compras}">${dato_Libro_Compra.nombre}</option>
                        `;
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                fila_tabla.find('.drbx_lista_libro_compras').html(lista_libro_compras);
            }
        });
        $.get(url, datos_libro_ventas, (response) => {
            let lista_libro_ventas = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const libro_ventas = JSON.parse(response);
                libro_ventas.forEach(dato_Libro_Ventas => {
                    lista_libro_ventas += `
                        <option value="${dato_Libro_Ventas.cod_libro_ventas}">${dato_Libro_Ventas.nombre}</option>
                        `;
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                fila_tabla.find('.drbx_lista_libro_ventas').html(lista_libro_ventas);
            }
        });
    }

    function dropbox_listar_libros_Seleccionado(fun_obj){
        var fila_tabla = $(fun_obj).closest('tr');
        var nit_empresa = $(fila_tabla).find('.drbx_lista_empresas').val();
        var valor_lc = $(fila_tabla).find('.drbx_lista_libro_compras').val();
        var valor_lv = $(fila_tabla).find('.drbx_lista_libro_ventas').val();

        const datos_libro_compras = {
            nit_empresa : nit_empresa,
            dr_bx_listar_Libro_Compras: true,
        } 
        const datos_libro_ventas = {
            nit_empresa : nit_empresa,
            dr_bx_listar_Libros_Ventas: true,
        }

        const url ='abm_usuarios_empleado_empresa.php';
        $.get(url, datos_libro_compras, (response) => {
            let lista_libro_compras = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const libro_compras = JSON.parse(response);
                libro_compras.forEach(dato_Libro_Compra => {
                    if (valor_lc == dato_Libro_Compra.cod_libro_compras) {
                        lista_libro_compras += `
                            <option selected value="${dato_Libro_Compra.cod_libro_compras}">${dato_Libro_Compra.nombre}</option>
                            `;
                    }
                    else{
                        lista_libro_compras += `
                            <option value="${dato_Libro_Compra.cod_libro_compras}">${dato_Libro_Compra.nombre}</option>
                            `;
                    }
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                fila_tabla.find('.drbx_lista_libro_compras').html(lista_libro_compras);
            }
        });

        $.get(url, datos_libro_ventas, (response) => {
            let lista_libro_ventas = "<option value='No Seleccionado'>No Seleccionado</option>";
            try {
                const libro_ventas = JSON.parse(response);
                libro_ventas.forEach(dato_Libro_Ventas => {
                    if (valor_lv == dato_Libro_Ventas.cod_libro_ventas) {
                        lista_libro_ventas += `
                            <option selected value="${dato_Libro_Ventas.cod_libro_ventas}">${dato_Libro_Ventas.nombre}</option>
                            `;
                    }
                    else{
                        lista_libro_ventas += `
                            <option value="${dato_Libro_Ventas.cod_libro_ventas}">${dato_Libro_Ventas.nombre}</option>
                            `;
                    }
                });
            }
            catch(e) {
                console.log("Error dr_bx_Empresas");
            }
            finally {
                fila_tabla.find('.drbx_lista_libro_ventas').html(lista_libro_ventas);
            }
        });
    }

    $(document).on('click', '.drbx_lista_empresas', function(e){
        valor_seleccionado=$(this).val();
        dr_bx_Empresas_Seleccionada(this,valor_seleccionado)
    });

    $(document).on('click', '.drbx_lista_libro_compras', function(e){
        dropbox_listar_libros_Seleccionado(this)
    });

    $(document).on('click', '.drbx_lista_libro_ventas', function(e){
        dropbox_listar_libros_Seleccionado(this)
    });

    $( ".drbx_lista_empresas" ).change(function() {
        dropbox_listar_libros(this);
    });
    

    $(document).on('change', '.drbx_lista_empresas', function(){ 
        dropbox_listar_libros(this);
    });


    function listar_empleados_empresas_clientes() {
        const l_emp_listar_empleados_empresas_clientes = true;
        $.get('abm_usuarios_empleado_empresa.php', {l_emp_listar_empleados_empresas_clientes}, (response) => {
            let datos_Empleados = '';
            try {
                const empleado = JSON.parse(response);
                empleado.forEach(dato_Empleado => {
                    if(dato_Empleado.nombre_empresa == null)
                    {
                        dato_Empleado.nombre_empresa = "No Seleccionado";
                    }
                    if(dato_Empleado.nombre_lcompras == null)
                    {
                        dato_Empleado.nombre_lcompras = "No Seleccionado";
                    }
                    if(dato_Empleado.nombre_lventas == null)
                    {
                        dato_Empleado.nombre_lventas = "No Seleccionado";
                    }
                    datos_Empleados += `
                        <tr>
                            <td><div class='dato_Empleado_mod'>${dato_Empleado.ci_usuario}</div></td>
                            <td><div class='dato_Empleado_mod'>${dato_Empleado.nombre}</div></td>
                            <td><div class='dato_Empleado_mod'>${dato_Empleado.apellido}</div></td>
                            <td><div class='dato_Empleado_mod'>${dato_Empleado.nombre_usuario}</div></td>
                            <td><div class='dato_Empleado_mod'>${dato_Empleado.clave}</div></td>
                            <td><select disabled class = "drbx_lista_empresas">
                                <option value="${dato_Empleado.nit_empresa}">${dato_Empleado.nombre_empresa}</option>
                            </select></td>
                            <td><select disabled class = "drbx_lista_libro_compras">
                                <option value="${dato_Empleado.cod_libro_compras}">${dato_Empleado.nombre_lcompras}</option>
                            </select></td>
                            <td><select disabled class = "drbx_lista_libro_ventas">
                                <option value="${dato_Empleado.cod_libro_ventas}">${dato_Empleado.nombre_lventas}</option>
                            </select></td>
                            <td>
                                <span class='habilitar_modificar_empleado_lista'><a href='#' CI_usuario_emp='${dato_Empleado.ci_usuario}'><img src='../img/editar.png' class='imgABM'></a></span>
                                <span class='modificar_empleado_lista'> <a href='#' CI_usuario_emp='${dato_Empleado.ci_usuario}'> Guardar</a></span>
                                <span class='cancelar_modificar_empleado_lista'> <a href='#' CI_usuario_emp='${dato_Empleado.ci_usuario}'> Cancelar</a></span>
                            </td>
                            <td><a href='#' class='eliminar_empleado_lista' CI_usuario_emp='${dato_Empleado.ci_usuario}'><img src='../img/eliminar.png' class='imgABM'></a></td>
                        </tr>
                        `;
                });
                
            }
            catch(e) {
                console.log(response);
            }
            finally {
                $('#lista_empleado_empresa_cliente').html(datos_Empleados);
                $(document).find('.modificar_empleado_lista').hide();
                $(document).find('.cancelar_modificar_empleado_lista').hide();
            }
        });
    }

});