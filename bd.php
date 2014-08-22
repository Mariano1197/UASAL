<?PHP
/* Conexion a la base de datos
y funciones para manejo de las consultas */


function conexion ($host,$bd,$usuario,$password){

	//realiza la conexion  a la BD con los parametros que recibe
	$con = mysql_connect($host,$usuario,$password) or die ('Error al conectar' . mysql_error());


	//borar esto es solo para probar

	echo "Conexion exitosa <br>";

	//seleccionar la base de datos
	 mysql_select_db($bd) or die ('Error al seleccionar la base de datos');

	 return $con;
}


function consulta($query) {

	$resul = mysql_query($query) or die("error en la consulta " . mysql_error());


	return $resul;
	mysql_close();
}






?>
