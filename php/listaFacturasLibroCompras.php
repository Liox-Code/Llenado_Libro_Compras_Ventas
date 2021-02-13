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
  <script src="../js/libro_compras_abm_facturas.js"></script>
  <script src="../js/validar.js"></script>

  <div>
    <input class="buscador_facturas" type="text" placeholder="Search..">
  </div>

  
  <div class="table-responsive" style=" width: 100%; max-height:640px;">
    <table class="ListadoFacturas">
      <thead>
        <tr>
          <th><a href="#" class="btn_Ordenar" name="fecha_factura_o_DUI">Fecha Factura o DUI</a></th>
          <th><a href="#" class="btn_Ordenar" name="nit_proveedor">Nit Proveedor</a></th>
          <th><a href="#" class="btn_Ordenar" name="nombre_o_razon_social">Nombre o razon social</a></th>
          <th><a href="#" class="btn_Ordenar" name="num_factura">N° factura</a></th>
          <th><a href="#" class="btn_Ordenar" name="num_DUI">N° DUI</a></th>
          <th><a href="#" class="btn_Ordenar" name="num_autorisacion">N° autoorización</a></th>
          <th><a href="#" class="">Importe total compra</a></th>
          <th><a href="#" class="">Importe no sujeto credito fiscal</a></th>
          <th><a href="#" class="">Subtotal</a></th>
          <th><a href="#" class="">Descuentos bonificaciones y rebajas sujetas IVA</a></th>
          <th><a href="#" class="">Importe base credito fiscal</a></th>
          <th><a href="#" class="">Credito fiscal</a></th>
          <th><a href="#" class="btn_Ordenar" name="codigo_control">Codigo control</a></th>
          <th><a href="#" class="btn_Ordenar" name="tipo_compra">Tipo compra</a></th>
          <th><a href="#" class="">Editar</a></th>
          <th><a href="#" class="">Eliminar</a></th>   
        </tr>
      </thead>
      <tbody id="lista_facturas_libro_compras">
      </tbody>
      <tfoot>
        <tr>
            <form id="registrar_factura_lista_libro_compras" class="form_Facturas"></form>
            <td><input required type="date" id="lc_txt_fecha_factura_o_DUI" form="registrar_factura_lista_libro_compras"></td>
            <td><input required class="validar_solo_numeros" maxlength="13" value="0" type="text" step="1" id="lc_txt_nit_proveedor" placeholder="Ingresar Nit Proveedor" form="registrar_factura_lista_libro_compras"></td>
            <td><input required maxlength="150" value="0" type="text" id="lc_txt_nombre_o_razon_social" placeholder="Ingresar Nombre o Razon Social" form="registrar_factura_lista_libro_compras"></td>
            <td><input required class="validar_solo_numeros" maxlength="15" value="0" type="text" step="1" id="lc_txt_num_factura" placeholder="Ingresar Num Factura" form="registrar_factura_lista_libro_compras"></td>
            <td><input required maxlength="16" value="0" type="text" id="lc_txt_num_DUI" placeholder="Ingresar Num DUI" form="registrar_factura_lista_libro_compras"></td>
            <td><input required class="validar_solo_numeros" maxlength="15" value="0" type="text" step="1" id="lc_txt_num_autorisacion" placeholder="Ingresar Num Autorisacion" form="registrar_factura_lista_libro_compras"></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_importe_total_compra" placeholder="Ingresar Importe Total Compra" form="registrar_factura_lista_libro_compras"></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_importe_no_sujeto_credito_fiscal" placeholder="Ingresar Importe No Sujeto Credito Fiscal" form="registrar_factura_lista_libro_compras"></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_subtotal" placeholder="Ingresar Subtotal" form="registrar_factura_lista_libro_compras" disabled></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_descuentos_bonificaciones_y_rebajas_sujetas_IVA" placeholder="Ingresar Descuentos Bonificaciones Y Rebajas Sujetas_IVA" form="registrar_factura_lista_libro_compras"></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_importe_base_credito_fiscal" placeholder="Ingresar Importe Base Credito Fiscal" form="registrar_factura_lista_libro_compras" disabled></td>
            <td><input required max="9999999999.99" value = "0" type="number" step="0.01" id="lc_txt_credito_fiscal" placeholder="Ingresar Credito Fiscal" form="registrar_factura_lista_libro_compras" disabled></td>
            <td><input required maxlength="17" type="text" id="lc_txt_codigo_control" placeholder="Ingresar Codigo Control" form="registrar_factura_lista_libro_compras"></td>
            <td><input required class="validar_solo_numeros" maxlength="1" value = "0" type="text" step="1" id="lc_txt_tipo_compra" placeholder="Ingresar Tipo Compra" form="registrar_factura_lista_libro_compras"></td>
            <td><input type="submit" id="registrar_factura_libro_compras" value="Registrar" form="registrar_factura_lista_libro_compras"></td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class='lblInformacion'>
    <div class='divInformacion'><div class='divInformacionTitulos'>Nombre Libro Compras:              </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Fecha Creación:                 </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Importe total compra:              </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Descuentos sujetas IVA:         </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Importe no sujeto credito fiscal:  </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Importe base credito fiscal:    </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Subtotal:                          </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Credito fiscal:                 </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Cantidad Facturas:                 </div><div class='divInformacionDatos'></div>
  </div>

<?php        
  include 'footer.php';
?>


