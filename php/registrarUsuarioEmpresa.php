<?php
  include 'header.php';
?>
  <div class="contenedorFormUsuarioRegistrar">
      <form action="abm_usuarios.php" method="post" class="formUsuario" >
        <label>CI : </label>
        <input type="number" name="txtCi" value="" required placeholder="CI">
        <label>Nombre : </label>
        <input type="text" name="txtNombre" value="" required placeholder="Nombre">
        <label>Apellido : </label>
        <input type="text" name="txtApellido" value="" required placeholder="Apellido">
        <label>Nombre Usuario : </label>
        <input type="text" name="txtNombreUsuario" value="" required placeholder="Nombre Usuario">
        <label>Contraseña : </label>
        <input type="password" name="txtContraseña" value="" required placeholder="Contraseña">
        <label>Confirmar Contraseña : </label>
        <input type="password" name="txtConfirmarContraseña" value="" required placeholder="Confirmar Contraseña">
        <div class="botones">
          <input type="submit" class="btnIniSesion" value="Registrar" name="registrarUsuarioEmpresa">
        </div>
      </form>
  </div>
<?php
  include 'footer.php';
?>
