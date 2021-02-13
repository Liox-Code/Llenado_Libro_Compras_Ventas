<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>


    <table class="ListadoFacturas" id="example">
      <thead>
        <tr>
          <th>Fecha Factura o DUI</th>
          <th>Nit Proveedor</th>
          <th>Nombre o razon social</th>
          <th>Fecha Factura o DUI</th>
          <th>Nit Proveedor</th>
          <th>Nombre o razon social</th>
        </tr>
      </thead>
      <tbody id="lista_facturas_libro_ventas">
      </tbody>
      <tfoot>
        <tr>
            <form id="registrar_factura_lista_libro_compras" class="form_Facturas"></form>
            <td><input required type="date" id="lc_txt_fecha_factura_o_DUI" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_nit_proveedor" placeholder="Ingresar Numero Factura" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_nombre_o_razon_social" placeholder="Ingresar Numero Autorizacion" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input type="text" id="lc_txt_num_factura" placeholder="Ingresar Estado" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_num_DUI" placeholder="Ingresar Nit/CI Cliente" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input type="text" id="lc_txt_num_autorisacion" placeholder="Ingresar Nombre o Razon Social" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_importe_total_compra" placeholder="Ingresar Importe Total de la Venta" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_importe_no_sujeto_credito_fiscal" placeholder="Ingresar Importe No Sujetos al IVA" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_subtotal" placeholder="Ingresar_Exportaciones_y_Operaciones _xentas" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA" placeholder="Ingresar Ventas Gravadas a Tasa Cero" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_importe_base_credito_fiscal" placeholder="Ingresar Subtotal" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_credito_fiscal" placeholder="Ingresar Descuentos, Bonificaciones y Rebajas Sujetas al IVA" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_codigo_control" placeholder="Ingresar Importe Base para Débito Fiscal" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input required type="number" id="lc_txt_tipo_compra" placeholder="Ingresar Débito Fiscal" value="" form="registrar_factura_lista_libro_compras"></td>
            <td><input type="submit" id="registrar_factura_libro_compras" value="Registrar" form="registrar_factura_lista_libro_compras"></td>
            <td><a href ="registrar_QR_php"><img src='../img/QR_registrar.png' class='imgABM'></a></td>
        </tr>
      </tfoot>
    </table>

<center>
<button class="btn btn-success" id="json">JSON</button>

<button class="btn btn-success" id="pdf">PDF</button>

<button class="btn btn-success" id="csv">CSV</button>

</center>

<script type="text/javascript" src="src/jquery-3.3.1.slim.min.js"></script>

<script type="text/javascript" src="src/jspdf.min.js"></script>

<script type="text/javascript" src="src/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript" src="src/tableHTMLExport.js"></script>

<script type="text/javascript">const lv_listar_facturas_registradas = true;
  /*let datos_factura = '';
  datos_factura += `
  <tr>
      <td><div class='dato_factura_mod'>lol1</div></td>
      <td><div class='dato_factura_mod'>lol2</div></td>
      <td><div class='dato_factura_mod'>lol3</div></td>
      <td><div class='dato_factura_mod'>lol4</div></td>
      <td><div class='dato_factura_mod'>lol5</div></td>
      <td><div class='dato_factura_mod'>lol6</div></td>
      <td><div class='dato_factura_mod'>lol7</div></td>
      <td><div class='dato_factura_mod'>lol8</div></td>
      <td><div class='dato_factura_mod'>lol9</div></td>
      <td><div class='dato_factura_mod'>lol10</div></td>
      <td><div class='dato_factura_mod'>lol11</div></td>
  </tr>
  `;
  $('#lista_facturas_libro_ventas').html(datos_factura);*/
  
  $("#json").on("click",function(){
    $("#example").tableHTMLExport({
      type:'json',
      filename:'sample.json'
    });
  });

  $("#pdf").on("click",function(){
    $("#example").tableHTMLExport({
      type:'pdf',
      filename:'sample.pdf'
    });
  });

  $("#csv").on("click",function(){
    $("#example").tableHTMLExport({
      type:'csv',
      filename:'sample.csv'
    });
  });

</script>

</body>
</html>