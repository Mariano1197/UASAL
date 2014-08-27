<?PHP
//modifica los datos del abm de la seccion gestion para alumnos y personal
include 'bd.php';

//realizamos la conexion a la bd
$con = conexion("localhost","uasal","root","");


$alu_id = mysqli_real_escape_string($con,$_POST["alu_id"]);
$alu_nombre = $_POST["alu_nombre"];
$alu_apellido = mysqli_real_escape_string($con,$_POST["alu_apellido"]);
$alu_dni = mysqli_real_escape_string($con,$_POST["alu_dni"]);
$alu_fechanacimiento = mysqli_real_escape_string($con,$_POST["alu_fechanacimiento"]);
$alu_domicilio = mysqli_real_escape_string($con,$_POST["alu_domicilio"]);
$alu_colegioegresado = mysqli_real_escape_string($con,$_POST["alu_colegioegresado"]);
$alu_titulosecundario = mysqli_real_escape_string($con,$_POST["alu_titulosecundario"]);
$alu_tituloterciario = mysqli_real_escape_string($con,$_POST["alu_tituloterciario"]);
$alu_email = mysqli_real_escape_string($con,$_POST["alu_email"]);
$alu_telefono = mysqli_real_escape_string($con,$_POST["alu_telefono"]);
$alu_celular = mysqli_real_escape_string($con,$_POST["alu_celular"]);

$modificar =  consulta($con,"UPDATE alumno SET alu_nombre = '$alu_nombre', alu_apellido = '$alu_apellido', alu_dni = '$alu_dni',
	alu_fechanacimiento = '$alu_fechanacimiento', alu_domicilio = '$alu_domicilio', alu_colegioegresado = '$alu_colegioegresado',
	alu_titulosecundario = '$alu_titulosecundario',alu_tituloterciario = '$alu_tituloterciario',
	alu_email = '$alu_email',alu_telefono = '$alu_telefono', alu_celular = '$alu_celular' where alu_id = '$alu_id'"); 


echo '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert">&times;</a>Los datos se actualizaron con exito!</div>';
?>
