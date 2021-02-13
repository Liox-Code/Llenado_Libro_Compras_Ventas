<?php
  include 'header.php';
?>

<div class="container">
  <h2>Small Modal</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Small Modal</button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <form id="registrar_empresa_cliente_lista" class="form_Facturas"></form>
          <input required type="number" id="lista_empresas_nit" placeholder="Ingresar Nit Empresa" form="registrar_empresa_cliente_lista">
          <input required type="text" id="lista_empresas_nombre" placeholder="Ingresar Nombre Empresa" form="registrar_empresa_cliente_lista">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default" value="Registrar" form="registrar_empresa_cliente_lista">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  include 'footer.php';
?>

