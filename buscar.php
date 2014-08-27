<?PHP
//Modulo destinado a buscar alumnos y personal de uasal
//http://www.w3schools.com/php/php_form_validation.asp

include 'bd.php';

function validar($data) {
  //$data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//validar campos y usar swich para los radio buttons
	$con = conexion('localhost','uasal','root','');
	$alumno = mysqli_real_escape_string($con,$_POST["buscar"]);

//segun el criterio de busqueda varia la consulta 
	if (!empty($_POST['criterio'])) {
		switch ($_POST['criterio']) {
			case 'dni':
				//busco por dni
				$resultado = consulta($con,"SELECT alu_nombre,alu_apellido,alu_fecing,alu_email,car_nombre,fac_nombre, alu_estado FROM `alumno`as A inner join alumno_x_carrera X on A.alu_id = X.alu_id 
					inner join carrera as C on X.car_id = C.car_id inner join facultad as F on C.fac_id = F.fac_id where A.alu_dni = '$alumno'");
				//traigo todos los datos del alumno buscado para modificarlos
				$datos_alumno = consulta($con,"SELECT * FROM alumno where alu_dni = '$alumno' ");
				break;
			
			case 'lu':
				//busco por libreta universitaria
				$resultado = consulta($con,"SELECT alu_nombre,alu_apellido,alu_fecing,alu_email,car_nombre,fac_nombre, alu_estado FROM `alumno`as A inner join alumno_x_carrera X on A.alu_id = X.alu_id 
					inner join carrera as C on X.car_id = C.car_id inner join facultad as F on C.fac_id = F.fac_id where A.alu_libretauniv = '$alumno'");
				//traigo todos los datos del alumno buscado para modificarlos
				$datos_alumno = consulta($con,"SELECT * FROM alumno where alu_libretauniv = '$alumno' ");
				break;

			case 'nomAp':
				//busco por apellido
				$resultado = consulta($con,"SELECT alu_nombre,alu_apellido,alu_fecing,alu_email,car_nombre,fac_nombre, alu_estado FROM `alumno`as A inner join alumno_x_carrera X on A.alu_id = X.alu_id 
					inner join carrera as C on X.car_id = C.car_id inner join facultad as F on C.fac_id = F.fac_id where alu_apellido like '$alumno'");
				//traigo todos los datos del alumno buscado para modificarlos
				$datos_alumno = consulta($con,"SELECT * FROM alumno where alu_apellido like '$alumno' ");
				break;

		}

	}
}		
		
	

//comprueba que existan resultados para la busqueda y los muestra

if (!mysqli_num_rows($resultado) > 0) {
	
	echo '<br><div class="panel panel-danger"><div class="panel-heading"><span class="glyphicon glyphicon-remove"></span> Error</div>
  	<div class="panel-body">No se encontro ningun alumno.</div>';
}

//funcion que determina si el usuario esta activo o inactivo
function estado($nro){
	if ($nro == 1 ) {
		return "Activo";
	}else{
		return "Inactivo";
	}
}


while ($row = mysqli_fetch_array($resultado)) {

	echo  '<br><div class="panel panel-success" id="usuario">
			<div class="panel-heading">'.mb_convert_encoding( $row["fac_nombre"] , 'UTF-8').'</div>
 			 <div class="panel-body">	
				  <div class="col-xs-6 col-md-4">	    
				      <img src="img/default.jpg" class="img-thumbnail" alt="Imagen de perfil" />	    
				  </div>	 
				  <div class="col-md-8">
				  	<div class="row"><b>Alumno</b>: '. mb_convert_encoding( $row["alu_nombre"] , 'UTF-8') .", " . mb_convert_encoding( $row["alu_apellido"] , 'UTF-8')  .'<br>
					<b>Carrera: </b>'. mb_convert_encoding($row["car_nombre"] , 'UTF-8') . '<br>
					<b>Ingreso: </b> '. mb_convert_encoding($row["alu_fecing"], 'UTF-8') .
					'<br><b>Estado: </b> '. estado($row["alu_estado"]) .
				   '<br></div>
					  <div class="row">
					  	<button class="btn btn-success" id="btn-mod">
							<span class="glyphicon glyphicon-pencil"></span> Modificar
						</button> ';
						

						//controlo si el alumno esta inactivo desactivo el boton de baja y activo uno de alta
						if ($row["alu_estado"] == 1) {
								echo '<button class="btn btn-danger" id="btn-baja">
						  				<span class="glyphicon glyphicon-minus-sign"></span> Baja
									  </button> ';
							}else{
								echo '<button class="btn btn-primary" id="btn-alta">
						  				<span class="glyphicon glyphicon-ok"></span> Alta
									</button> ';
							}

					  echo '</div>
					  <!-- ocultar div modificar-->
						<div class="row" id="modificar" style="display:none">';
						//recorre el resultado imprimiendo los controles con los valores que trae de la tabla alumno
						while ($row= mysqli_fetch_array($datos_alumno)) {

						echo 	'<input type="hidden" name="alu_id" id="alu_id" value="'.$row["alu_id"].'">';	
						echo	'<h3>Nombre</h3><input type="text" name="m-nombre" id="m-nombre" class="form-control" value="'.$row["alu_nombre"].'">';
						echo	'<h3>Apellido</h3><input type="text" name="m-apellido" id="m-apellido" class="form-control" value="'.$row["alu_apellido"].'">';
						echo	'<h3>D.N.I</h3><input type="text" name="m-dni" id="m-dni" class="form-control" value="'.$row["alu_dni"].'">';
						echo	'<h3>Fecha de nacimiento</h3><input type="text" name="m-fechanac" id="m-fechanac" class="form-control" value="'.$row["alu_fechanacimiento"].'">';
						echo	'<h3>Domicilio</h3><input type="text" name="m-domicilio" id="m-domicilio" class="form-control" value="'.$row["alu_domicilio"].'">';
						echo	'<h3>Colegio donde egreso</h3><input type="text" name="m-colegio" id="m-colegio" class="form-control" value="'.$row["alu_colegioegresado"].'">';
						echo	'<h3>Titulo Obtenido</h3><input type="text" name="m-titulosecu" id="m-titulosecu" class="form-control" value="'.$row["alu_titulosecundario"].'">';
						echo	'<h3>Titulo Terciario</h3><input type="text" name="m-tituloter" id="m-tituloter" class="form-control" value="'.$row["alu_tituloterciario"].'">';
						echo	'<h3>E-mail</h3><input type="text" name="m-email" id="m-email" class="form-control" value="'.$row["alu_email"].'">';
						echo	'<h3>Telefono</h3><input type="text" name="m-telefono" id="m-telefono" class="form-control" value="'.$row["alu_telefono"].'">';
						echo	'<h3>Celular</h3><input type="text" name="m-celular" id="m-celular" class="form-control" value="'.$row["alu_celular"].'">';
						echo    '<button class="btn btn-success" id="btn-modificar"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>';
						echo 	'<button class="btn btn-danger" id="btn-cancelar-modificacion"><span class="glyphicon glyphicon-remove-circle"></span> Cancelar</button>';
						
						
						
						}
					// imprime la funcion de ajax para mostrar el resultado de la modificacion en el div de resultado-modificacion	
					echo	'</div>
					<div class="row" id="resultado-modificacion" style="display:none">El resutlado</div>
				   </div>
				<!-- guardar cambios -->
				<script>
					$(document).ready(
						
						$("#btn-modificar").click(function(){
							$("#modificar").toggle();
								$.ajax({				
									data : {alu_id: $("#alu_id").val(),alu_nombre:$("#m-nombre").val(),alu_apellido: $("#m-apellido").val(),
									alu_dni:$("#m-dni").val(),alu_fechanacimiento:$("#m-fechanac").val(),
									alu_domicilio:$("#m-domicilio").val(),alu_colegioegresado:$("#m-colegio").val(),
									alu_titulosecundario:$("#m-titulosecu").val(),alu_tituloterciario:$("#m-tituloter").val(),
									alu_email:$("#m-email").val(),alu_telefono:$("#m-telefono").val(),
									alu_celular:$("#m-celular").val()
									},
									url : '."'modificar.php'".',
									type : '."'post'".',
									beforeSend: function () {
			                        $("#resultado-modificacion").html("Procesando, espere por favor...");
					                },
					                success:  function (response) {
					                		
					                		
					                        $("#resultado-modificacion").html(response);					                        
					                        $("#resultado-modificacion").toggle("slow");

					                }

								});
							})
					
					);
				</script>
				<script>
				// muestra los campos para modificar los datos cuando se presiona el boton modificar
				$("#btn-mod").click(function(){
					$("#modificar").toggle("slow");
				});
				//--------------------fin manejo de campos---------------------------------------------

				//da de baja al alumno-----------------------------------------------------------------
				$("#btn-baja").click(function(){
					bootbox.confirm("Esta seguro que desea dar de baja?", function(result) {
					  if (result == true) {
					  	$.ajax({data:{alu_id: $("#alu_id").val(),estado:"0"},
					  			url:'."'baja.php'".',
					  			type : '."'post'".',
					  			beforeSend: function(){
									$("#resultado-modificacion").html("Procesando, espere por favor...");
					  			},
					  			success: function(response){

										$("#resultado-modificacion").html(response);
										$("#resultado-modificacion").toggle("slow");


					  				}
					  			});
					  	}
					}); 
				});

				//---------------Alta de un alumno existente -----------------------------------------
				$("#btn-alta").click(function(){
					bootbox.confirm("Esta seguro que desea dar de alta?", function(result) {
					  if (result == true) {
					  	$.ajax({data:{alu_id: $("#alu_id").val(),estado:"1"},
					  			url:'."'baja.php'".',
					  			type : '."'post'".',
					  			beforeSend: function(){
									$("#resultado-modificacion").html("Procesando, espere por favor...");
					  			},
					  			success: function(response){

										$("#resultado-modificacion").html(response);
										$("#resultado-modificacion").toggle("slow");
										
										

					  				}
					  			});
					  	}
					}); 
				});
				//--------------------------fin de alta de alumno existente---------------------------
				
				//--------------- fin de baja---------------------------------------------------------
	
				//oculta los controles cuando se cancela la modificacion
				$("#btn-cancelar-modificacion").click(function(){
					$("#modificar").hide("slow");
				});
				//------------------------- fin controles --------------------------------------------
				</script>
				<!-- fin de cambios -->
				<!-- fin-body-panel-->
				
			</div>		  
		</div>';

	
}



?>
