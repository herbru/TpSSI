<?php
$title = 'Index';
require_once('layouts/top-layout.php');
function Listados(array $datos)
{ ?>
  <form action="" method="POST">
      <label for="nombre"><?php $datos['Titulo'] ?> </label>
      <button type="submit" class="btn btn-default">Agregarme a la Lista</button>
  </form>

  <?php

  if($_POST)
  {
    $conn = connect();//SELECCIONA LA BASE DE DATOS "USUARIOS"

    $stmt = $conn->prepare("SELECT cantuser FROM listado WHERE identificacion = :iden");
    $stmt->execute(array(':iden' => $datos['Compartir']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $conn->prepare("INSERT INTO listado(cantuser) VALUES(:cant)");
    $stmt->execute(array(':cant' => $rows ));
    $affected_rows = $stmt->rowCount();
  }
}
?>


<?php require_once('layouts/bottom-layout.php'); ?>
