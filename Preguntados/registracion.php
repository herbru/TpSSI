<?php
require_once('funciones/validacion.php');
require_once('funciones/basedatos.php');


$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

$errores = [];
if($_POST)
{
	$errores = validarRegistracion($_POST);

	if(!count($errores))
	{
		//LLEVAR AL USUARIO A FELICITACIONES
		newUser($_POST);
		header('location: dashboard.php');
		exit;
	}
}
?>

<?php
$title = 'Registración';
require_once('layouts/top-layout.php');
?>

		<h1><?php echo $title ?></h1>
		<?php if(count($errores) > 0){?>
			<div class="alert alert-danger" role="alert">
				<?php foreach($errores as $error)
				{
					echo $error . "<br/>";
				}?>
			</div>
		<?php }?>
		<form action="" method="POST" class="form login">
			<div class="form__field">
        <label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Name</span></label>
        <input id="login__username" type="text" name="nombre" class="form__input" placeholder="Name" required>
      </div>
			<div class="form__field">
        <label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Surname</span></label>
        <input id="login__username" type="text" name="apellido" class="form__input" placeholder="Surname" required>
      </div>
			<div class="form__field">
        <label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Username</span></label>
        <input id="login__username" type="text" name="username" class="form__input" placeholder="Username" required>
      </div>
			<div class="form__field">
        <label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Email</span></label>
        <input id="login__username" type="text" name="email" class="form__input" placeholder="Email" required>
      </div>

      <div class="form__field">
        <label for="login__password"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#lock"></use></svg><span class="hidden">Password</span></label>
        <input id="login__password" type="password" name="password" class="form__input" placeholder="Password" required>
      </div>

			<div class="form-group">
				<input type="checkbox" name="terminos" value="1"> Terminos y condiciones <br/>

			<div class="form__field">
	       <input type="submit" value="Sign In">
	    </div>
<?php require_once('layouts/bottom-layout.php');
