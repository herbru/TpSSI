<?php
session_start();
$cuser = 0;

function connect()
{
	try {
		$db = new PDO(
			'mysql:host=localhost;dbname=preguntados;charset=utf8mb4',
			'root',
			'',
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
	} catch (Exception $e) {
		die("No se pudo conectar: " . $e->getMessage())
	}
	return $db;
}

function newpregunta(array $datos)
{
	try {
		$conn = connect();
		$db->beginTransaction();
		$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = :user");
		$stmt->execute(array(':user' => $_SESSION['user']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("SELECT id FROM categorias WHERE categoria = :cat");
		$stmt->execute(array(':cat' => $datos['cat']));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("INSERT INTO preguntas (pregunta, usuario_id, categorias_id)
		VALUES (:pre, :us, :cat)");
		$stmt->execute(array(':pre' => $datos['pregunta'], ':us' => $row['id'], ':cat' => $rows['id']));

		$stmt = $conn->prepare("SELECT id FROM preguntas WHERE pregunta = :pregu");
		$stmt->execute(array(':pregu' => $datos['pregunta']));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

			if($datos['Opciones'] == "Opcion1")
			{
				$correcto1 = $datos['Opciones'];
				$correcto2 = "";
				$correcto3 = "";
				$correcto4 = "";
			} else if($datos['Opciones'] == "Opcion2")
			{
				$correcto2 = $datos['Opciones'];
				$correcto1 = "";
				$correcto3 = "";
				$correcto4 = "";
			} else if($datos['Opciones'] == "Opcion3")
			{
				$correcto3 = $datos['Opciones'];
				$correcto1 = "";
				$correcto2 = "";
				$correcto4 = "";
			}else if($datos['Opciones'] == "Opcion4")
		{
			$correcto4 = $datos['Opciones'];
			$correcto3 = "";
			$correcto2 = "";
			$correcto1 = "";
		}

			$stmt = $conn->prepare("INSERT INTO opciones(texto, correcta, preguntas_id)
			VALUES (:op, :co, :pre);");
			$stmt->execute(array(':op' => $datos['popcion'], ':co' => $correcto1, ':pre' => $rows['id']));

			$stmt = $conn->prepare("INSERT INTO opciones(texto, correcta, preguntas_id)
			VALUES (:op, :co, :pre);");
			$stmt->execute(array(':op' => $datos['sopcion'], ':co' => $correcto2, ':pre' => $rows['id']));

			$stmt = $conn->prepare("INSERT INTO opciones(texto, correcta, preguntas_id)
			VALUES (:op, :co, :pre);");
			$stmt->execute(array(':op' => $datos['topcion'], ':co' => $correcto3, ':pre' => $rows['id']));

			$stmt = $conn->prepare("INSERT INTO opciones(texto, correcta, preguntas_id)
			VALUES (:op, :co, :pre);");
			$stmt->execute(array(':op' => $datos['copcion'], ':co' => $correcto4, ':pre' => $rows['id']));
			$db->commit();
	} catch (Exception $e) {
		$db->rollBack();
  	echo "Fallo: " . $e->getMessage()
	}
}

function modpregunta(array $datos)
{
	try {
		$conn = connect();

		$db->beginTransaction();

		$stmt = $conn->prepare("SELECT id FROM preguntas WHERE pregunta = :pregu");
		$stmt->execute(array(':pregu' => $datos['pregunta']));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = :user");
		$stmt->execute(array(':user' => $_SESSION['user']));
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		var_dump($datos['array']);
		$llego_array=explode("-",$datos['array']);
		var_dump($llego_array);

		$stmt = $conn->prepare("UPDATE preguntas SET pregunta = :preguntas, usuario_id = :us, categorias_id = :cat WHERE id = :id");
		$stmt->execute(array(':preguntas' => $datos['pregunta'], ':us' => $row[0]['id'] , ':cat' => 1, ':id' => $rows['id']));

		for ($i=0; $i < 4 ; $i++) {

			$stmt = $conn->prepare("UPDATE opciones SET texto = :preguntas WHERE preguntas_id = :id");
			$stmt->execute(array(':preguntas' => $llego_array[$i], ':id' => $rows['id']));
			$db->commit();
		}
			//header('location: dashboard.php');
	} catch (Exception $e) {
		$db->rollBack();
  	echo "Fallo: " . $e->getMessage();
	}
}

function newUser(array $datos)
{
	try {
		$conn = connect();
		$db->beginTransaction();
		$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, username, password)
		VALUES (:nombre,:apellido,:email,:username, :password)");
		$stmt->execute(array(':nombre' => $datos['nombre'], ':apellido' => $datos['apellido'], ':email' =>$datos['email'], ':username' =>  $datos['username'], ':password' => $datos['password'] ));
		$db->commit();

	} catch (Exception $e) {
		$db->rollBack();
  	echo "Fallo: " . $e->getMessage();
	}
}

function loguser(array $datos)
{
	try {
		$conn = connect();
		$db->beginTransaction();
		$stmt = $conn->prepare("SELECT * FROM usuarios WHERE username=:username AND password=:password");
		$stmt->execute(array(':username' => $datos['username'],':password' => $datos['password']));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if(count($rows) > 0)
		{
			$_SESSION["user"] = $datos['username'];
			header('location: dashboard.php');
		}
		else {
			$errores = [];
			$errores['error'] = 'Usuario y/o Contraseña incorrecta ';

			return $errores;
		}
	}
	$db->commit();
	catch(Exception $e) {
		$db->rollBack();
  	echo "Fallo: " . $e->getMessage();
	}
}

	function Borrar(array $datos)
	{
		try {
			$conn = connect();
			$db->beginTransaction();
			$stmt = $conn->prepare('SET FOREIGN_KEY_CHECKS = 0');
			$stmt->execute();

			$stmt = $conn->prepare("DELETE FROM preguntas WHERE id=:id");
			$stmt->execute(array(':id' => $datos['Eliminar']));

			$stmt = $conn->prepare("DELETE FROM opciones WHERE preguntas_id=:ids");
			$stmt->execute(array(':ids' => $datos['Eliminar']));

			$stmt = $conn->prepare('SET FOREIGN_KEY_CHECKS = 1');
			$stmt->execute();
			$db->commit();
			header('location: dashboard.php');
		}
	} catch (Exception $e) {
		$db->rollBack();
  	echo "Fallo: " . $e->getMessage();
	}
}


function ModificarP(array $datos)
{
	try {
		$conn = connect();
		$db->beginTransaction();
		$stmt = $conn->prepare("SELECT * FROM preguntas WHERE id=:id");
		$stmt->execute(array(':id' => $datos['id']));
		return $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("SELECT * FROM opciones WHERE preguntas_id=:id");
		$stmt->execute(array(':id' => $datos['id']));
		return $stmt->fetch(PDO::FETCH_ASSOC);
		$db->commit();
} catch (Exception $e) {
	$db->rollBack();
	echo "Fallo: " . $e->getMessage();
}
}

function ModificarO(array $datos)
{
	try {
		$conn = connect();
		$db->beginTransaction();
		$stmt = $conn->prepare("SELECT * FROM opciones WHERE preguntas_id=:id");
		$stmt->execute(array(':id' => $datos['id']));
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db->commit();
	} catch (Exception $e) {
		$db->rollBack();
		echo "Fallo: " . $e->getMessage();
	}
}
