<?php

	session_start();

	if (empty($_SESSION['Nombre']) && empty($_SESSION['IDp']) && $_SESSION['Acceso'] != 'Yes_wey'){

		header("location:../");

	}



	require_once('../ajax/database.php');

	require_once('../class/class_procesos.php');

	require_once('../config/head.php');





	//*** BUSCAR CLIENTES

	$BuscarClientes="SELECT fld_id, fld_nombre FROM tbl_clientes WHERE fld_IDempresa=? ORDER BY fld_nombre ASC";

	$cmdClientes= Database::getInstance()->getDb()->prepare($BuscarClientes);

	$cmdClientes->execute(array($_SESSION['IDe']));

	$rowClientes=$cmdClientes->fetchAll();

	$NumClientes=$cmdClientes->rowCount();





	//Buscar Tipo de areas

	

?>

<!DOCTYPE html>

<html>

    <head>

        <title>Entrega Alimentos</title>

        <link href="../css/application.min.css" rel="stylesheet">

        <link href="../css/style.css" rel="stylesheet">

        <link href="../bower_components/fontawesome/css/all.css" rel="stylesheet">

        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->

        <!--[if IE 9]>

        <link href="css/application-ie9-part2.css" rel="stylesheet">

        <![endif]-->

        <link rel="shortcut icon" href="../img/favicon.png">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <meta name="description" content="Grama 7.0">

        <meta name="keywords" content="admin,dashboard,bootstrap,template,react,angular,vue,html,css,javascript">

        <meta name="author" content="Grama 7.0">

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <script>

            /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix

            chrome fix https://code.google.com/p/chromium/issues/detail?id=167083

            https://code.google.com/p/chromium/issues/detail?id=332189

            */

        </script>

        <script src="../js/charts/d3-version-wrapper.js"></script>

   		  <style>
			@media (min-width: 992px){
			.modal-lg {
				max-width: 940px;
				}
			}
		</style>
    </head>

    <body class="">

       

        <!-- MENU -->

       	<?php require_once('../config/menu.php'); ?>

       <!-- END MENU -->   



        <div class="content-wrap">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="content" role="main">

                <!-- Page content -->



       			<h1 class="page-title"><i class="fi flaticon-archive-3"></i> Entrega <span class="fw-semi-bold">Alimentos</span></h1>

       			

       			<div class="cargando" style="display: none;">

       				<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span id="Mensaje_load"></span>

       			</div>

       			



       		<!-- Contenido -->

			<div class="row mt-lg">

				<div class="col-md-12 col-sm-12">

					<section class="widget">

					

						<header>

							<ul class="nav nav-tabs" id="myTab" role="tablist">

							  <li class="nav-item">
								<a class="nav-link active" id="Tafiliar-tab" data-toggle="tab" href="#Tafiliar" role="tab" aria-controls="Tafiliar" aria-selected="true"><i class="fas fa-utensils"></i> Entrega</a>
							  </li>

							  <li class="nav-item">
								<a class="nav-link " id="Tlistado-tab" data-toggle="tab" href="#Tlistado" role="tab" aria-controls="Tlistado" aria-selected="false"><i class="fas fa-search"></i> Consultar</a>
							  </li>

							  <li class="nav-item">
								<a class="nav-link " id="Talimento-tab" data-toggle="tab" href="#Talimento" role="tab" aria-controls="Talimento" aria-selected="false"><i class="fas fa-list-ol"></i> Tipo Alimento</a>
							  </li>
							</ul>

						</header>

						<div class="widget-body">

							

							<div class="tab-content" id="myTabContent">

						  

						  	  <!-- SUBIR CONTENIDO -->

							  <div class="tab-pane fade show active" id="Tafiliar" role="tabpanel" aria-labelledby="Tafiliar-tab">

							  	

							  	<div class="row" id="MensajeExito" style="display: none;">

							  		<div class="col-md-6 offset-3">

							  			<div class="alert alert-success" role="alert">

											<h4 class="alert-heading">Genial!</h4>

											<p><i class="fas fa-user-check fa-2x"></i> La entrega del alimento fue guardado con éxito.</p>

											<span id="Mesaje_SRV"></span>

											<hr>

											<p class="mb-0">Para realizar otro haga clic <button type="button" class="btn btn-outline-primary btn-rounded-f width-100 mb-xs" onClick="Otro()">aquí</button></p>

										</div>

							  		</div>

							  	</div>

							  	

                    

							  	<form role="form" id="Datos_Gestion" method="POST" enctype="multipart/form-data">

									<fieldset>

										<div class="row">

										

										<!--- DATOS PERSONA -->

										<legend class="mb-5"><i class="fas fa-user fa-2x text-primary"></i> <strong>Datos</strong> persona <i class="fa fa-spinner fa-pulse fa-3x fa-fw cargar-search" style="display: none;"></i></legend>

										<div class="col-md-4 form-group">
										   <label for="identificacion"><i class="fas fa-id-card"></i> Identificación</label> 
										   <input type="number" id="identificacion" name="identificacion" class="form-control" onchange="ConsultarCedula()">
										   <input type="hidden" name="IDpersona" id="IDpersona" value="0">
										</div>

										<div class="col-md-8 form-group">
											<label for="Pnombre"><i class="far fa-user"></i> Nombre Completo</label>
											<input type="text" id="nombre" name="nombre" class="form-control form-disabled-datos" onchange="javascript:this.value=this.value.toUpperCase()" disabled="true">
										</div>

										<!-- Fotografia de la cedula -->
										<?php /*
										<div class="col-md-6 form-group text-center captura-cedula" style="display: none;">
											<div class="fileinput fileinput-new" data-provides="fileinput">

												<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
													<img alt="..." src="../img/avatar.png" class="cc-img1">
												</div>

												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>

												<div>
													<span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Foto</span><span class="fileinput-exists"><i class="fas fa-exchange-alt text-success"></i> Cambiar</span><input type="file" name="cc1" id="cc1" accept="image/*"></span>
													<a href="javascript:void(0)" class="btn btn-default btn-canc fileinput-exists" data-dismiss="fileinput"><i class="fas fa-times text-warning"></i> Cancelar</a>
												</div>

											</div>
											<h5><span class="text-warning">*</span> Por favor, tomar fotografia de la cedula parte <b>FRONTAL</b></h5>
										</div>

										<div class="col-md-6 form-group text-center captura-cedula" style="display: none;">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
													<img alt="..." src="../img/avatar.png" class="cc-img2">
												</div>
												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
												<div>
													<span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Foto</span><span class="fileinput-exists"><i class="fas fa-exchange-alt text-success"></i> Cambiar</span><input type="file" name="cc2" id="cc2" accept="image/*"></span>
													<a href="javascript:void(0)" class="btn btn-default btn-canc fileinput-exists" data-dismiss="fileinput"><i class="fas fa-times text-warning"></i> Cancelar</a>
												</div>
											</div>
											<h5><span class="text-warning">*</span> Por favor, tomar fotografia de la cedula parte <b>TRASERA</b></h5>
										</div>
										<?php */ ?>
										<!-- End fotografia de la cedula -->


										<div class="col-md-4 form-group">
										   <label for="identificacion"><i class="fas fa-list-ul"></i> Tipo Alimento</label> 
										   <select id="Atipo" name="Atipo" class="form-control">
										   		<option value="">[ Seleccionar ]</option>
										   </select>
										</div>

										<div class="col-md-8 form-group">
											<label for="identificacion"><i class="fas fa-file-alt"></i> Soporte Entrega</label><br>
											<input type="file" name="soporte" id="soporte" accept="image/*">
										</div>



										<!-- OBSERVACIONES-->

										<legend class="mb-5"><i class="fas fa-comment-dots fa-2x text-primary"></i> <strong>Observación</strong> Entrega</legend>


										<div class="col-md-12 form-group">
											<label for="Pobservaciones">Observaciones</label>
											<textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
										</div>



									</div> <!-- End row -->

                                        

									</fieldset>

									<div class="form-actions text-center">

										<input type="hidden" id="IDacceso" name="IDacceso" value="<?php echo $_SESSION['IDp']; ?>">

										<input type="hidden" id="IDempresa" name="IDempresa" value="<?php echo $_SESSION['IDe']; ?>">

										<button type="button" class="btn btn-success btn-lg" onClick="Guardar()">Proceder la entrega <i class="fas fa-check"></i></button>

									</div>

								</form>

							  	

							  </div>

							  <!--*************** END ************-->


							 <!--  CONTENIDO LISTADO -->

							<div class="tab-pane fade" id="Tlistado" role="tabpanel" aria-labelledby="Tlistado-tab">

							 	
								<i class="fa fa-refresh fa-spin fa-3x fa-fw load"></i>
							 	
		
							 	<legend>
									<div class="row mb-3">
							 	

							 		<div class="col-md-4">

							 			<label>Buscar</label>

							 			<input type="text" id="Buradicado" class="form-control" placeholder="..." onKeyUp="load(1)">

							 		</div>

									<div class="col-md-4 mt-2">
										<label>Fecha Inicial</label>
										<input type="date" id="BfechaI" class="form-control">
									</div>

									<div class="col-md-4 mt-2">
										<label>Fecha Final</label>
										<input type="date" id="BfechaF" class="form-control" >
									</div>

									<div class="col-md-4 ">

										<label>Personas</label>

										<select id="Bcliente" class="form-control">

											<?php

												if($NumClientes>0){
													$Option='<option value="">[ TODOS ]</option>';
													foreach($rowClientes as $row){
														$Option.='<option value="'.$row[0].'">'.$row[1].'</option>';
													}
												}else{
													$Option='<option value="">No hay registros</option>';
												}	
												echo $Option;
											?>
										</select>
									</div>

									<div class="col-md-1 pt-4 mt-3"> 

										<button class="btn btn-success" onClick="load(1)" id="BotonBus"><i class="fa fa-search"></i> Buscar</button>

									</div>

									<!--<div class="col-md-12 text-right mt-3">

										<button type="button" class="btn btn-success" onClick="DescargarListado()";>Descargar Listado <i class="far fa-file-excel"></i></button>

									</div>-->

									</div>

								</legend>

						 	

							 	

							 	<div class="row mb-3" id="Listado-Principal">

							 	<div class="table-responsive">

									<table class="table table-hover table-contenido" id="TableDatos">

										<thead style="font-size:11px;" class="bg-primary text-white">
										<tr>
											<th class="th-0">#</th>
											<th class="text-left"><i class="fas fa-address-card"></i> Identificación</th>
											<th class="th-1 text-left"><i class="fas fa-user"></i> Persona</th>
											<th class="th-1 text-left">Entrega</th>
											<th class="th-1 text-center">Soporte</th>
											<th class="text-left"><i class="fas fa-briefcase"></i> Observacación</th>
											<th class="text-center"> Usuario Entrega</th>
											<th class="th-fecha"><i class="far fa-calendar-check"></i> Fecha Registro</th>
											<th class="text-center th-opcion"><i class="fas fa-cogs"></i> Opciones</th>
										</tr>
										</thead>

										<tbody>

										</tbody>

									</table>

								</div><!-- End table-->
								
								</div><!-- END ROW-->
								


							  </div>
							  <!-- -************** END CONTENIDO LISTADO ************-->

							  <!-- ***** CONTENIDO TIPO ALIMENTO ***** -->

							<div class="tab-pane fade" id="Talimento" role="tabpanel" aria-labelledby="Talimento-tab">

								<i class="fa fa-refresh fa-spin fa-3x fa-fw load"></i>
							 	
							 	<legend>
									<div class="row mb-3">
							 		<div class="col-md-4">
							 			<label>Buscar</label>
							 			<input type="text" id="Btipo" class="form-control" placeholder="..." onKeyUp="categoria(1)">
							 		</div>

							 		<div class="col-md-8 text-right pt-3">
							 			<button type="button" class="btn btn-primary" onclick="Agregar()"><i class="fas fa-plus-circle"></i> Agregar</button>
									</div>

									</div>
								</legend>

						 	

							 	<div class="row mb-3">

							 	<div class="table-responsive">

									<table class="table table-hover table-contenido" id="TableCategoria">

										<thead style="font-size:11px;" class="bg-warning text-black">
										<tr>
											<th class="th-0">#</th>
											<th class="text-left"><i class="fas fa-address-card"></i> Nombre</th>
											<th class="th-fecha"><i class="far fa-calendar-check"></i> Fecha Registro</th>
											<th class="text-center th-opcion"><i class="fas fa-cogs"></i> Opciones</th>
										</tr>
										</thead>

										<tbody>

										</tbody>

									</table>

								</div><!-- End table-->
								
								</div><!-- END ROW-->
								


							  </div>
							  <!-- ***** END CONTENIDO TIPO ALIMENTO **** -->

							</div><!-- End contenido-->

					
						</div><!-- End Body-->

					</section>

				</div><!-- End col-->

				

			</div><!-- End Row -->

        

       

       <!-- End contenido-->

       

        <?php

			require_once('../config/footer.php');

		?>

            </main>

        </div>

        <!-- The Loader. Is shown when pjax happens -->

        <div class="loader-wrap hiding hide">

            <i class="fa fa-circle-o-notch fa-spin-fast"></i>

        </div>

        

        <!-- MODAL ELIMINAR -->
        <div class="modal fade" id="ModalElimnar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-dialog-centered">

				<div class="modal-content">

					<div class="modal-header bg-warning text-white">

						<h5 class="modal-title"><i class="fas fa-exclamation-triangle fa-2x"></i> MENSAJE DE CONFIRMACIÓN</h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true">&times;</span>

						</button>

					</div>

					<div class="modal-body text-center">

						<h4>Realmente estas seguro de eliminar este registro ?</h4>

						<p>Recuerde que una vez eliminado no podrá recuperar la información que contiene este registro.</p>

						<input type="hidden" id="ModalIdp" value="">

					</div>

					<div class="modal-footer">

						<i class="fa fa-spinner fa-pulse fa-3x fa-fw cargar" style="display: none;"></i>

						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

						<span id="BotonEliminar"></span>
						

					</div>

				</div>

			</div>
		</div>
        <!-- END MODAL ELIMINAR -->

        <!-- MODAL AGREGAR TIPO ALIMENTO-->
        <div class="modal fade" id="ModalCategoria" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-dialog-centered">

				<div class="modal-content">

					<div class="modal-header bg-primary text-white">

						<h5 class="modal-title" id="TitleModalCategoria"></h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true">&times;</span>

						</button>

					</div>

					<div class="modal-body">

						<form id="FormModalCategoria">

						<!-- CONTENIDO CREAR -->
						<div class="row">

							<div class="col-md-12 form-group">
								<label for="normal-field" class="pt-2 form-control-label text-md-left"> <i class="fas fa-user"></i> Nombre</label>
								<input type="text" id="Mcategoria" name="Mcategoria" class="form-control" onchange="javascript:this.value=this.value.toUpperCase()">
							</div>

						</div>

						<input type="hidden" id="IDcategoria" name="IDcategoria">

						</form>

					</div>

					<div class="modal-footer">

						<i class="fa fa-spinner fa-pulse fa-3x fa-fw cargar" style="display: none;"></i>

						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

						<span id="ModalBotonCategoria"></span>

					</div>

				</div>

			</div>
		</div>
		<!-- END MODAL TIPO ALIMENTO -->



        <!-- common libraries. required for every page-->

        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <script src="../bower_components/jquery-pjax/jquery.pjax.js"></script>

        <script src="../bower_components/popper.js/dist/umd/popper.js"></script>

        <script src="../bower_components/bootstrap/dist/js/bootstrap.js"></script>

        <script src="../bower_components/bootstrap/js/dist/util.js"></script>

        <script src="../bower_components/slimScroll/jquery.slimscroll.js"></script>

        <script src="../bower_components/widgster/widgster.js"></script>

        <script src="../bower_components/pace.js/pace.js" data-pace-options='{ "target": ".content-wrap", "ghostTime": 1000 }'></script>

        <script src="../bower_components/hammerjs/hammer.js"></script>

        <script src="../bower_components/jquery-hammerjs/jquery.hammer.js"></script>





        <!-- common app js -->

        <script src="../js/settings.js"></script>

        <script src="../js/app.js"></script>

        <script src="../js/admin.js"></script>

        

        

         <!-- Page scripts -->

        <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

        <script src="../bower_components/jquery-autosize/jquery.autosize.min.js"></script>

        <script src="../bower_components/bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.min.js"></script>

        <script src="../bower_components/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js"></script>

        <script src="../bower_components/select2/dist/js/select2.min.js"></script>

        <script src="../bower_components/switchery/dist/switchery.min.js"></script>

        <script src="../bower_components/moment/min/moment.min.js"></script>

        <script src="../bower_components/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js"></script>

        <script src="../bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

        <script src="../bower_components/jasny-bootstrap/js/inputmask.js"></script>

        <script src="../bower_components/jasny-bootstrap/js/fileinput.js"></script>

        <script src="../bower_components/holderjs/holder.js"></script>

        <script src="../bower_components/dropzone/dist/min/dropzone.min.js"></script>

        <script src="../bower_components/markdown/lib/markdown.js"></script>

        <script src="../bower_components/bootstrap-markdown/js/bootstrap-markdown.js"></script>

        <script src="../bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>

        

       

       <!-- LLamamos los idiomas del calendario -->

        <script src="../bower_components/moment/min/locales.js"></script>

        

        

          <!-- Page scripts -->

        <script src="../bower_components/underscore/underscore-min.js"></script>

        <script src="../bower_components/backbone/backbone.js"></script>

        <script src="../bower_components/messenger/build/js/messenger.js"></script>

        <script src="../bower_components/messenger/build/js/messenger-theme-flat.js"></script>

        <script src="../bower_components/messenger/docs/welcome/javascripts/location-sel.js"></script>

        <script src="../js/components/ui-notifications.js"></script>

        





        <!-- Page scripts -->

        <script>
	

		$(function(){

			$('.widget').widgster();

			function pageLoad(){

				load(1);
				categoria(1);
				BuscarCategoria();

				$('.widget').widgster();

				$("#Bcliente").change(function(){
					load(1);
				});

			}

			SingApp.onPageLoad(pageLoad);
			pageLoad();
		});

	
		//*** FUNCION BUSCAR IDENTIFICACION
		function ConsultarCedula(){
			var cc=$("#identificacion").val();
			var IDempresa=$("#IDempresa").val();

			if(cc==''){
				$("#nombre").attr('disabled',true).val('').addClass('form-disabled-datos');
				$("#IDpersona").val('0');
				$(".captura-cedula").hide();
			}else{

				$.ajax({
					type:'POST',
					url:'../ajax/procesos.php',
					data:{action:'BuscarCedula',cc:cc,IDempresa:IDempresa},
					beforeSend:function(){
						$(".cargar-search").show();
					},
					success:function(data){
						$(data).each(function(){
							if(data.estado==1){

								if(data.datos.Validacion=='OK'){

									if(data.datos.Cantidad>0){

										var valores=eval(data.datos.Row);

										$("#IDpersona").val(valores[0]);
										$("#nombre").attr('disabled',true).val(valores[1]).addClass('form-disabled-datos');
										$(".captura-cedula").hide();

									}else{
										$("#IDpersona").val('0');
										$("#nombre").attr('disabled',false).val('').focus().removeClass('form-disabled-datos');
										$(".captura-cedula").show();
										Messenger().post({
											message: 'Persona no encontrada, ingrese su nombre.',
											type: 'error',
											showCloseButton: true
										});
									}

								}else{
									$("#IDpersona").val('0');
									$("#nombre").attr('disabled',true).val('').addClass('form-disabled-datos');
									$(".captura-cedula").hide();
									Messenger().post({
										message: data.datos.Mensaje,
										type: 'error',
										showCloseButton: true
									});
								}

							}else{
								$("#IDpersona").val('0');
								$("#nombre").attr('disabled',true).val('').addClass('form-disabled-datos');
								$(".captura-cedula").hide();
								Messenger().post({
									message: data.mensaje,
									type: 'error',
									showCloseButton: true
								});
							}

						});

						$(".cargar-search").fadeOut(1000);

					},
					error:function(jqXHR, exception){

						var msg = '';
			              if (jqXHR.status === 0) {
			                msg = 'Verificar su estado de internet';
			              } else if (jqXHR.status == 404) {
			                msg = 'Página solicitada no encontrada. [404]';
			              } else if (jqXHR.status == 500) {
			                msg = 'Error interno del servidor [500].';
			              } else if (exception === 'parsererror') {
			                msg = 'Se solicitó el error de JSON.';
			              } else if (exception === 'timeout') {
			                msg = 'Error de tiempo de espera.';
			              } else if (exception === 'abort') {
			                msg = 'Ajax petición abortada.';
			              } else {
			                msg = 'Error no detectado.\n' + jqXHR.responseText;
			              }
			              $(".cargar-search").fadeOut(1000);
			              $("#IDpersona").val('0');
						$("#nombre").attr('disabled',true).val('').addClass('form-disabled-datos');
						$(".captura-cedula").hide();
			              Messenger().post({
							message: 'Ocurrió un error inesperado, inténtelo mas tarde. '+msg,
							type: 'error',
							showCloseButton: true
						});
					}
				});
			}//End Validacion
		}

		//Funcion Limpiar
		function Otro(){

			var IDacceso=$("#IDacceso").val();
			var IDempresa=$("#IDempresa").val();


			$("#MensajeExito").hide(1000);
			$("#Datos_Gestion")[0].reset();
			$("#Datos_Gestion").show(1000);

			$("#nombre").attr('disabled',true).val('').addClass('form-disabled-datos');
			$(".captura-cedula").hide();
			$("#cc1").val('../img/avatar.png');
			$("#cc2").val('../img/avatar.png');
			$(".btn-canc").click();
			$(".cc-img1").attr('src','');
			$(".cc-img2").attr('src','');

			$("#IDpersona").val('0');
			$("#IDacceso").val(IDacceso);
			$("#IDempresa").val(IDempresa);
			$(".alert-datos").hide();
		}

		//Funcion Guardar los datos
		function Guardar(){

			var IDacceso=$("#IDacceso").val();
			var IDempresa=$("#IDempresa").val();
			var IDpersona=$("#IDpersona").val();

			var cc=$("#identificacion");
			var nombre=$("#nombre");
			var tipo=$("#Atipo");
			var soporte=$("#soporte");
			var observaciones=$("#observaciones").val();
			//var cc1=$("#cc1");
			//var cc2=$("#cc2");

			if(cc.val()==''){
				Messenger().post({
					message: 'Por favor, escriba un número de identificación',
					type: 'error',
					showCloseButton: true
				});
				cc.focus();
				return false;
			}

			if(nombre.val()==''){
				Messenger().post({
					message: 'Por favor, escriba el nombre completo',
					type: 'error',
					showCloseButton: true
				});
				nombre.focus();
				return false;
			}

			if(tipo.val()==''){
				Messenger().post({
					message: 'Por favor, seleccione un tipo de alimento',
					type: 'error',
					showCloseButton: true
				});
				tipo.focus();
				return false;
			}

			if(soporte.val()==''){
				Messenger().post({
					message: 'Por favor, ingrese un soporte',
					type: 'error',
					showCloseButton: true
				});
				soporte.focus();
				return false;
			}

			/*if(IDpersona==0){

				//Imagen Frontal
				if(cc1.val()!=''){
					var extensiones = cc1.val().substring(cc1.val().lastIndexOf("."));

					if(extensiones!= ".jpg" && extensiones != ".png" && extensiones != ".jpeg"){
						Messenger().post({
							message: 'La imagen seleccionada con extension '+extensiones+' no es válido, suba un logo tipo JPG o PNG',
							type: 'error',
							showCloseButton: true
						});
						cc1.focus();
						return false;
					}
				}

				//Imagen Trasera
				if(cc2.val()!=''){
					var extensiones = cc2.val().substring(cc2.val().lastIndexOf("."));

					if(extensiones!= ".jpg" && extensiones != ".png" && extensiones != ".jpeg"){
						Messenger().post({
							message: 'La imagen seleccionada con extension '+extensiones+' no es válido, suba un logo tipo JPG o PNG',
							type: 'error',
							showCloseButton: true
						});
						cc2.focus();
						return false;
					}
				}

			}//End validacion*/

			var archivos = new FormData();
			archivos.append('action','GuardarEntregaAlimento');
			archivos.append('IDacceso',IDacceso);
			archivos.append('IDempresa',IDempresa);
			archivos.append('IDpersona',IDpersona);
			archivos.append('identificacion',cc.val());
			archivos.append('nombre',nombre.val());
			archivos.append('tipo',tipo.val());
			archivos.append('observaciones',observaciones);

			var soporte=document.getElementById("soporte");
			var soporte = soporte.files;
			archivos.append('soporte',soporte[0]);

			//Imagen Frontal
			/*if(IDpersona==0 && cc1.val()!=''){
				var imagen=document.getElementById("cc1");
				var imagen = imagen.files;
				archivos.append('cc1',imagen[0]);
			}else{
				archivos.append('cc1','null');
			}

			//Imagen Frontal
			if(IDpersona==0 && cc2.val()!=''){
				var imagen=document.getElementById("cc2");
				var imagen = imagen.files;
				archivos.append('cc2',imagen[0]);
			}else{
				archivos.append('cc2','null');
			}*/


			$.ajax({
				url: '../ajax/procesos.php',  
				type: 'POST',
				data: archivos,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function(){
					$("#Mensaje_load").html('Guardando ...');
					$(".cargando").show(); 
				},

				success: function(data){	

					$(data).each(function(){

						if(data.estado==1){

							if(data.datos.Validacion=='OK'){
								ExitoTodo();
								load(1);
							}else{
								Messenger().post({
									message: data.datos.Mensaje,
									type: 'error',
									showCloseButton: true
								});
								$(".cargando").fadeOut(1000);
							}

						}else{
							Messenger().post({
								message: data.mensaje,
								type: 'error',
								showCloseButton: true
							});
							$(".cargando").fadeOut(1000);
						}

					});
				},
				error:function(jqXHR, exception){

					var msg = '';
		              if (jqXHR.status === 0) {
		                msg = 'Verificar su estado de internet';
		              } else if (jqXHR.status == 404) {
		                msg = 'Página solicitada no encontrada. [404]';
		              } else if (jqXHR.status == 500) {
		                msg = 'Error interno del servidor [500].';
		              } else if (exception === 'parsererror') {
		                msg = 'Se solicitó el error de JSON.';
		              } else if (exception === 'timeout') {
		                msg = 'Error de tiempo de espera.';
		              } else if (exception === 'abort') {
		                msg = 'Ajax petición abortada.';
		              } else {
		                msg = 'Error no detectado.\n' + jqXHR.responseText;
		              }
		              $(".cargando").fadeOut(1000);
		              Messenger().post({
						message: 'Ocurrió un error inesperado, inténtelo mas tarde. '+msg,
						type: 'error',
						showCloseButton: true
					});
				}
			});

		}//End Funcion	

		function ExitoTodo(){

			$(".cargando").fadeOut(1000);

			$("#MensajeExito").show(1000);

			$("#Datos_Gestion").hide(1000);

		}


		//******************************* FUNCION MOSTRAR LISTADO DE AFILIADOS**********************
		function NuevaFecha(fecha){

			var Mes=['','ENE','FEB','MAR','ABRI','MAY','JUN','JUL','AGO','SEPT','OCT','NOV','DIC'];

			var f=fecha.split('*');
			var Nf=f[0].split('-');

			return Nf[0]+' '+Mes[Nf[1]]+' '+Nf[2]+' - '+f[1];

		}

		function load(page){

			

			var buscar=$("#Buradicado").val();

			var cliente=$("#Bcliente").val();

			var fechaI=$("#BfechaI").val();

			var fechaF=$("#BfechaF").val();



			if(fechaF<fechaI){

				Messenger().post({

					message: 'Rango fecha invalido, fecha final tiene que ser superior fecha inicial',

					type: 'error',

					showCloseButton: true

				});

				$("#BfechaI").focus();

				return false;

			}

			

			$.ajax({
				type:'POST',
				url:'../ajax/procesos.php',
				data:{action:'ListadoEntrega',buscar:buscar,cliente:cliente,fechaI:fechaI,fechaF:fechaF,page:page},
				beforeSend:function(){
					$(".load").show();
				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							if(data.datos.Validacion=='OK'){

								var valores = eval(data.datos.busqueda);

								var table='';



								if(data.datos.cantidad>0){

									var LINK=data.datos.Link;



								for(var i in valores){

									var BtnOpcion='';
						

									<?php if($_SESSION['Tipo']==1){ ?>

									BtnOpcion+='<button type="button" class="btn btn-danger btn-sm mb-xs" onClick="Eliminar('+valores[i].id+')"><i class="far fa-trash-alt"></i></button>';

									<?php }?>
								

									table+='<tr>';

									table+='<td>'+(parseFloat(i)+parseFloat(1))+'</td>';

									table+='<td><b>'+valores[i].cedula+'</b></td>';

									table+='<td><b>'+valores[i].persona+'</b></td>';
									table+='<td><b>'+valores[i].Categoria+'</b></td>';
									if(valores[i].Soporte!=null){
										table+='<td class="text-center"><a href="'+LINK+valores[i].Soporte+'" target="_blank"><b>DESCARGAR</b></a></td>';
									}else{
										table+='<td class="text-center">...</td>';
									}
									
									
									table+='<td><b>'+valores[i].observacion+'</b></td>';
									
									table+='<td class="text-center"><b>'+valores[i].usuario+'</b></td>';
									
									table+='<td class="text-center"><b>'+NuevaFecha(valores[i].registro)+'</b></td>';

									table+='<td class="text-center">'+BtnOpcion+'</td>';

									table+='</tr>';

									

								}

								$("#TableDatos tbody").html(table+data.datos.paginacion);



								}else{

									table+='<tr>';

									table+='<td colspan=7><h5 class="text-danger text-center">No hay registros <i class="fa fa-meh-o"></i></h5></td>';

									table+='</tr>';

									$("#TableDatos tbody").html(table);

								}
							}else{
								Messenger().post({

									message: data.datos.Mensaje,

									type: 'error',

									showCloseButton: true

								});
							}



						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".load").fadeOut(1000);

				},

				error:function(){

					$(".load").fadeOut(1000);

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

				}

			});

			

		}// END FUNCION 
		
	
		// FUNCION ELIMINAR historial
		function Eliminar(id){

			$("#ModalIdp").val(id);

			$("#BotonEliminar").html('<button type="button" class="btn btn-danger mb-xs" onClick="SeguroEliminar();">Si, estoy seguro! <i class="far fa-trash-alt"></i></button>');

			$('#ModalElimnar').modal({

				backdrop:'static'

			});

		}

		function SeguroEliminar(){

			var IDp=$("#ModalIdp").val();

			

			$(".cargar").fadeIn('slow');

			$.ajax({

				type:'POST',

				url:'../ajax/procesos.php',

				data:{action:'EliminarEntrega',id:IDp},

				beforeSend:function(){

					$(".cargar").show();

					$(".btn").attr('disabled', true);

				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							Messenger().post({

								message: 'Gestion eliminado con éxito.',

								type: 'success',

								showCloseButton: true

							});

							load(1);

							$('#ModalElimnar').modal('hide');

						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false)

				},

				error:function(){

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				}

			});

		}

		//********************* FUNCION CATEGORIA TIPOS ALIMENTOS
		function BuscarCategoria(){

			$.ajax({
				type:'POST',
				url:'../ajax/procesos.php',
				data:{action:'BuscarTiposAlimentos'},
				beforeSend:function(){
					$(".cargar").show();
					$(".btn").attr('disabled', true);
				},
				success:function(data){
					$(data).each(function(){
						if(data.estado==1){
							if(data.datos.validacion=='OK'){
								
								var valores=eval(data.datos.row);

								var option='<option value="">[ Seleccionar ]</option>';
								if(data.datos.Cantidad>0){
									for(var i in valores){
										option+='<option value="'+valores[i][0]+'">'+valores[i][1]+'</option>';
									}
								}else{
									var option='<option value="">No hay registro</option>';
								}
								$("#Atipo").html(option);
								
							}else{
								$("#Atipo").html('<option value="">No hay registro</option>');
								Messenger().post({
									message: data.datos.Mensaje,
									type: 'error',
									showCloseButton: true
								});
							}

						}else{
							$("#Atipo").html('<option value="">No hay registro</option>');
							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				},

				error:function(){

					$("#Atipo").html('<option value="">No hay registro</option>');
					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				}

			});
		}

		function Agregar(){

			$("#FormModalCategoria")[0].reset();
			$("#ModalBotonCategoria").html('<button type="button" class="btn btn-success mb-xs" onClick="AgregarCategoria()">Guardar <i class="fas fa-plus"></i></button>');
			$("#TitleModalCategoria").html('<i class="fas fa-plus-circle fa-2x"></i> AGREGAR TIPO ALIMENTO');
			$('#ModalCategoria').modal({
				backdrop:'static'
			});
		}// end funcion 


		//FUNCION AGREGAR AREA
		function AgregarCategoria(){

			var categoriaN=$("#Mcategoria");		

			if(categoriaN.val()==''){
				Messenger().post({
					message: 'Por favor, escriba un nombre',
					type: 'error',
					showCloseButton: true
				});
				categoriaN.focus();
				return false;
			}		
	
			$(".cargar").fadeIn('slow');
			var datos=$("#FormModalCategoria").serialize();

			$.ajax({
				type:'POST',
				url:'../ajax/procesos.php',
				data:datos+"&action=AgregarCategoria",
				beforeSend:function(){
					$(".cargar").show();
					$(".btn").attr('disabled', true);
				},
				success:function(data){
					$(data).each(function(){
						if(data.estado==1){
							if(data.datos.validacion=='OK'){
								Messenger().post({
									message: 'Tipo alimento creado con éxito',
									type: 'success',
									showCloseButton: true
								});
								categoria(1);
								BuscarCategoria();
								$('#ModalCategoria').modal('hide');
							}else{
								Messenger().post({
									message: data.datos.mensaje,
									type: 'error',
									showCloseButton: true
								});
							}

						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				},

				error:function(){

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				}

			});
		}// END FUNCIN 

		function categoria(page){

			var nombre=$("#Btipo").val();

			$.ajax({

				type:'POST',

				url:'../ajax/procesos.php',

				data:{action:'ListadoCategorias',nombre:nombre,page:page},

				beforeSend:function(){

					$(".load").show();

				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							var valores = eval(data.datos.busqueda);

							var table='';

							if(data.datos.cantidad>0){



							for(var i in valores){

								

								var Elimin="EliminarC("+valores[i].id+")";

								var Editar="EditarC("+valores[i].id+")";

								

								var BtnOpcion='<button type="button" class="btn btn-primary btn-sm mb-xs" onClick="'+Editar+'"><i class="far fa-edit"></i></button> ';	

								<?php if($_SESSION['Tipo']==1){ ?>

								BtnOpcion+='<button type="button" class="btn btn-danger btn-sm mb-xs" onClick="'+Elimin+'"><i class="far fa-trash-alt"></i></button> ';

								<?php }?>


								table+='<tr>';

								table+='<td>'+valores[i].id+'</td>';

								table+='<td>'+valores[i].nombre+'</td>';

								table+='<td>'+NuevaFecha(valores[i].fecha)+'</td>';

								table+='<td class="text-center">'+BtnOpcion+'</td>';

								table+='</tr>';

							}

							$("#TableCategoria tbody").html(table+data.datos.paginacion);



							}else{

								table+='<tr>';

								table+='<td colspan=4><h5 class="text-danger text-center">No hay registros <i class="fa fa-meh-o"></i></h5></td>';

								table+='</tr>';

								$("#TableCategoria tbody").html(table);

							}



						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".load").fadeOut(1000);

				},

				error:function(){

					$(".load").fadeOut(1000);

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

				}

			});
		}// END FUNCION 


		//*** FUNCION ELIMINAR
		function EliminarC(id){
			$("#ModalIdp").val(id);
			$("#BotonEliminar").html('<button type="button" class="btn btn-danger mb-xs" onClick="SeguroEliminarC()">Si, estoy seguro! <i class="far fa-trash-alt"></i></button>');

			$('#ModalElimnar').modal({
				backdrop:'static'
			});
		}

		//*** FUNCION CONFIRMAR ELIMINADA
		function SeguroEliminarC(){

			var ID=$("#ModalIdp").val();

			
			$(".cargar").fadeIn('slow');

			$.ajax({

				type:'POST',

				url:'../ajax/procesos.php',

				data:{action:'EliminarCategoria',id:ID},

				beforeSend:function(){
					$(".cargar").show();
					$(".btn").attr('disabled', true);
				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							if(data.datos.Validacion=='OK'){

								Messenger().post({
									message: 'Tipo Elimento eliminada con éxito',
									type: 'success',
									showCloseButton: true
								});

								categoria(1);
								BuscarCategoria();

								$('#ModalElimnar').modal('hide');
							}else{
								Messenger().post({
									message: data.datos.Mensaje,
									type: 'error',
									showCloseButton: true
								});
							}

						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false)

				},

				error:function(){

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".cargar").fadeOut(1000);

					$(".btn").attr('disabled', false);

				}

			});

		}//END FUNCION 

		
		//*** FUNCION EDITAR AREA
		function EditarC(id){

			$("#FormModalCategoria")[0].reset();
			$("#IDcategoria").val(id);

			$("#ModalBotonCategoria").html('<button type="button" class="btn btn-success mb-xs" onClick="ActualizarC()">Actualizar <i class="fas fa-sync-alt"></i></button>');
			$("#TitleModalCategoria").html('<i class="fas fa-pencil-alt fa-2x"></i> EDITAR ');

			$.ajax({
				type:'POST',
				url:'../ajax/procesos.php',
				data:{action:'InformacionCategoria',id:id},
				beforeSend:function(){
					$(".load").show();
				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							var valores = eval(data.datos);
							$("#Mcategoria").val(valores[0]);

							$('#ModalCategoria').modal({
								backdrop:'static'
							});

						}else{

							Messenger().post({
								message: data.mensaje,
								type: 'error',
								showCloseButton: true
							});

						}

						$(".load").fadeOut(1000);

					});

				},

				error:function(){

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".load").fadeOut(1000);

				}

			});
		}

	
		//*** FUNCION ACTUALIZAR AREA
		function ActualizarC(){

			var nombre=$("#Mcategoria");	

			if(nombre.val()==''){
				Messenger().post({
					message: 'Por favor, escriba un nombre',
					type: 'error',
					showCloseButton: true
				});
				nombre.focus();
				return false;
			}		
	

			$(".cargar").fadeIn('slow');
			var datos=$("#FormModalCategoria").serialize();

			$.ajax({
				type:'POST',
				url:'../ajax/procesos.php',
				data:datos+"&action=ActualizarCategoria",
				beforeSend:function(){
					$(".cargar").show();
					$(".btn").attr('disabled', true);
				},

				success:function(data){
					$(data).each(function(){
						if(data.estado==1){
							if(data.datos.validacion=='OK'){
								Messenger().post({
									message: 'Categoria actualizada con éxito',
									type: 'success',
									showCloseButton: true
								});

								categoria(1);
								BuscarCategoria();
								$('#ModalCategoria').modal('hide');

							}else{
								Messenger().post({
									message: data.datos.mensaje,
									type: 'error',
									showCloseButton: true
								});
							}

						}else{

							Messenger().post({
								message: data.mensaje,
								type: 'error',
								showCloseButton: true
							});

						}

					});

					$(".cargar").fadeOut(1000);
					$(".btn").attr('disabled', false);

				},

				error:function(){

					Messenger().post({
						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',
						type: 'error',
						showCloseButton: true
					});

					$(".cargar").fadeOut(1000);
					$(".btn").attr('disabled', false);

				}

			});

		}


			
        </script>

    </body>

</html>