<?php 
	include 'inc/header.template.php';
	include 'bd.php';
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<p>logo y elemento por aqui</p>
			</div>
			<div class="col-md-4">Aqui los datos del usuario online</div>
		</div>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"><h1>Gestion</h1></div>
				<div class="panel-body">
					
						<div class="col-md-6">
							<div id="btn-gestionA" class="well btn-gestion" style="background-color:#58ACFA;"><a href="#"><span class="glyphicon glyphicon-book"></span> Alumnos</a></div>
							<div id="opcionesA" class="input-group" style="display:none" >
								<form role="form"  id="formulario-busqueda" >
									<div class="btn-group" data-toggle="buttons">
									    <label class="btn btn-primary">
									        <input type="radio"   name="criterio" id="criterio" value="dni" checked="checked">D.N.I
									    </label>
									    <label class="btn btn-primary">
									        <input type="radio" name="criterio" id="criterio" value="lu">L.U
									    </label>
									    <label class="btn btn-primary">
									        <input type="radio" name="criterio" id="criterio" value="nomAp">Apellido
									    </label>
									</div>
																		
									<div class="input-group">
								      <input type="text" class="form-control" name="buscar" id="buscar">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" name="btn-buscar" id="btn-buscar"><span class="glyphicon glyphicon-search"></span> Buscar</button>
								      </span>
							    	</div>
								</form>
								<!-- se muestra el resultado de la busqueda -->
									<div class="row"  id="resultado">
										
									</div>
								<!-- fin de los resultados -->	
								
							    	<div id="inscribir" class="row">
									<button type="button" class="btn btn-primary btn-lg" id="btn-inscribir-nuevo"><span class="glyphicon glyphicon-plus"></span> Inscribir nuevo alumno</button>
										<!-- formulario de inscripcion -->
										<div class="row"  id="formulario-registro" style="display:none">
											<h3>Nombre</h3><input type="text" name="nombre" id="nombre" class="form-control">
											<h3>Apellido</h3><input type="text" name="apellido" id="apellido" class="form-control">
											<h3>D.N.I</h3><input type="text" name="dni" id="dni" class="form-control">
											<h3>Domicilio</h3><input type="text" name="domicilio" id="domicilio" class="form-control">
											<h3>Colegio donde egreso</h3><input type="text" name="colegio" id="colegio" class="form-control">
											<h3>Titulo Obtenido</h3><input type="text" name="titulo" id="titulo" class="form-control">
											<h3>Titulo Terciario</h3><input type="text" name="tituloTerciario" id="tituloTerciario" class="form-control">
											<h3>E-mail</h3><input type="email" name="email" id="email" class="form-control">
											<h3>Telefono</h3><input type="text" name="telefono" id="telefono" class="form-control">
											<h3>Celular</h3><input type="text" name="celular" id="celular" class="form-control">
											<h3>Facultad</h3><select name="facultad" id="facultad" class="form-control">
												<option selected="selected" value="0" >Seleccione una Facultad</option>
												<?PHP
													//cargamos el combobox de carreras
													 $con = conexion('localhost','uasal','root','');
													 $resultado = consulta($con,'Select fac_id, fac_nombre from facultad');

														while ($row = mysqli_fetch_array($resultado)) {
															$row["fac_nombre"] = mb_convert_encoding($row["fac_nombre"], 'UTF-8');
															echo '<option value="'.$row["fac_id"] .'">' .$row["fac_nombre"] . '</option>';
														}
												 ?>
											</select>
											<h3>Carrera</h3><select name="carrera" id="carrera" class="form-control">
												<option selected="selected" value="0">Seleccione una Carrera</option>
											</select><br>

											<!-- datos q se ingresan automaticamente
											son libreta universitaria,usuario y contraseña autogenerado,fecha, -->
											<button  class="btn btn-success" id="btn-inscribir">Inscribir</button>
					
										</div>
										
									</div>
									<div class="row" id="resultado-inscripcion"></div>
									
								</div>
								
						
						</div>
						<div class="col-md-6">
							<div id="btn-gestionP" class="well btn-gestion" style="background-color:#58ACFA;"><a href="#"><span class="glyphicon glyphicon-user"></span> Personal</a></div>
						</div>
						<div id="opcionesP" style="display:none" >Aca texto oculto</div>
					
				</div>
			</div>	
		</div>
	</div>
		<script>
		$(document).ready(
			//traer resultados de la busqueda mediante ajax----------------------------------------------------------
			$("#btn-buscar").click(function(){
				
					$.ajax({				/* selecciona el valor del radio buton seleccionado */
						data : {criterio: $('[name="criterio"]:checked').attr('value'), buscar : $("#buscar").val()},
						url : 'buscar.php',
						type : 'post',
						beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
		                },
		                success:  function (response) {
		                        $("#resultado").html(response);
		                }

					});
				})
			
			);
		//-----------------------registrar alumno-------------------------------------------------------------------
		$(document).ready(
			
			$("#btn-inscribir").click(function(){
					$.ajax({				
						data : {nombre:$("#nombre").val(),apellido:$("#apellido").val(),dni:$("#dni").val(),domicilio:$("#domicilio").val(),
						colegio:$("#colegio").val(),titulo:$("#titulo").val(),tituloTerciario:$("#tituloTerciario").val(),
						email:$("#email").val(),telefono:$("#telefono").val(),celular:$("#celular").val(),carrera:$("#carrera").val()},
						url : 'registrar-alumno.php',
						type : 'post',
						beforeSend: function () {
                        $("#resultado-inscripcion").html("Procesando, espere por favor...");
		                },
		                success:  function (response) {
		                        $("#resultado-inscripcion").html(response);
		                        $("#formulario-registro").toggle("slow");
		                }

					});
				})
			
			);
		//cargar lista de carreras por facultad-----------------------------------------------------------------------
		$(document).ready(
		$("#facultad").change(function(){
			var combo = $(this).attr("name");
			var indice = $(this).val();
			if (combo == "carrera" && indice == 0) 
				{
				$("#carrera").html('<option selected="selected" value="0">Seleccione una carrera</option>');
				}
				else
					{
						$("#carrera").html('<option selected="selected" value="0">Cargando...</option>');
							if (indice != 0) 
							{
								$.post("cargar_combo_carreras.php",{id:$(this).val()},function(data){
								$("#carrera").html(data);
								});
							}
					}
			})
		);
		//--------------fin de carga de carreas------------------------------------------------------
			//oculta y muestra las opciones al precionar el boton de alumnos en la pagina de gestion
			$("#btn-gestionA").click(function()
				{	//muestra las opciones para alumnos
					$("#opcionesA").toggle("slow");
					$("#opcionesP").hide("slow");

					});
			$("#btn-gestionP").click(function()
					{
					$("#opcionesP").toggle("slow");
					$("#opcionesA").hide("slow");
				});
			//-----------------------fin de manejo de secciones----------------------------------------		

			//-----------------------------Ocultar los campos de registro---------------------
			$("#btn-inscribir-nuevo").click(
				function(){
					$("#formulario-registro").toggle("slow");
				});

			//--------------------------------------------------------------------------------
			
		</script>
							
</body>
</html>
