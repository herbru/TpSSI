<?php
require_once('funciones/validacion.php');
require_once('funciones/basedatos.php');




$pregunta = isset($_POST['pregunta']) ? $_POST['pregunta'] : '';
$Opcion = isset($_POST['Opcion']) ? $_POST['Opcion'] : [];
$Opcionc = isset($_POST['Opciones']) ? $_POST['Opciones'] : '';
$cats = isset($_POST['cat']) ? $_POST['cat'] : [];
$id = isset($_POST['id']) ? $_POST['id'] : '';


if($_POST)
{
	if(isset($_POST['Modificar']))
	{
			modpregunta($_POST);
			var_dump($_POST);
	}
	else if(isset($_POST['Crear']))
	{
		var_dump($_POST);
		newpregunta($_POST);
		header('location: dashboard.php');
		exit;
	}

}
?>

<?php
$title = 'Nueva Lista';
require_once('layouts/top-layout.php');

if(isset($_GET['id'])) {
	$pregunta = ModificarP($_GET);
	$opcion = ModificarO($_GET);

	?>
	<form action="" method="POST" class="form login">
		<div class="form__field">
			<label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Name</span></label>
			<input id="login__username" type="text" value="<?php echo $pregunta['pregunta'] ?>" name="pregunta" class="form__input" placeholder="Pregunta" required>
		</div>

		<?php var_dump($opcion[0]['texto']);
			for($i=0;$i<4;$i++)
				{
					?>
					<div class="form__field">
						<label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Opcion <?php echo $i ?></span></label>
						<input id="login__username" type="text" value="<?php echo $opcion[$i]['texto'] ?>" name="Opcion" class="form__input" placeholder="Opcion" required>
					</div>
					<input type="hidden" name="array" value="<?=$opcion[$i]['texto']."-"?>">
					<?php
				}
				?>

		<div class="form__field">
			Opcion 1<input type="radio" name="Opciones" value="Opcion1"  <?php if($opcion[0]['correcta'] == "Opcion1"){?>checked="checked"<?php }?> />
			Opcion 2<input type="radio" name="Opciones" value="Opcion2"  <?php if($opcion[1]['correcta'] == "Opcion2"){?>checked="checked"<?php }?> />
			Opcion 3<input type="radio" name="Opciones" value="Opcion3"  <?php if($opcion[2]['correcta'] == "Opcion3"){?>checked="checked"<?php }?> />
			Opcion 4<input type="radio" name="Opciones" value="Opcion4"  <?php if($opcion[3]['correcta'] == "Opcion4"){?>checked="checked"<?php }?> />
		</div>

		<select name="cat">
  		<option value="">Select...</option>
  		<option value="Quimica">Quimica</option>
  		<option value="Tecnologia">Tecnologia</option>
			<option value="Historia">Historia</option>
			<option value="Boludeces">Boludeces</option>
		</select>


		<div class="form__field">
			<input id="login__username" type="text" hidden="hidden" value="<?php echo $_GET['id'] ?>" name="id" class="form__input">
		</div>


		<div class="form__field">
			<button type='submit' id="Modificar" value="Modificar" name='Modificar'>Modificar</button>
		</div>
	</form>
<?php } ?>

 <?php require_once('layouts/bottom-layout.php'); ?>
