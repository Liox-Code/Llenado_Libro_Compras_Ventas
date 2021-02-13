<?php
  include 'header.php';
    $ci=$_SESSION["usuCI"];
    $query="SELECT `ci_usuario`,`nombre`, `apellido`, `nombre_usuario`, `clave`
    FROM usuario 
    WHERE ci_usuario='$ci'";
    $res=$db->query($query);
    $row=mysqli_fetch_array($res);
?>
<div class="contenedorForms">
  <div class="contenedorRegistroFact">
    <form action="abm_usuarios.php" method="post" class="formaModificar">
            <label>C.I. : </label>
            <input type="number" name="txtCi" value="<?php echo $row[0]; ?>" required>
            <label>Nombre : </label>
            <input type="text" name="txtNombre" value="<?php echo $row[1]; ?>" required>
            <label>Apellido : </label>
            <input type="text" name="txtApellido" value="<?php echo $row[2]; ?>" required>
            <label>Nombre Usuario : </label>
            <input type="text" name="txtNombreUsuario" value="<?php echo $row[3]; ?>" required>
            <label>Clave : </label>
            <input type="text" name="txtContraseña" value="<?php echo $row[4]; ?>" required>
            <div class="botones">
              <input type="submit" class="btnModificar" value="Guardar Cambios" name="modificar" id="btnModificarCuentaUsuario">
            </div>
    </form>
  </div>
</div>
<?php
  include 'footer.php';
?>