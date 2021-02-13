<?php
  include 'header.php';
?>
  <script src="../js/empleado_empresa_cliente_abm.js"></script>
  <script src="../js/validar.js"></script>
  <div class="table-responsive" style=" width: 100%; max-height:800px; margin:10px 0px;">
    <table class="ListadoFacturas">
      <tr>
        <th><a href="#">CI Usuario</a></th>
        <th><a href="#">Nombre</a></th>
        <th><a href="#">Apellido</a></th>
        <th><a href="#">Nombre Usuario</a></th>
        <th><a href="#">Clave</a></th>
        <th><a href="#">Empresa</a></th>
        <th><a href="#">Libro Compras</a></th>
        <th><a href="#">Libro Ventas</a></th>
        <th><a href="#">Editar</a></th>
        <th><a href="#">Eliminar</a></th>
      </tr>    
      <tbody id="lista_empleado_empresa_cliente">
      </tbody>
      <tr>
        <form id="registrar_empleado_empresa_cliente_lista" class="form_Facturas"></form>
        <td><input type="number" id="usu_emp_Ci" value="" required placeholder="CI" form="registrar_empleado_empresa_cliente_lista"></td>
        <td><input type="text" id="usu_emp_Nombre" value="" required placeholder="Nombre" form="registrar_empleado_empresa_cliente_lista"></td>
        <td><input type="text" id="usu_emp_Apellido" value="" required placeholder="Apellido" form="registrar_empleado_empresa_cliente_lista"></td>
        <td><input type="text" id="usu_emp_NombreUsuario" value="" required placeholder="Nombre Usuario" form="registrar_empleado_empresa_cliente_lista"></td>
        <td><input type="password" id="usu_emp_Contraseña" value="" required placeholder="Contraseña" form="registrar_empleado_empresa_cliente_lista"></td>
        <td>
          <select class = "drbx_lista_empresas" id="usu_emp_drbx_lista_empresas">
          </select>
        </td>
        <td>
          <select class = "drbx_lista_libro_compras" id="usu_emp_drbx_lista_libro_compras">
          </select>
        </td>
        <td>
          <select class = "drbx_lista_libro_ventas" id="usu_emp_drbx_lista_libro_ventas">
          </select>
        </td>
        <td><input type="submit" value="Registrar" form="registrar_empleado_empresa_cliente_lista"></td>
      </tr>
    </table>
    </div>
<?php
  include 'footer.php';
?>
