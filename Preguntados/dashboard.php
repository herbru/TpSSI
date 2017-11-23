<?php
$title = 'DashBoard';
require_once('layouts/top-layout.php');
require_once('L.php');
require_once('funciones/basedatos.php');
if(isset($_SESSION['user']))
{
  $v1 = $_SESSION['user'];
}
else {
  header('location: index.php');
}

echo "<table>"; //EMPIEZA A CREAR LA TABLA CON LOS ENCABEZADOS DE TABLA
echo "<tr>";//<tr> CREA UNA NUEVA FILA
echo "<td>PREGUNTA</td>";
echo "<td>  </td>";
echo "<td>  </td>";
echo "<td>OPCION 1</td>";
echo "<td>  </td>";
echo "<td>  </td>";
echo "<td>OPCION 2</td>";
echo "<td>  </td>";
echo "<td>  </td>";
echo "<td>OPCION 3</td>";
echo "<td>  </td>";
echo "<td>  </td>";
echo "<td>OPCION 4</td>";
echo "<td>  </td>";
echo "<td>  </td>";
echo "<td>OPCION CORRECTA</td>";
echo "</tr>";

$conn = connect();//SELECCIONA LA BASE DE DATOS "USUARIOS"

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE username=:username");
$stmt->execute(array(':username' => $v1));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM preguntas WHERE usuario_id=:user");
$stmt->execute(array(':user' => $rows['id']));
$rowss = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num = count($rowss);
$num = $num - 1;
do{

  $stmt = $conn->prepare("SELECT * FROM opciones WHERE preguntas_id=:pre");
  $stmt->execute(array(':pre' => $rowss[$num]['id']));
  $rowsa = $stmt->fetchAll(PDO::FETCH_ASSOC);


//LA VARIABLE $REG GUARDA LOS REGISTROS DE LA CONSULTA REALIZADA
echo "<tr>";
echo "<td>"?> <input type="hidden" for="email" name="pregunta" value="<?php echo $rowss[$num]['pregunta'] ?>"><?php echo $rowss[$num]['pregunta'] ?></label> <?php "</td>";
echo "<td>  </td>";
echo "<td>  </td>";
foreach($rowsa as $rows) {?><form name="form" action="" method="POST" >
<?php
echo "<td>"?> <input type="hidden" for="email" name="popcion" value="<?php echo $rows['texto'] ?>"><?php echo $rows['texto'] ?></label> <?php "</td>";
echo "<td>  </td>";
echo "<td>  </td>";
}
foreach($rowsa as $rows) {?><form name="form" action="" method="POST" >
<?php
if($rows['correcta'] == ""){}
else{
  echo "<td>"?> <input type="hidden" for="email" name="opcioncorrecta" value="<?php echo $rows['correcta'] ?>"><?php echo $rows['correcta'] ?></label> <?php "</td>";
  echo "<td>  </td>";
  echo "<td>  </td>";
    }
}

  echo "<td>" ?> <button type="submit" class="btn btn-default"value="<?php echo $rowss[$num]['id'] ?>" name= "Eliminar">Eliminar</button> <?php "</td>";
  echo "<td>  </td>";
  echo "<td>  </td>";
  echo "<td>"?> <a href="pregunta.php?id=<?php echo $rowss[$num]['id'] ?>">Modificar</a>  <?php "</td>";
  echo "</tr>";//EN CADA CELDA SE COLOCA EL CONTENIDO DE REG
  ?>
</form>
<?php
$num = $num -1;
} while($num >= 0);
echo "</table>";

if($_POST)
{
  if(isset($_POST['Eliminar']))
  {
    Borrar($_POST);
  }

}
?>
		<div class="jumbotron">
		  <p>Desde aca se pueden crear nuevas Preguntas, ver las que ya estan creadas, borrarlas y modificarlas</p>
		  <p><a class="btn btn-primary btn-lg" href="pregunta.php" role="button">Nueva Pregunta</a></p>
       <p><a class="btn btn-primary btn-lg" href="logout.php" role="button">Logout</a></p>
		</div>
<?php require_once('layouts/bottom-layout.php'); ?>
