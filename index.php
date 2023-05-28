<?php

	session_start();

	if (isset($_SESSION['Nombre']) && isset($_SESSION['IDp']) && $_SESSION['Acceso'] == 'Yes_wey'){

	 header("location:pages/");

	}



?>

<!DOCTYPE html>

<html>

    <head>

        <title>Control Alimentación</title>

        <link href="css/application.min.css" rel="stylesheet">

        <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->

        <!--[if IE 9]>

        <link href="css/application-ie9-part2.css" rel="stylesheet">

        <![endif]-->

        <link rel="shortcut icon" href="img/favicon.png">

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

        <script src="js/charts/d3-version-wrapper.js"></script>

    </head>

    <body class="login-page">



        <div class="container">

            <!-- main page content. the place to put widgets in. usually consists of .row > .col-lg-* > .widget.  -->

            <main id="content" class="widget-login-container" role="main">

                <!-- Page content -->

        <div class="row justify-content-center">

            <div class="col-xl-5 col-md-6 col-10">

                <h5 class="widget-login-logo animated fadeInUp">

                    <i class="fa fa-circle text-gray"></i> Bienvenidos <i class="fa fa-circle text-warning"></i>

                </h5>

                <section class="widget widget-login animated fadeInUp">

                    <header>

                        <h3>Iniciar Sesión en su aplicación</h3>

                    </header>

                    <div class="widget-body">

                        <p class="widget-login-info">Recuerde que su usuario y clave es confidencial.</p>

                        

                        <div class="text-center load mt-1 text-warning" style="display: none;">

                        	<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>

                        </div>

                        

                        <div class="alert alert-danger  mt-2" style="display: none;">

                          <button type="button" class="close">×</button>

                          <span id="mensaje"></span>

                      	</div>

                        

                        <div class="login-form mt-lg">

                            <div class="form-group">

                                <input type="text" class="form-control campo" id="user" placeholder="Usuario">

                            </div>

                            <div class="form-group">

                                <input class="form-control campo" id="pswd" type="password" placeholder="Clave">

                            </div>

                            <div class="clearfix">

                                <div class="clearfix text-center my-4">

                                    <button class="btn btn-warning btn-sm text-white campo" type="button" onClick="Iniciar()">Iniciar sesión <i class="fa fa-check"></i></button>

                                </div>

                            </div>


                        </div>

                    </div>

                </section>

            </div>

        </div>

       

           

           <?php require_once('config/footer.php');?>

            </main>

        </div>

        <!-- The Loader. Is shown when pjax happens -->

        <div class="loader-wrap hiding hide">

            <i class="fa fa-circle-o-notch fa-spin-fast"></i>

        </div>



        <!-- common libraries. required for every page-->

        <script src="bower_components/jquery/dist/jquery.min.js"></script>

        <script src="bower_components/jquery-pjax/jquery.pjax.js"></script>

        <script src="bower_components/popper.js/dist/umd/popper.js"></script>

        <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>

        <script src="bower_components/bootstrap/js/dist/util.js"></script>

        <script src="bower_components/slimScroll/jquery.slimscroll.js"></script>

        <script src="bower_components/widgster/widgster.js"></script>

        <script src="bower_components/pace.js/pace.js" data-pace-options='{ "target": ".content-wrap", "ghostTime": 1000 }'></script>

        <script src="bower_components/hammerjs/hammer.js"></script>

        <script src="bower_components/jquery-hammerjs/jquery.hammer.js"></script>



       



         <!-- common app js -->

        <script src="js/settings.js"></script>

        <script src="js/app.js"></script>

        <script src="js/login.js"></script>

        

          <!-- Page scripts -->

        <script src="bower_components/underscore/underscore-min.js"></script>

        <script src="bower_components/backbone/backbone.js"></script>

        <script src="bower_components/messenger/build/js/messenger.js"></script>

        <script src="bower_components/messenger/build/js/messenger-theme-flat.js"></script>

        <script src="bower_components/messenger/docs/welcome/javascripts/location-sel.js"></script>



        <!-- page specific js -->

        <script src="js/components/ui-notifications.js"></script>

        

    </body>

</html>