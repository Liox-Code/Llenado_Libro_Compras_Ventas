<?php
  include 'header.php';
  if(!isset($_GET['cod_libro_ventas']) && !isset($_SESSION['cod_libro_ventas_seleccionado'])){
    header("location:listaEmpresasClientes.php");
}
else{
  if (isset($_GET['cod_libro_ventas'])) {
    header("Refresh:0; url=listaFacturasLibroVentas.php");
    $_SESSION['cod_libro_ventas_seleccionado'] = $_GET['cod_libro_ventas'];
  }
}
?> 

<div class="table-responsive" style=" width: 100%; max-height:800px; margin:10px 0px;">
  <table class="ListadoFacturas" id="listado_facturas_compras_exportar" style="width: 100%">
    <thead>
      <tr>
        <th><a href="#" class="">Fecha Factura</a></th>
        <th><a href="#" class="">N° Factura</a></th>
        <th><a href="#" class="">N° Autorización</a></th>
        <th><a href="#" class="">Estado</a></th>
        <th><a href="#" class="">Nit/CI Cliente</a></th>
        <th><a href="#" class="">Nombre o Razón Social</a></th>
        <th><a href="#" class="">Importe Total de la Venta</a></th>
        <th><a href="#" class="">Importe ICE/ IEHD/ IPJ/TASAS/ Otros No Sujetos al IVA</a></th>
        <th><a href="#" class="">Exportaciones y Operaciones Exentas</a></th>
        <th><a href="#" class="">Ventas Gravadas a Tasa Cero</a></th>
        <th><a href="#" class="">Subtotal</a></th>
        <th><a href="#" class="">Descuentos, Bonificaciones y Rebajas Sujetas al IVA</a></th>
        <th><a href="#" class="">Importe Base para Débito Fiscal</a></th>
        <th><a href="#" class="">Débito Fiscal</a></th>
        <th><a href="#" class="">Código de Control</a></th>
      </tr>
    </thead>
    <tbody id="mostrar_lista_facturas_libro_ventas">
    </tbody>
    <tfoot>
      <tr>
      </tr>
    </tfoot>
  </table>
</div>

<center>
  <button class="btn btn-default" id="pdf">PDF</button>

  <button class="btn btn-default" id="csv">CSV</button>

  <button class="btn btn-default" id="txt">TXT</button>
</center>

<script type="text/javascript">
listar_facturas();

function listar_facturas() {
  const lv_mostrar_facturas_registradas_exportar = true;
  $.get('abm_facturas_libro_ventas.php', {lv_mostrar_facturas_registradas_exportar}, (response) => {
      let datos_factura = '';
      try {
          const factura = JSON.parse(response);
          factura.forEach(dato_factura => {
              datos_factura += `
                  <tr>
                      <td>${dato_factura.fecha_factura}</td>
                      <td>${dato_factura.num_factura}</td>
                      <td>${dato_factura.num_autorisacion}</td>
                      <td>${dato_factura.estado}</td>
                      <td>${dato_factura.nit_ci_cliente}</td>
                      <td>${dato_factura.nombre_o_razon_social}</td>
                      <td>${dato_factura.importe_total_venta}</td>
                      <td>${dato_factura.importe_ICE_IEHD_IPJ_otros_no_sujetos_IVA}</td>
                      <td>${dato_factura.exportaciones_y_operaciones_exentas}</td>
                      <td>${dato_factura.ventas_gravadas_tasa_cero}</td>
                      <td>${dato_factura.subtotal}</td>
                      <td>${dato_factura.descuentos_bonificaciones_y_rebajas_sujetas_IVA}</td>
                      <td>${dato_factura.importe_base_debito_fiscal}</td>
                      <td>${dato_factura.debito_fiscal}</td>
                      <td>${dato_factura.codigo_control}</td>
                  </tr>
                  `;
          });
      }
      catch(e) {
          console.log('Error listar_facturas');
      }
      finally {
          $('#mostrar_lista_facturas_libro_ventas').html(datos_factura);
      }
  });
}
</script>

<script type="text/javascript" src="src/jquery-3.3.1.slim.min.js"></script>

<script type="text/javascript" src="src/jspdf.min.js"></script>

<script type="text/javascript" src="src/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript" src="src/tableHTMLExport.js"></script>

<script type="text/javascript">

$("#pdf").on("click",function(){
  $("#listado_facturas_compras_exportar").tableHTMLExport({
    type:'pdf',
    orientation:'l',
    filename:'libro_compras.pdf'

  });
});

$("#csv").on("click",function(){
  $("#listado_facturas_compras_exportar").tableHTMLExport({
    type:'csv',
    filename:'libro_compras.csv'
  });
});

$("#txt").on("click",function(){
  $("#listado_facturas_compras_exportar").tableHTMLExport({
    type:'txt',
    filename:'libro_compras.txt'
  });
});

</script>
<?php
  include 'footer.php';
?>
