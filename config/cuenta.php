<?php

	session_start();

	if (empty($_SESSION['Nombre']) && empty($_SESSION['IDp']) && $_SESSION['Acceso'] != 'Yes_wey'){

		header("location:../");

	}



	require_once('../ajax/database.php');

	require_once('../class/class_procesos.php');

	require_once('head.php');



	//*** Buscar datos de la empresa

	$Buscar="SELECT u.fld_nombre, u.fld_usuario, u.fld_clave, u.fld_correo, u.fld_img, t.fld_nombre as tipo FROM tbl_usuarios u INNER JOIN tbl_usuarios_tipo t ON u.fld_tipo=t.fld_id WHERE u.fld_id=?";

	$sql= Database::getInstance()->getDb()->prepare($Buscar);

	$sql->execute(array($_SESSION['IDp']));

	$Row=$sql->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html>

    <head>

        <title>Cuenta - Control Alimentación</title>

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

    </head>

    <body class="">

       

        <!-- MENU -->

       	<?php require_once('menu.php'); ?>

       <!-- END MENU -->   



        <div class="content-wrap">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="content" role="main">

                <!-- Page content -->



       			<h1 class="page-title"><i class="fi flaticon-user-3"></i> Mi <span class="fw-semi-bold">Cuenta</span></h1>

       			

       			<div class="cargando" style="display: none;">

       				<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span id="Mensaje_load"></span>

       			</div>



       		<!-- Contenido -->

			<div class="row mt-lg">

				<!-- SESION CAMPOS -->

				

				

				

				<div class="col-md-6 col-sm-6">

					<section class="widget">

						<div class="widget-body">

							<!-- Contenido -->

							<form role="form" id="DatosForm">

							<fieldset>

								<legend><strong>Información</strong> de la cuenta</legend>

								<div class="row">

								

								

									<div class="form-group col-md-6">

										<label for="tpo"><i class="fas fa-user-cog"></i> Tipo Usuario</label>

										<h4><?php echo $Row['tipo']; ?></h4>

									</div>

									<div class="form-group col-md-6">

										<label for="tpo"><i class="fas fa-user-lock"></i> Usuario</label>

										<h4><?php echo $Row['fld_usuario']; ?></h4>

									</div>

									<div class="form-group col-md-12">

										<label for="nit"><i class="fas fa-briefcase"></i> Nombre</label>

										<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $Row['fld_nombre']; ?>" onchange="javascript:this.value=this.value.toUpperCase()">

									</div>

									<div class="form-group col-md-12">

										<label for="tpo"><i class="far fa-envelope"></i> Correo</label>

										<input type="text" class="form-control" id="correo" name="correo" value="<?php echo $Row['fld_correo']; ?>">

									</div>

									

			

									<div class="col-md-12 mt-3 text-center">

										<input type="hidden" id="IDuser" name="IDuser" value="<?php echo $_SESSION['IDp']; ?>">

										<button type="button" class="btn btn-success" onClick="Guardar()">Guardar <i class="fas fa-check"></i></button>

									</div>

								</div><!-- End row -->

							</fieldset>

							</form>

							<!-- End Contenido -->

							

						</div><!-- End Body-->

					</section>

					

					

					<!-- SESION CLAVE -->

					<section class="widget">

						<div class="widget-body">

							<!-- Contenido -->

							<form role="form">

							<fieldset>

								<legend><strong>Cambio</strong> de clave</legend>

								<input type="hidden" id="ClaveSave" value="<?php echo $Row['fld_clave'];?>">

								

								<div class="form-group row">

                                    <label class="col-md-4  col-form-label text-md-right" for="Cactual">Clave Actual</label>

                                    <div class="col-md-7 ">

                                        <div class="input-group">

										  <span class="input-group-prepend">

											<span class="input-group-text"><i class="fi flaticon-locked"></i></span>

										  </span>

                                            <input type="password" class="form-control" id="actual" placeholder="****">

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="form-group row">

                                    <label class="col-md-4 col-form-label text-md-right" for="Cactual">Clave Nueva</label>

                                    <div class="col-md-7 ">

                                        <div class="input-group">

										  <span class="input-group-prepend">

											<span class="input-group-text"><i class="fi flaticon-locked"></i></span>

										  </span>

                                            <input type="password" class="form-control" id="nueva" placeholder="****">

                                        </div>

                                    </div>

                                </div>

                                

                                <div class="form-group row">

                                    <label class="col-md-4 col-form-label text-md-right" for="confirmar">Confirmar Clave</label>

                                    <div class="col-md-7 ">

                                        <div class="input-group">

										  <span class="input-group-prepend">

											<span class="input-group-text"><i class="fi flaticon-locked"></i></span>

										  </span>

                                            <input type="password" class="form-control" id="confirmar" placeholder="****">

                                        </div>

                                    </div>

                                </div>

                                

                                

								<div class="row">

									<div class="col-md-12 mt-3 text-center">

										<button type="button" class="btn btn-success" onClick="Cambiar()">Cambiar <i class="fas fa-sync-alt"></i></button>

									</div>

								</div><!-- End row -->

								

							</fieldset>

							</form>

							<!-- End Contenido -->

							

						</div><!-- End Body-->

					</section>

					<!-- END SESION CLAVE -->

				</div><!-- End col-->

				

				

				<!-- SESIONES DE FOTOGRAFIAS -->

				<div class="col-md-6 col-sm-6">

					<section class="widget">

						<div class="widget-body">

							<!-- Contenido -->

							<form role="form" id="DatosForm2" enctype="multipart/form-data">

							<fieldset>

								<legend><strong>Información</strong> Logo</legend>

								<div class="row">

								

								<!-- Guardar Imagen-->

								<?php 

								 	if($Row['fld_img']!='avatar.png'){

	

										$BD=$Row['fld_img'];

										$Ruta=Database::RutaPerfil();

										$Img=$Ruta.$BD;

	

									}else{ 

										$Img='../img/avatar.png';

										$BD='NN';

									}

								?>

											

								<div class="form-group col-lg-12 text-center">

									<div class="fileinput fileinput-new" data-provides="fileinput">

											

										<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">

											<img alt="..." src="<?php echo $Img; ?>" id="ImgLoad">

										</div>

										<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>

										<div>

											<span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Foto</span><span class="fileinput-exists"><i class="fas fa-exchange-alt text-success"></i> Cambiar</span><input type="file" name="imagen" id="imagen" accept="image/*"></span>

											<a href="javascript:void(0)" class="btn btn-default btn-canc fileinput-exists" data-dismiss="fileinput"><i class="fas fa-times text-warning"></i> Cancelar</a>

										</div>

									</div>

									<input type="hidden" id="img_bd" value="<?php echo $BD;?>">

									<span class="help-block">Por favor, seleccione una imagen JPG o PNG 300*300</span>

                                 </div>

                                 <!-- End Guardar Imagen -->

	

									<div class="col-md-12 mt-3 text-center">

										<button type="button" class="btn btn-success" onClick="ActualizarLogo()">Actualizar <i class="fas fa-sync-alt"></i></button>

									</div>

								</div><!-- End row -->

							</fieldset>

							</form>

							<!-- End Contenido -->

							

						</div><!-- End Body-->

					</section>

				</div>

				<!-- END SESION DE FOTOGRAFIAS -->

				

				

				

				

								

				

			</div><!-- End Row -->

        

       

       <!-- End contenido-->

       

        <?php

			require_once('footer.php');

		?>

            </main>

        </div>

        <!-- The Loader. Is shown when pjax happens -->

        <div class="loader-wrap hiding hide">

            <i class="fa fa-circle-o-notch fa-spin-fast"></i>

        </div>

            

        

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

				

				$('.widget').widgster();		

			}

			

			

			SingApp.onPageLoad(pageLoad);

			pageLoad();

			

		});

			

		



		//*** FUNCION GUARDAR DATOS

		function Guardar(){

				var nombre=$("#nombre");

				var correo=$("#correo");

				var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

				var User=$("#IDuser").val();

			

				if(nombre.val()==''){

					Messenger().post({

						message: 'Por favor, escriba la razón social',

						type: 'error',

						showCloseButton: true

					});

					nombre.focus();

					return false;

				}

				if(correo.val()==''){

					Messenger().post({

						message: 'Por favor, escriba correo electrónico',

						type: 'error',

						showCloseButton: true

					});

					correo.focus();

					return false;

				}

			

				if(!emailRegex.test(correo.val())){

					Messenger().post({

						message: 'Por favor, escriba un correo valido',

						type: 'error',

						showCloseButton: true

					});

					correo.focus();

					return false;

				}



				var Datos=$("#DatosForm").serialize();

					

				$(".cargando").fadeIn('slow');



				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data: Datos+"&action=ActualizarDatosUsuario",

					beforeSend:function(){

						$(".cargando").show();

						$("#Mensaje_load").html('Guardando...');

					},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){

								

								Messenger().post({

									message: 'Información actualizada con éxito',

									type: 'success',

									showCloseButton: true

								});

							}else{

								Messenger().post({

									message: data.mensaje,

									type: 'error',

									showCloseButton: true

								});

							}

						});

						$(".cargando").fadeOut(1000);

					},

					error:function(){

						Messenger().post({

							message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

							type: 'error',

							showCloseButton: true

						});

						$(".cargando").fadeOut(1000);

					}

				});

			}

			

		//*** FUNCION ACTUALIZAR LOGOS CORPORATIVOS

		function ActualizarLogo(){

			var User=$("#IDuser").val();

			var imagen=$("#imagen");

			var imgBD=$("#img_bd").val();

			

			

			//**** IMAGEN

			if(imagen.val()!=''){

				var extensiones = imagen.val().substring(imagen.val().lastIndexOf("."));

				if(extensiones!= ".jpg" && extensiones != ".png" && extensiones != ".jpeg"){

					Messenger().post({

						message: 'La imagen seleccionada con extension '+extensiones+' no es válido, suba un logo tipo JPG o PNG',

						type: 'error',

						showCloseButton: true

					});

					imagen.focus();

					return false;

				}



				var nueva=1;

			}else{

				var nueva=0;

			}

			

			var archivos = new FormData();

				archivos.append('action','ActualizarImagenUsuario');

				if(nueva==1){

					var imagen=document.getElementById("imagen");

					var imagen = imagen.files;

					archivos.append('imagen',imagen[0]);

				}else{

					archivos.append('imagen','null');

				}

				

				archivos.append('imgBD',imgBD);

				archivos.append('User',User);

					

				$(".cargando").fadeIn('slow');



				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data: archivos,

					cache: false,

					contentType: false,

					processData: false,

					beforeSend:function(){

						$(".cargando").show();

						$("#Mensaje_load").html('Actualizando Imagen...');

					},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){

								

								//***IMAGEN USER

								if(data.datos.Logo!=''){

									$("#img_bd").val(data.datos.Logo);

									$("#ImgLoad").attr('src',data.datos.Ruta+data.datos.Logo);

								}

								$("#imagen").val('');

								$(".btn-canc").click();

								

								Messenger().post({

									message: 'Imagen actualizada con éxito',

									type: 'success',

									showCloseButton: true

								});

							}else{

								Messenger().post({

									message: data.mensaje,

									type: 'error',

									showCloseButton: true

								});

							}

						});

						$(".cargando").fadeOut(1000);

					},

					error:function(){

						Messenger().post({

							message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

							type: 'error',

							showCloseButton: true

						});

						$(".cargando").fadeOut(1000);

					}

				});

			

		}// END FUNCION 

			

		//*** FUNCION CAMBIAR CLAVE

		function Cambiar(){

			var User=$("#IDuser").val();

			var clave=$("#ClaveSave").val();

			var actual=$("#actual");

			var nueva=$("#nueva");

			var confirmar=$("#confirmar");



			if(actual.val()==''){

				Messenger().post({

					message: 'Por favor, escriba su contraseña actual',

					type: 'error',

					showCloseButton: true

				});

				actual.focus();

				return false;

			}



			if(actual.val()!=clave){

				Messenger().post({

					message: 'Su contraseña no coinciden con la actual.',

					type: 'error',

					showCloseButton: true

				});

				actual.focus();

				return false;

			}



			if(nueva.val()==''){

				Messenger().post({

					message: 'Por favor, ingrese su nueva contraseña',

					type: 'error',

					showCloseButton: true

				});

				nueva.focus();

				return false;

			}

			if(nueva.val().length<4 || nueva.val().length>10){

				Messenger().post({

					message: 'Por favor, escriba una clave mínima de 4 caracteres y máxima de 10',

					type: 'error',

					showCloseButton: true

				});

				nueva.focus();

				return false;

			}



			if(nueva.val()!=confirmar.val()){

				Messenger().post({

					message: 'La contraseña no coinciden.',

					type: 'error',

					showCloseButton: true

				});

				confirmar.focus();

				return false;

			}

					

			$(".cargando").fadeIn('slow');



			$.ajax({

				type:'POST',

				url:'../ajax/procesos.php',

				data: {action:'RestablecerClaveUser',clave:nueva.val(),User:User},

				beforeSend:function(){

					$(".cargando").show();

					$("#Mensaje_load").html('Restableciendo Clave...');

				},

				success:function(data){

					$(data).each(function(){

						if(data.estado==1){

							$("#ClaveSave").val(nueva.val());

							$("#actual").val('');

							$("#nueva").val('');

							$("#confirmar").val('');

							Messenger().post({

								message: 'Contraseña restablecida con éxito.',

								type: 'success',

								showCloseButton: true

							});

						}else{

							Messenger().post({

								message: data.mensaje,

								type: 'error',

								showCloseButton: true

							});

						}

					});

					$(".cargando").fadeOut(1000);

				},

				error:function(){

					Messenger().post({

						message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

						type: 'error',

						showCloseButton: true

					});

					$(".cargando").fadeOut(1000);

				}

			});



		}



        </script>

    </body>

</html>