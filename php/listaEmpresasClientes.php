<?php
  include 'header.php';
?>
  <script src="../js/empresas_cliente_abm.js"></script>
  <script src="../js/validar.js"></script>
  <table class="ListadoFacturas">
    <thead>
      <tr>
        <th><a href="#">Nit Emmpresa</a></th>
        <th><a href="#">Nombre Empresa</a></th>
        <th><a href="#">Editar</a></th>
        <th><a href="#">Eliminar</a></th>   
      </tr>
    </thead>
    <tbody id="lista_empresa_cliente">
    </tbody>
    <tfoot>
      <tr>
          <form id="registrar_empresa_cliente_lista" class="form_Facturas"></form>
          <td><input required type="text" class="validar_solo_numeros" maxlength="13"  id="lista_empresas_nit" placeholder="Ingresar Nit Empresa" form="registrar_empresa_cliente_lista" ></td>
          <td><input required type="text" id="lista_empresas_nombre" placeholder="Ingresar Nombre Empresa" form="registrar_esmpresa_cliente_lista" ></td>
          <td><input type="submit" value="Registrar" form="registrar_empresa_cliente_lista"></td>
      </tr>
    </tfoot>
  </table>


<?php
  include 'footer.php';
?>
