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
  <script src="../js/libro_ventas_abm_facturas.js"></script>
  <script src="../js/validar.js"></script>

  <div>
    <input class="buscador_facturas" type="text" placeholder="Search..">
  </div>

  <div class="table-responsive" style=" width: 100%; max-height:600px; margin:10px 0px;">
    <table  class="ListadoFacturas">
      <thead>
      <tr>
        <th><a href="#" class="btn_Ordenar" name="Fecha_Factura">Fecha Factura</a></th>
        <th><a href="#" class="btn_Ordenar" name="Num_Factura">N° Factura</a></th>
        <th><a href="#" class="btn_Ordenar" name="Num_Autorizacion">N° Autorización</a></th>
        <th><a href="#" class="btn_Ordenar" name="Estado">Estado</a></th>
        <th><a href="#" class="btn_Ordenar" name="Nit_CI_Cliente">Nit/CI Cliente</a></th>
        <th><a href="#" class="btn_Ordenar" name="Nombre_Razon_Social">Nombre o Razón Social</a></th>
        <th><a href="#" class="">Importe Total de la Venta</a></th>
        <th><a href="#" class="">Importe ICE/ IEHD/ IPJ/TASAS/ Otros No Sujetos al IVA</a></th>
        <th><a href="#" class="">Exportaciones y Operaciones Exentas</a></th>
        <th><a href="#" class="">Ventas Gravadas a Tasa Cero</a></th>
        <th><a href="#" class="">Subtotal</a></th>
        <th><a href="#" class="">Descuentos, Bonificaciones y Rebajas Sujetas al IVA</a></th>
        <th><a href="#" class="">Importe Base para Débito Fiscal</a></th>
        <th><a href="#" class="">Débito Fiscal</a></th>
        <th><a href="#" class="btn_Ordenar" name="Código_Control">Código de Control</a></th>
        <th><a href="#" class="">Editar</a></th>
        <th><a href="#" class="">Eliminar</a></th>
      </tr>
      </thead>
      <tbody id="lista_facturas_libro_ventas">
      </tbody>
    <tfoot>
      <tr>
          <form id="registrar_factura_lista_libro_ventas" class="form_Facturas"></form>
          <td><input required type="date" id="lv_txt_Fecha_Factura" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required maxlength="15" type="text" step="1" id="lv_txt_Num_Factura" placeholder="Ingresar Numero Factura" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required maxlength="15" type="text" step="1" id="lv_txt_Num_Autorizacion" placeholder="Ingresar Numero Autorizacion" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required maxlength="1" type="text" id="lv_txt_Estado" placeholder="Ingresar Estado" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required maxlength="13" type="text" step="1" id="lv_txt_Nit_CI_Cliente" placeholder="Ingresar Nit/CI Cliente" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required maxlength="150" type="text" id="lv_txt_Nombre_Razon_Social" placeholder="Ingresar Nombre o Razon Social" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Importe_Total_Venta" placeholder="Ingresar Importe Total de la Venta" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Importe_No_Sujeto_IVA" placeholder="Ingresar Importe No Sujetos al IVA" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Exportaciones_y_Operaciones_Exentas" placeholder="Ingresar_Exportaciones_y_Operaciones _xentas" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Ventas_Gravadas_Tasa_Cero" placeholder="Ingresar Ventas Gravadas a Tasa Cero" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Subtotal" placeholder="Ingresar Subtotal" value="" form="registrar_factura_lista_libro_ventas" disabled></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Descuentos_Bonificaciones_Rebajas_Sujetas_IVA" placeholder="Ingresar Descuentos, Bonificaciones y Rebajas Sujetas al IVA" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Importe_Base_Débito_Fiscal" placeholder="Ingresar Importe Base para Débito Fiscal" value="" form="registrar_factura_lista_libro_ventas" disabled></td>
          <td><input required max="9999999999.99" type="number" step="0.01" id="lv_txt_Débito_Fiscal" placeholder="Ingresar Débito Fiscal" value="" form="registrar_factura_lista_libro_ventas" disabled></td>
          <td><input required maxlength="17" type="text" id="lv_txt_Código_Control" placeholder="Ingresar Código de Control" value="" form="registrar_factura_lista_libro_ventas"></td>
          <td><input type="submit" id="registrar_factura_libro_ventas" value="Registrar" form="registrar_factura_lista_libro_ventas"></td>
      </tr>
    </tfoot>
    </table>
  </div>

  <div class='lblInformacion'>
    <div class='divInformacion'><div class='divInformacionTitulos'>Nombre Libro Ventas:                 </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Fecha Creación:             </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Importe Total Venta:                 </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Subtotal:                   </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Importe No Sujeto IVA:               </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Descuentos Sujetas IVA:     </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Expor. y Oper. Exentas:              </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Importe Base Débito Fiscal: </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Ventas Gravadas Tasa Cero:           </div><div class='divInformacionDatos'></div><div class='divInformacionTitulos'>Débito Fiscal:              </div><div class='divInformacionDatos'></div></div>
    <div class='divInformacion'><div class='divInformacionTitulos'>Ventas Gravadas Tasa Cero:           </div><div class='divInformacionDatos'></div>
  </div>
<?php
  include 'footer.php';
?>
