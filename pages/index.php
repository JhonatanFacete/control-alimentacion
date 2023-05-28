<?php

	session_start();

	if (empty($_SESSION['Nombre']) && empty($_SESSION['IDp']) && $_SESSION['Acceso'] != 'Yes_wey'){

		header("location:../");

	}



	require_once('../ajax/database.php');

	require_once('../class/class_procesos.php');

	require_once('../config/head.php');



	//** Consultar Cantidad clientes

	$BuscaClientes="SELECT COUNT(*) AS cantidad FROM tbl_clientes WHERE fld_IDempresa=?";

	$SqlClien= Database::getInstance()->getDb()->prepare($BuscaClientes);

	$SqlClien->execute(array($_SESSION['IDe']));

	$rowClientes=$SqlClien->fetch();

	$CantidadClientes=$rowClientes[0];



	//** Consultar Cantidad USuarios

	$BuscaUsuarios="SELECT COUNT(*) AS cantidad FROM tbl_usuarios WHERE fld_IDempresa=?";

	$SqlUsuarios= Database::getInstance()->getDb()->prepare($BuscaUsuarios);

	$SqlUsuarios->execute(array($_SESSION['IDe']));

	$rowUsuarios=$SqlUsuarios->fetch();

	$CantidadUsuarios=$rowUsuarios[0];





	//** Consultar Cantidad Entrega alimentos

	$BuscaGestion="SELECT COUNT(*) AS cantidad FROM tbl_entrega WHERE fld_IDempresa=?";

	$SqlGestion= Database::getInstance()->getDb()->prepare($BuscaGestion);

	$SqlGestion->execute(array($_SESSION['IDe']));

	$rowGestion=$SqlGestion->fetch();

	$CantidadGestion=$rowGestion[0];





?>

<!DOCTYPE html>

<html>

    <head>

        <title>Control Alimentación</title>

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

       	<?php require_once('../config/menu.php'); ?>

       <!-- END MENU -->

        



        <div class="content-wrap">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="content" role="main">

                <!-- Page content -->

        <h1 class="page-title">

            Analítica <small><small>Desempeño de la compañía</small></small>

        </h1>

        

        <div class="analytics">

            <div class="analytics-side">

                <div class="row">

                  

                   <div class="col-lg-4 col-md-6">

						<section class="widget widget-card">

							<div class="widget-body clearfix">

								<div class="row">

									<div class="col-3">

										<span class="widget-icon">
											<i class="fas fa-user-friends text-primary"></i>

										</span>

									</div>

									<div class="col-9">

										<h4 class="no-margin">PERSONAS REGISTRADAS</h4>

										<p class="h2 no-margin fw-normal"><?php echo $CantidadClientes; ?></p>

									</div>

								</div>

								<div class="row">

									<div class="col-12">

										<h6 class="no-margin">Registros</h6>

									</div>

								</div>

							</div>

						</section>

					</div>

					<div class="col-lg-4 col-md-6">

						<section class="widget widget-card">

							<div class="widget-body clearfix">

								<div class="row">

									<div class="col-3">

										<span class="widget-icon">

											<i class="fas fa-users text-info"></i>

										</span>

									</div>

									<div class="col-9">

										<h4 class="no-margin">USUARIOS</h4>

										<p class="h2 no-margin fw-normal"><?php echo $CantidadUsuarios;?></p>

									</div>

								</div>

								<div class="row">

									<div class="col-12">

										<h6 class="no-margin">Registros</h6>

									</div>

								</div>

							</div>

						</section>

					</div>

					<div class="col-lg-4 col-md-6">

						<section class="widget widget-card">

							<div class="widget-body clearfix">

								<div class="row">

									<div class="col-3">

										<span class="widget-icon">

											<i class="fas fa-utensils text-warning"></i>

										</span>

									</div>

									<div class="col-9">

										<h4 class="no-margin">ENTREGA ALIMENTOS</h4>

										<p class="h2 no-margin fw-normal"><?php echo $CantidadGestion;?></p>

									</div>

								</div>

								<div class="row">

									<div class="col-12">

										<h6 class="no-margin">Registros</h6>

									</div>

								</div>

							</div>

						</section>

					</div>
   

              

                </div>

            </div>

           

        </div>

                   

		<?php

			require_once('../config/footer.php');

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

        <script src="../bower_components/flot.animator/jquery.flot.animator.min.js"></script>

        <script src="../bower_components/flot/jquery.flot.js"></script>

        <script src="../bower_components/flot-orderBars/js/jquery.flot.orderBars.js"></script>

        <script src="../bower_components/flot/jquery.flot.selection.js"></script>

        <script src="../bower_components/flot/jquery.flot.time.js"></script>

        <script src="../bower_components/flot/jquery.flot.pie.js"></script>

        <script src="../bower_components/flot/jquery.flot.stack.js"></script>

        <script src="../bower_components/flot/jquery.flot.crosshair.js"></script>

        <script src="../bower_components/flot/jquery.flot.symbol.js"></script>

        <script src="../bower_components/flot.dashes/jquery.flot.dashes.js"></script>

        <script src="../bower_components/jquery.sparkline/index.js"></script>

        <script src="../bower_components/bootstrap_calendar/bootstrap_calendar/js/bootstrap_calendar.min.js"></script>

        <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>



        <!-- page specific js -->

        <script src="../js/dashboard/index.js"></script>

    </body>

</html>

