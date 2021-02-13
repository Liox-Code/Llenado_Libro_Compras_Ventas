<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/estilo_header.css">
    <link rel="stylesheet" href="../css/pantallaPrincipal.css"> 
    <link rel="stylesheet" href="../css/form_Iniciar_Sesion.css">    
    

    <!-- 
    <link rel="stylesheet" href="../css/forma_estilo.css">
    <link rel="stylesheet" href="../css/modal.css">
    -->

    <script>
      function mostrarModal() {
        document.getElementById('modal').style.display = "block";
      }

      function cerrarModal() {
        document.getElementById('modal').style.display = "none";
      }

      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
    </script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous">
    </script>

    <!-- modal -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  </head>
  <body>
    <header>
      <nav>
        <a href ="../index.php" class='botonNavImg'><img src='../img/c.png' class='imgLogo'></a>
        <a href='iniciarSesion.php' class='botonNav'>Iniciar Sesión</a>
        <a href='registrarUsuario.php' class='botonNav'>Crear Cuenta</a>
      </nav>
    </header>
<?php
  
  if(isset($_GET['tituloMensajeModal']) && isset($_GET['mensajeModal'])){
    $tituloMensajeModal=$_GET['tituloMensajeModal'];
    $mensajeModal=$_GET['mensajeModal'];
    mensajeAdvertenciaModal($tituloMensajeModal,$mensajeModal);
  }
  function mensajeAdvertenciaModal($tituloMensajeModal,$mensajeModal) {
    echo "<div id='modal' class='modal'>
            <div class='modal-contenedor'>
              <div class='modal-cabecera'>
                <span class='boton_cerrar' onclick='cerrarModal()'>&times;</span>
                <h2 class='modal_titulo'>".$tituloMensajeModal."</h2>
              </div>
              <div class='modal-contenido'>
                <p>".$mensajeModal."</p>
              </div>
            </div>
          </div><script>mostrarModal();</script>";
  }
  ?>