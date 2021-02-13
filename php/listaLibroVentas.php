<?php
    include 'header.php';
    if(!isset($_GET['nit_empresa']) ){
      header("location:listaEmpresasClientes.php");
    }
    else{
      $_SESSION['nit_empresa_seleccionada'] = $_GET['nit_empresa'];
    }
?>
<script src="../js/libro_ventas_abm.js"></script>
<table class="ListadoFacturas">
  <thead>
    <tr>
      <th colspan = 4>Libros de Ventas</th>
    </tr>
    <tr>
      <th><a href="#">Nombre</a></th>
      <th><a href="#">Fecha</a></th>
      <th><a href="#">Editar</a></th>
      <th><a href="#">Eliminar</a></th>   
    </tr>
  </thead>
  <tbody id="lista_libro_ventas">
  </tbody>
  <tfoot>
    <tr>
        <td><button data-toggle='modal' data-target='#modal_crear_libro_ventas'>Crear libro ventas</button></td>
    </tr>
  </tfoot>
</table>

  <div class="modal fade" id="modal_crear_libro_ventas" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registrar Libro Ventas</h4>
        </div>
        <div class="modal-body">
          <form id="registrar_libro_ventas" class="form_Facturas"></form>
          <input class="form-control validate" required type="text" id="nombre_libro_ventas" placeholder="Ingresar Nombre Libro Ventas" form="registrar_libro_ventas">
        </div>
        <div class="modal-footer">
          <input type="submit" id="btn_registrar_libro_ventas" class="btn btn-info" value="Registrar" form="registrar_libro_ventas">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php
  include 'footer.php';
?>