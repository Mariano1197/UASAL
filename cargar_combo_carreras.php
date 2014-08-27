<?PHP
//cargar combo carreras en la seccion de gestio alumnos (con ajax)
include 'bd.php';

function validar($data) {
  //$data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$id_facultad = validar($_POST["id"]);


$conexion = conexion("localhost","uasal","root","");

$resultado = consulta($conexion,"SELECT car_id, car_nombre from carrera where fac_id = '$id_facultad' ");
if ($resultado == 0 ) {
	
	echo '<option selected="selected" value="0">No se encontraron carreras</option>';
}

while ($row = mysqli_fetch_array($resultado)) {

		echo '<option value="'.$row["car_id"] . '">' . mb_convert_encoding($row["car_nombre"], 'UTF-8') . '</option>';
}



?>
