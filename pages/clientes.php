<?php

	session_start();

	if (empty($_SESSION['Nombre']) && empty($_SESSION['IDp']) && $_SESSION['Acceso'] != 'Yes_wey'){

		header("location:../");

	}



	require_once('../ajax/database.php');

	require_once('../class/class_procesos.php');

	require_once('../config/head.php');





?>

<!DOCTYPE html>

<html>

    <head>

        <title>Personas - Control Alimentación</title>

        <link href="../css/application.min.css" rel="stylesheet">

        <link href="../css/style.css" rel="stylesheet">

        <link href="../bower_components/fontawesome/css/all.css" rel="stylesheet">

        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->

        <!--[if IE 9]>

        <link href="css/application-ie9-part2.css" rel="stylesheet">

        <![endif]-->

        <link rel="shortcut icon" href="../img/favicon.png">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <meta name="description" content="Rama Juducial">

        <meta name="keywords" content="admin,dashboard,bootstrap,template,react,angular,vue,html,css,javascript">

        <meta name="author" content="Rama Judicial">

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

       	<?php require_once('../config/menu.php'); ?>

       <!-- END MENU -->   



        <div class="content-wrap">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="content" role="main">

                <!-- Page content -->



       			<h1 class="page-title"><i class="fi flaticon-users-1"></i> Personas</h1>

       			

       			<div class="cargando" style="display: none;">

       				<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span id="Mensaje_load"></span>

       			</div>

       			

       			<i class="fa fa-refresh fa-spin fa-3x fa-fw load"></i>

       			



       		<!-- Contenido -->

			<div class="row mt-lg">

				<div class="col-md-12 col-sm-12">

					<section class="widget">


						<div class="widget-body">


						  	  <!-- CONTENIDO LISTADO-->

								<legend>

									<div class="row mb-3">

										<div class="col-md-4 ">

											<label>Buscar</label>

											<input type="text" id="Barea" class="form-control" placeholder="..." onKeyUp="load(1)">

										</div>

										<div class="col-md-2">

											<label>Estado</label>

											<select id="Bestado" class="form-control">

												<option value="">Todos</option>

												<option value="1">Activo</option>

												<option value="0">Inactivo</option>

											</select>

										</div>

									</div>

								</legend>

								

								<div class="table-responsive">

									<table class="table table-hover " id="TableDatos">

										<thead>

										<tr>

											<th><i class="fas fa-barcode"></i></th>

											<th><i class="fas fa-id-card"></i> Cedula</th>

											<th><i class="fas fa-user"></i> Nombre</th>

											<th><i class="far fa-calendar-check"></i> Registro</th>

											<th><i class="fas fa-user-circle"></i> Usuario Registro</th>

											<th class="text-center"><i class="far fa-eye"></i> Estado</th>

											<th class="text-center"><i class="fas fa-cogs"></i> Opciones</th>

										</tr>

										</thead>

										<tbody style="font-size: 12px;">

										</tbody>

									</table>

								</div><!-- End table-->



							  <!--*************** END CONTENIDO LISTADO  ************-->



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

        

         <div class="modal fade" id="ModalArea" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

			<div class="modal-dialog modal-dialog-centered">

				<div class="modal-content">

					<div class="modal-header bg-primary text-white">

						<h5 class="modal-title" id="TitleModalArea"></h5>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true">&times;</span>

						</button>

					</div>

					<div class="modal-body">

						<form id="FormModalArea">

						<!-- CONTENIDO CREAR -->
						<div class="row">

							<div class="col-md-6 form-group">

								<label for="normal-field" class="pt-2 form-control-label text-md-left"> <i class="fas fa-user"></i> Persona</label>

								<input type="text" id="representante" name="representante" class="form-control" onchange="javascript:this.value=this.value.toUpperCase()">

							</div>

							<div class="col-md-6 form-group">

								<label for="normal-field" class="pt-2 form-control-label text-md-left"> <i class="fas fa-id-card"></i> Número Identificación</label>

								<input type="text" id="nit" name="nit" class="form-control">

							</div>

						</div>

						<input type="hidden" id="IDempresa" name="IDempresa">

						</form>

					</div>

					<div class="modal-footer">

						<i class="fa fa-spinner fa-pulse fa-3x fa-fw cargar" style="display: none;"></i>

						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

						<span id="ModalBotonArea"></span>

					</div>

				</div>

			</div>

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

        

       

       <!-- LLamamos los idiomas del calendario -->

        <script src="../bower_components/moment/min/locales.js"></script>

        

        

          <!-- Page scripts -->

        <script src="../bower_components/underscore/underscore-min.js"></script>

        <script src="../bower_components/backbone/backbone.js"></script>

        <script src="../bower_components/messenger/build/js/messenger.js"></script>

        <script src="../bower_components/messenger/build/js/messenger-theme-flat.js"></script>

        <script src="../bower_components/messenger/docs/welcome/javascripts/location-sel.js"></script>

        <script src="../js/components/ui-notifications.js"></script>

        

		<!-- Number input -->

        <script type="text/javascript" src="../js/jquery.number.js"></script>



        <!-- Page scripts -->

        <script>

			

			jQuery(document).ready(function() {

			 jQuery('#codigo').keypress(function(tecla) {

			  if(tecla.charCode < 48 || tecla.charCode > 57) return false;

			   });

			});

		

		$(function(){

			

	

			

			$('.widget').widgster();

	

			

			function pageLoad(){

				

				load(1);

				$("#Bestado").change(function(){

					load(1);

				});


				$('.widget').widgster();		

			}

			

			

			SingApp.onPageLoad(pageLoad);

			pageLoad();

			

		});

			
			

			//********************* FUNCION MOSTRAR LISTADO 

			function NuevaFecha(fecha){

				var Mes=['','ENE','FEB','MAR','ABRI','MAY','JUN','JUL','AGO','SEPT','OCT','NOV','DIC'];

				var f=fecha.split('*');
				var Nf=f[0].split('-');

				return Nf[0]+' '+Mes[Nf[1]]+' '+Nf[2]+' - '+f[1];

			}

			function load(page){

			

				var nombre=$("#Barea").val();

				var estado=$("#Bestado").val();



				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data:{action:'ListadoClientes',nombre:nombre,estado:estado,page:page},

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

									

									var Elimin="Eliminar("+valores[i].id+")";

									var Editar="Editar("+valores[i].id+")";

									

									var BtnOpcion='<button type="button" class="btn btn-primary btn-sm mb-xs" onClick="'+Editar+'"><i class="far fa-edit"></i></button> ';	

									<?php if($_SESSION['Tipo']==1){ ?>

									BtnOpcion+='<button type="button" class="btn btn-danger btn-sm mb-xs" onClick="'+Elimin+'"><i class="far fa-trash-alt"></i></button> ';

									<?php }?>



									if(valores[i].estado==1){		

										var Btnestado='<button type="button" class="btn btn-success btn-sm mb-xs" onClick="Estado('+valores[i].id+')"><i class="far fa-check-circle"></i> Activo</button>';

									}else{

										var Btnestado='<button type="button" class="btn btn-warning btn-sm mb-xs" onClick="Estado('+valores[i].id+')"><i class="far fa-times-circle"></i> Inactivo</button>';

									}



									table+='<tr>';

									table+='<td>'+valores[i].id+'</td>';

									table+='<td>'+valores[i].cedula+'</td>';

									table+='<td>'+valores[i].nombre+'</td>';

									table+='<td>'+NuevaFecha(valores[i].fecha)+'</td>';

									table+='<td>'+valores[i].usuario+'</td>';

									table+='<td class="text-center">'+Btnestado+'</td>';

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

			

			//*** FUNCION CAMBIAR ESTADO

			function Estado(id){

				

				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data:{action:'EstadoClientes',id:id},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){

								if(data.datos.validacion=='OK'){

									load(1);

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

					},

					error:function(){

						Messenger().post({

							message: 'Ocurrió un error inesperado, inténtelo mas tarde.',

							type: 'error',

							showCloseButton: true

						});

					}

				});

			}

			

			//*** FUNCION ELIMINAR

			function Eliminar(id){

				$("#ModalIdp").val(id);

				var Seguro="SeguroEliminar();";

				

				$("#BotonEliminar").html('<button type="button" class="btn btn-danger mb-xs" onClick="'+Seguro+'">Si, estoy seguro! <i class="far fa-trash-alt"></i></button>');

				

				$('#ModalElimnar').modal({

					backdrop:'static'

				});

			}


			//*** FUNCION CONFIRMAR ELIMINADA
			function SeguroEliminar(){

				var ID=$("#ModalIdp").val();

				

				$(".cargar").fadeIn('slow');

				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data:{action:'EliminarCliente',id:ID},

					beforeSend:function(){

						$(".cargar").show();

						$(".btn").attr('disabled', true);

					},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){

								if(data.datos.Validacion=='OK'){

									Messenger().post({

										message: 'Persona eliminada con éxito',

										type: 'success',

										showCloseButton: true

									});

									load(1);

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
			function Editar(id){

				

				$("#FormModalArea")[0].reset();

				$("#IDempresa").val(id);

				$("#ModalBotonArea").html('<button type="button" class="btn btn-success mb-xs" onClick="Actualizar()">Actualizar <i class="fas fa-sync-alt"></i></button>');
				$("#TitleModalArea").html('<i class="fas fa-pencil-alt fa-2x"></i> EDITAR ');



				$.ajax({
					type:'POST',
					url:'../ajax/procesos.php',
					data:{action:'InformacionCliente',id:id},

					beforeSend:function(){

						$(".load").show();

					},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){



								var valores = eval(data.datos);



									$("#representante").val(valores[0]);

									$("#nit").val(valores[1]);


								$('#ModalArea').modal({

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

			function Actualizar(){

				var representante=$("#representante");

				var nit=$("#nit");	

				if(representante.val()==''){

					Messenger().post({

						message: 'Por favor, escriba nombre completo de la persona',

						type: 'error',

						showCloseButton: true

					});

					representante.focus();

					return false;

				}		

				if(nit.val()==''){

					Messenger().post({

						message: 'Por favor, escriba número de Identificación',

						type: 'error',

						showCloseButton: true

					});

					nit.focus();

					return false;

				}						

					

				$(".cargar").fadeIn('slow');

				var datos=$("#FormModalArea").serialize();



				$.ajax({

					type:'POST',

					url:'../ajax/procesos.php',

					data:datos+"&action=ActualizarCliente",

					beforeSend:function(){

						$(".cargar").show();

						$(".btn").attr('disabled', true);

					},

					success:function(data){

						$(data).each(function(){

							if(data.estado==1){

								if(data.datos.validacion=='OK'){

									Messenger().post({

										message: 'Persona actualizada con éxito',

										type: 'success',

										showCloseButton: true

									});

									load(1);

									$('#ModalArea').modal('hide');

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