<?php

	session_start();

	if (empty($_SESSION['Nombre']) && empty($_SESSION['IDp']) && $_SESSION['Acceso'] != 'Yes_wey'){

		header("location:../");

	}



	require_once('../ajax/database.php');

	require_once('../class/class_procesos.php');

	require_once('head.php');


	//*** BUSCAR CLIENTES

	$BuscarClientes="SELECT fld_id, fld_nombre FROM tbl_usuarios WHERE fld_IDempresa=? ORDER BY fld_nombre ASC";
	$cmdClientes= Database::getInstance()->getDb()->prepare($BuscarClientes);
	$cmdClientes->execute(array($_SESSION['IDe']));
	$rowClientes=$cmdClientes->fetchAll();
	$NumClientes=$cmdClientes->rowCount();

?>

<!DOCTYPE html>

<html>

    <head>

        <title>Historial - Control Alimentación</title>

        <link href="../css/application.min.css" rel="stylesheet">

        <link href="../css/style.css" rel="stylesheet">

        <link href="../bower_components/fontawesome/css/all.css" rel="stylesheet">

        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->

        <!--[if IE 9]>

        <link href="css/application-ie9-part2.css" rel="stylesheet">

        <![endif]-->

        <link rel="shortcut icon" href="../img/favicon.png">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <meta name="description" content="Rama Judicial">

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

       	<?php require_once('menu.php'); ?>

       <!-- END MENU -->   



        <div class="content-wrap">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="content" role="main">

                <!-- Page content -->



       			<h1 class="page-title"><i class="fi flaticon-list"></i> Administrador - <span class="fw-semi-bold">Historial</span></h1>

       			

       			<div class="cargando" style="display: none;">

       				<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i> <span id="Mensaje_load"></span>

       			</div>

       			

       			<i class="fa fa-refresh fa-spin fa-3x fa-fw load"></i>

       			



       		<!-- Contenido -->

			<div class="row mt-lg">

				<div class="col-md-12 col-sm-12">

					<section class="widget">

					

						<div class="widget-body">

							

						

								<legend>

									<div class="row mb-3">

										<div class="col-md-3 ">
											<label>Buscar</label>
											<input type="text" id="Bnombre" class="form-control" placeholder="..." onKeyUp="load(1)">
										</div>
										
										<div class="col-md-3 ">
											<label>Usuarios</label>
											<select id="Busuario" class="form-control">
												<?php
													if($NumClientes>0){
														$Option='<option value="">[ TODOS ]</option>';
														foreach($rowClientes as $row){
															$Option.='<option value="'.$row[0].'">'.$row[1].'</option>';
														}
													}else{
														$Option='<option value="">No disponible</option>';
													}	
													echo $Option;
												?>
											</select>
										</div>

										<div class="col-md-3 mt-2">
											<label>Fecha Inicial</label>
											<input type="date" id="BfechaI" class="form-control">
										</div>

										<div class="col-md-3 mt-2">
											<label>Fecha Final</label>
											<input type="date" id="BfechaF" class="form-control" >
										</div>

										<div class="col-md-12 text-center mt-4">
											<button type="button" class="btn btn-success" onClick="load(1)"><i class="fa fa-search"></i> Buscar</button>
										</div>

									</div>

								</legend>

								

								<div class="table-responsive">

									<table class="table table-hover table-bordered table-lg" id="TableDatos" style="font-size: 12px">

										<thead>

										<tr>

											<th><i class="fab fa-slack-hash"></i></th>
											<th><i class="far fa-user-circle"></i> Usuario</th>
											<th>Proceso</th>
											<th>Acción</th>
											<th><i class="far fa-calendar-check"></i> Fecha</th>
										</tr>

										</thead>

										<tbody>

										</tbody>

									</table>

								</div><!-- End table-->

								

						</div><!-- End Body-->

					</section>

				</div><!-- End col-->

				

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

	
			

		$(function(){

			

	


			

			$('.widget').widgster();

	

			

			function pageLoad(){

				

				load(1);

				$("#Busuario").change(function(){

					load(1);

				});

				$('.widget').widgster();		

			}

			

			

			SingApp.onPageLoad(pageLoad);

			pageLoad();

			

		});

			

			//********************* FUNCION MOSTRAR LISTADO 
			function load(page){

				var nombre=$("#Bnombre").val();
				var usuario=$("#Busuario").val();
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
					data:{action:'ListadoHistorial',nombre:nombre,usuario:usuario,fechaI:fechaI,fechaF:fechaF,page:page},
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

									table+='<tr>';
									table+='<td>'+(parseFloat(i)+parseFloat(1))+'</td>';
									table+='<td>'+valores[i].nombre+'</td>';
									table+='<td><b>'+valores[i].proceso+'</b></td>';
									table+='<td>'+valores[i].accion+'</td>';
									table+='<td>'+valores[i].fecha+'</td>';
									table+='</tr>';

								}

								$("#TableDatos tbody").html(table+data.datos.paginacion);

								}else{

									table+='<tr>';
									table+='<td colspan=5><h5 class="text-danger text-center">No hay registros <i class="fa fa-meh-o"></i></h5></td>';
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

			


	

        </script>

    </body>

</html>