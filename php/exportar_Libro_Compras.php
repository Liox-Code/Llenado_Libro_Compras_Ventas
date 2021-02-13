<?php
  include 'header.php';
  if(!isset($_GET['cod_libro_compras']) && !isset($_SESSION['cod_libro_compras_seleccionada'])){
      header("location:listaEmpresasClientes.php");
  }
  else{
    if (isset($_GET['cod_libro_compras'])) {
      header("Refresh:0; url=listaFacturasLibroCompras.php");
      $_SESSION['cod_libro_compras_seleccionada'] = $_GET['cod_libro_compras'];
    }
  }
?> 

<div class="table-responsive" style=" width: 100%; max-height:800px; margin:10px 0px;">
  <table class="ListadoFacturas" id="listado_facturas_compras_exportar" style="width: 100%">
    <thead>
      <tr>
          <th><a href="#" class="">Fecha Factura o DUI</a></th>
          <th><a href="#" class="">Nit Proveedor</a></th>
          <th><a href="#" class="">Nombre o razon social</a></th>
          <th><a href="#" class="">N° factura</a></th>
          <th><a href="#" class="">N° DUI</a></th>
          <th><a href="#" class="">N° autoorización</a></th>
          <th><a href="#" class="">Importe total compra</a></th>
          <th><a href="#" class="">Importe no sujeto credito fiscal</a></th>
          <th><a href="#" class="">Subtotal</a></th>
          <th><a href="#" class="">Descuentos bonificaciones y rebajas sujetas IVA</a></th>
          <th><a href="#" class="">Importe base credito fiscal</a></th>
          <th><a href="#" class="">Credito fiscal</a></th>
          <th><a href="#" class="">Codigo control</a></th>
          <th><a href="#" class="">Tipo compra</a></th>
      </tr>
    </thead>
    <tbody id="mostrar_lista_facturas_libro_compras">
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
        const lc_mostrar_listar_facturas_registradas = true;
        $.get('abm_facturas_libro_compras.php', {lc_mostrar_listar_facturas_registradas}, (response) => {
          console.log(response);
            let datos_factura = '';
            try {
                const factura = JSON.parse(response);
                factura.forEach(dato_factura => {
                    datos_factura += `
                        <tr>
                            <td><div>${dato_factura.fecha_factura_o_DUI}</div></td>
                            <td><div>${dato_factura.nit_proveedor}</div></td>
                            <td><div>${dato_factura.nombre_o_razon_social}</div></td>
                            <td><div>${dato_factura.num_factura}</div></td>
                            <td><div>${dato_factura.num_DUI}</div></td>
                            <td><div>${dato_factura.num_autorisacion}</div></td>
                            <td><div>${dato_factura.importe_total_compra}</div></td>
                            <td><div>${dato_factura.importe_no_sujeto_credito_fiscal}</div></td>
                            <td><div>${dato_factura.subtotal}</div></td>
                            <td><div>${dato_factura.descuentos_bonificaciones_y_rebajas_sujetas_IVA}</div></td>
                            <td><div>${dato_factura.importe_base_credito_fiscal}</div></td>
                            <td><div>${dato_factura.credito_fiscal}</div></td>
                            <td><div>${dato_factura.codigo_control}</div></td>
                            <td><div>${dato_factura.tipo_compra}</div></td>
                        </tr>`;
                });
            }
            catch(e) {
                console.log(response);
            }
            finally {
                $('#mostrar_lista_facturas_libro_compras').html(datos_factura);
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
    orientation:'landscape',
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
