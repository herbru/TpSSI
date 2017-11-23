<?php
require_once('funciones/validacion.php');
require_once('funciones/basedatos.php');

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$errores = [];

if($_POST)
{
	$errores	= loguser($_POST);
}

if(count($errores) >= 1)
	{
		?>
			<div class="alert alert-danger" role="alert">
				<?php foreach($errores as $error)
				{
					echo $error . "<br/>";
				}?>
			</div>
<?php
	}

	if(isset($_SESSION['user']))
	{
		header('location: dashboard.php');
	}



$title = 'Index';
require_once('layouts/top-layout.php');
?>

    <form action="" method="POST" class="form login">

      <div class="form__field">
        <label for="login__username"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Username</span></label>
        <input id="login__username" type="text" name="username" class="form__input" placeholder="Username" required>
      </div>

      <div class="form__field">
        <label for="login__password"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#lock"></use></svg><span class="hidden">Password</span></label>
        <input id="login__password" type="password" name="password" class="form__input" placeholder="Password" required>
      </div>

      <div class="form__field">
        <input type="submit" value="Sign In">
      </div>

    </form>
		<p class="text--center">No Tienes cuenta? <a href="registracion.php">Create una</a> <svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="assets/images/icons.svg#arrow-right"></use></svg></p>


<?php require_once('layouts/bottom-layout.php'); ?>
