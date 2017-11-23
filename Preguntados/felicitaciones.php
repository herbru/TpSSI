<?php
$title = 'Felicitaciones';
require_once('layouts/top-layout.php');
require_once('funciones/basedatos.php');
?>
		<div class="jumbotron">
		  <h1>Gracias por registrarse</h1>
		  <p>Felicitiaciones, se ha registrado con éxito</p>
			<?php
			echo $_SESSION['user'];
			?>
		  <p><a class="btn btn-primary btn-lg" href="logout.php" role="button">Logout</a></p>
		</div>
<?php require_once('layouts/bottom-layout.php'); ?>
