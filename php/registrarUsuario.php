<?php
  include 'headerPantallaPrincipal.php';
?>
<script src="../js/validar.js"></script>
  <img src="../img/pantallaPrincipal1.jpg" class="imagen">
  <div class="contenedorFormUsuarioRegistrar">
      <form action="abm_usuarios.php" method="post" class="formUsuario" >
        <label>CI : </label>
        <input type="text" name="txtCi" value="" required placeholder="CI" maxlength="18" class="validar_solo_numeros">
        <label>Nombre : </label>
        <input type="text" name="txtNombre" value="" required placeholder="Nombre" maxlength="20">
        <label>Apellido : </label>
        <input type="text" name="txtApellido" value="" required placeholder="Apellido" maxlength="20">
        <label>Nombre Usuario : </label>
        <input type="text" name="txtNombreUsuario" value="" required placeholder="Nombre Usuario" maxlength="20">
        <label>Contraseña : </label>
        <input type="password" name="txtContraseña" value="" required placeholder="Contraseña" maxlength="20">
        <label>Confirmar Contraseña : </label>
        <input type="password" name="txtConfirmarContraseña" value="" required placeholder="Confirmar Contraseña" maxlength="20">
        <div class="botones">
          <input type="submit" class="btnIniSesion" value="Registrar" name="registrar">
          <a href="iniciarSesion.php">
            <input type="button" class="btnRegistrar" value="Iniciar Sesión">
          </a>
        </div>
      </form>
  </div>
<?php
  include 'footer.php';
?>
