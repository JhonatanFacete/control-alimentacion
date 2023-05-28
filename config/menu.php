<?php

	$Link='../';

	$archivo_actual = basename($_SERVER['PHP_SELF']); 

	switch($archivo_actual) {

		 case "index.php":

		 $M1 = 'active';

		 break; 

		 case "gestion.php":

		 $M2 = 'active';

		 break;

		 case "clientes.php":

		 $M3 = 'active';

		 break;

			

		 case "admin.php":
		 $A1 = 'active';
		 break;
		 case "usuarios.php":
		 $A3 = 'active';
		 break;
			
		 case "historial.php":
		 $A4 = 'active';
		 break;

	 }

?>

<!-- *********************************MENU IZQUIERDO -->

	<nav id="sidebar" class="sidebar" role="navigation">

		

		<div class="js-sidebar-content">

			<header class="logo d-none d-md-block">

				<a href="index.php"> <span class="text-warning">Control</span> Alimentación</a>

			</header>

			

			<!-- Cuando esta movil se ve esto -->

			<div class="sidebar-status d-md-none">

				<a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">

					<span class="thumb-sm avatar float-right"><?php echo $_SESSION['Image']; ?></span>

					<!--<span class="circle bg-warning fw-bold text-gray-dark">13</span>-->

					&nbsp;<?php echo $_SESSION['Nombre']; ?>

					<!--<b class="caret"></b>-->

				</a>
				<ul class="dropdown-menu dropdown-menu-right">

					<li><a class="dropdown-item" href="../config/cuenta.php"><i class="glyphicon glyphicon-user"></i> &nbsp; Mi cuenta</a></li>

					<li class="dropdown-divider"></li>

					<li><a class="dropdown-item" href="javascript:void(0)" onClick="Cerrar()"><i class="la la-sign-out"></i> &nbsp; Cerrar sesión</a></li>

				</ul>

			</div>

			

			<!-- Enlace del menu -->

			

			<h5 class="sidebar-nav-title">MENU</h5>

			

			<ul class="sidebar-nav">

				<li class="<?php echo $M1; ?>">

					<a href="../pages/index.php"><span class="icon"><i class="fi flaticon-home"></i></span> Inicio</a>

				</li>

				<li class="<?php echo $M2; ?>">

					<a href="../pages/gestion.php"><span class="icon"><i class="fi flaticon-archive-3"></i></span> Entrega Alimentos</a>

				</li>

				<?php if($_SESSION['Tipo']!=3){?>

				<li class="<?php echo $M3; ?>">

					<a href="../pages/clientes.php"><span class="icon"><i class="fi flaticon-users-1"></i></span> Personas</a>

				</li>

				<?php }?>

			</ul>

				

				<!-- USUARIOS NORMAL -->

				

				

		

			<?php if($_SESSION['Tipo']==1){ // TIPO ADMINISTRADOR  ?>

				<h5 class="sidebar-nav-title">ADMINISTRADOR</h5>

				<ul class="sidebar-nav">

					<li class="<?php echo $A1; ?>">

						<a href="../config/admin.php"><span class="icon"><i class="fi flaticon-briefcase"></i></span> Empresa</a>

					</li>

					<li class="<?php echo $A3; ?>">

						<a href="../config/usuarios.php"><span class="icon"><i class="fi flaticon-users"></i></span> Usuarios</a>

					</li>
					
					<li class="<?php echo $A4; ?>">
						<a href="../config/historial.php"><span class="icon"><i class="fi flaticon-list"></i></span> Historial</a>
					</li>

				</ul>

			<?php }?>


			<!-- Configuracion Movil  -->
			<div class="d-md-none">
				<h5 class="sidebar-nav-title">Acceso</h5>

				<ul class="sidebar-nav">
					<li>
						<a href="../config/cuenta.php"><span class="icon"><i class="glyphicon glyphicon-user"></i></span> Mi cuenta</a>
					</li>
					<li>
						<a href="javascript:void(0)" onClick="Cerrar()"><span class="icon"><i class="la la-sign-out"></i></span> Cerrar sesión</a>
					</li>
				</ul>
			</div>			

		</div>

	</nav>  

	

<!-- ************************************* END MENU IZQUIERDO *************************************--> 













<!--***************************************** MENU SUPERIOR *********************************-->

	<nav class="page-controls navbar navbar-dashboard">        

		<div class="container-fluid">

			<!-- .navbar-header contains links seen on xs & sm screens -->

			<div class="navbar-header mr-md-3">

				<ul class="nav navbar-nav">

					<!-- Funcion Cerrar el menu izquierdo-->

					<li class="nav-item">

						<!-- whether to automatically collapse sidebar on mouseleave. If activated acts more like usual admin templates -->

						<a class="d-none d-lg-block nav-link" id="nav-state-toggle" href="javascript:void(0)">

							<i class="la la-bars"></i>

						</a>

						<!-- shown on xs & sm screen. collapses and expands navigation -->

						<a class="d-lg-none nav-link" id="nav-collapse-toggle" href="javascript:void(0)">

							<span class="square square-lg bg-gray text-white d-md-none"><i class="la la-bars"></i></span>

							<i class="la la-bars d-none d-md-block"></i>

						</a>

					</li>

				</ul>

				<ul class="nav navbar-nav navbar-right d-md-none">

					<li class="nav-item">

						<!-- toggles chat -->

						<a class="nav-link" href="javascript:void(0)" data-toggle="chat-sidebar">

							<span class="square square-lg bg-gray text-white"><i class="la la-globe"></i></span>

						</a>

					</li>

				</ul>

				<!-- xs & sm screen logo -->

				<a class="navbar-brand d-md-none" href="../pages/index.php">

					<i class="fa fa-circle text-gray mr-n-sm"></i>

					<i class="fa fa-circle text-warning"></i>&nbsp;Contro Alimentación&nbsp;

					<i class="fa fa-circle text-warning mr-n-sm"></i>

					<i class="fa fa-circle text-gray"></i>

				</a>

			</div>



			<!-- this part is hidden for xs screens -->

			<div class="navbar-header mobile-hidden">

				<!-- search form! link it to your search server -->

				<form class="navbar-form" role="search">

					<div class="form-group" style="display: none;">

						<div class="input-group input-group-no-border">

							<input class="form-control" type="text" placeholder="Buscar ...">

							<span class="input-group-append">

								<span class="input-group-text">

									<i class="la la-search"></i>

								</span>

							</span>

						</div>

					</div>

				</form>

				<ul class="nav navbar-nav float-right">

					<li class="dropdown nav-item">

						<a

								href="javascript:void(0)"

								role="button"

								class="dropdown-toggle dropdown-toggle-notifications nav-link"

								id="notifications-dropdown-toggle"

								data-toggle="dropdown"

								aria-haspopup="true"

								aria-expanded="false"

						>

							<span class="thumb-sm avatar float-left"><?php echo $_SESSION['Image']; ?></span>

							<?php echo $_SESSION['Nombre']; ?>

							<!--<span class="circle bg-warning fw-bold text-white">15</span>

							<b class="caret"></b>-->

						</a>

						<div

								class="dropdown-menu dropdown-menu-right animated fadeInUp py-0"

								aria-labelledby="notifications-dropdown-toggle"

								id="notifications-dropdown-menu"

						>

						<!-- Notificaciones -->

							<section class="card notifications" style="display: none">

								<header class="card-header">

									<div class="text-center mb-sm">

										<strong>Tienes 13 notificaciones</strong>

									</div>

									<div class="btn-group btn-group-sm btn-group-toggle" id="notifications-toggle" data-toggle="buttons">

										<label class="btn btn-default active">

											<!-- Ajax-load plugin en acción. configurando data-ajax-load y data-ajax-target es la 

											Único requisito para la recarga asíncrona. -->

											<input type="radio" checked

												   data-ajax-trigger="change"

												   data-ajax-load="../demo/ajax/notifications.html"

												   data-ajax-target="#notifications-list"> Notificaciones

										</label>

										<label class="btn btn-default">

											<input type="radio"

												   data-ajax-trigger="change"

												   data-ajax-load="../demo/ajax/messages.html"

												   data-ajax-target="#notifications-list"> Mensajes

										</label>

										<label class="btn btn-default">

											<input type="radio"

												   data-ajax-trigger="change"

												   data-ajax-load="../demo/ajax/progress.html"

												   data-ajax-target="#notifications-list"> Progreso

										</label>

									</div>

								</header>

								<!-- notification list with .thin-scroll which styles scrollbar for webkit -->

								<div id="notifications-list" class="list-group thin-scroll">

									<div class="list-group-item">

									<span class="thumb-sm float-left mr clearfix">

										<!--<img class="rounded-circle" src="../demo/img/people/a3.jpg" alt="...">-->

									</span>

										<p class="no-margin overflow-hidden">

											1 new user just signed up! Check out

											<a href="javascript:void(0)">Monica Smith</a>'s account.

											<time class="help-block no-margin">

												2 mins ago

											</time>

										</p>

									</div>

									<a class="list-group-item" href="javascript:void(0)">

									<span class="thumb-sm float-left mr">

										<i class="glyphicon glyphicon-upload fa-lg"></i>

									</span>

										<p class="text-ellipsis no-margin">

											2.1.0-pre-alpha just released. </p>

										<time class="help-block no-margin">

											5h ago

										</time>

									</a>

									<a class="list-group-item" href="javascript:void(0)">

									<span class="thumb-sm float-left mr">

										<i class="fa fa-bolt fa-lg"></i>

									</span>

										<p class="text-ellipsis no-margin">

											Server load limited. </p>

										<time class="help-block no-margin">

											7h ago

										</time>

									</a>

									<div class="list-group-item">

									<span class="thumb-sm float-left mr clearfix">

										<!--<img class="rounded-circle" src="../demo/img/people/a5.jpg" alt="...">-->

									</span>

										<p class="no-margin overflow-hidden">

											User <a href="javascript:void(0)">Jeff</a> registered

											&nbsp;&nbsp;

											<button class="btn btn-xs btn-success">Allow</button>

											<button class="btn btn-xs btn-danger">Deny</button>

											<time class="help-block no-margin">

												12:18 AM

											</time>

										</p>

									</div>

									<div class="list-group-item">

										<span class="thumb-sm float-left mr">

											<i class="fa fa-shield fa-lg"></i>

										</span>

										<p class="no-margin overflow-hidden">

											Instructions for changing your Envato Account password. Please

											check your account <a href="javascript:void(0)">security page</a>.

											<time class="help-block no-margin">

												12:18 AM

											</time>

										</p>

									</div>

									<a class="list-group-item" href="javascript:void(0)">

									<span class="thumb-sm float-left mr">

										<span class="square bg-primary square-lg">

											<i class="fa fa-facebook text-white"></i>

										</span>

									</span>

										<p class="text-ellipsis no-margin">

											New <strong>76</strong> facebook likes received.</p>

										<time class="help-block no-margin">

											15 Apr 2014

										</time>

									</a>

									<a class="list-group-item" href="javascript:void(0)">

									<span class="thumb-sm float-left mr">

										<span class="circle circle-lg bg-gray-dark">

											<i class="fa fa-circle-o text-white"></i>

										</span>

									</span>

										<p class="text-ellipsis no-margin">

											Dark matter detected.</p>

										<time class="help-block no-margin">

											15 Apr 2014

										</time>

									</a>

								</div>

								<footer class="card-footer text-sm">

									<!-- ajax-load button. loads demo/ajax/notifications.php to #notifications-list

										 when clicked -->

									<button class="btn-label btn-link float-right"

											id="load-notifications-btn"

											data-ajax-load="../demo/ajax/notifications.php"

											data-ajax-target="#notifications-list"

											data-loading-text="<i class='la la-refresh fa-spin mr-xs'></i> Loading...">

										<i class="la la-refresh"></i>

									</button>

									<span class="card-footer-text">Synced at: 21 Apr 2014 18:36</span>

								</footer>

							</section>

						</div>

					</li>

					<!-- END SESION DE NOTIFICACION -->

					

					<!-- Opciones de Cuenta -->

					<li class="dropdown nav-item">

						<a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">

							<i class="la la-cog"></i>

						</a>

						<ul class="dropdown-menu dropdown-menu-right">

							<li><a class="dropdown-item" href="../config/cuenta.php"><i class="glyphicon glyphicon-user"></i> &nbsp; Mi cuenta</a></li>

							<li class="dropdown-divider"></li>

							<li><a class="dropdown-item" href="javascript:void(0)" onClick="Cerrar()"><i class="la la-sign-out"></i> &nbsp; Cerrar sesión</a></li>

						</ul>

					</li>

					<!-- End opciones de cuenta -->

					<?php /*

					<li class="nav-item">

						<a href="javascript:void(0)" class="nav-link" data-toggle="chat-sidebar">

							<i class="la la-globe"></i>

						</a>

						<div id="chat-notification" class="chat-notification hide">

							<div class="chat-notification-inner">

								<h6 class="title">

									<span class="thumb-xs">

										<img src="../demo/img/people/a6.jpg" class="rounded-circle mr-xs float-left">

									</span>

									Luisa Smith

								</h6>

								<p class="text">¡Oye! que pasa?</p>

							</div>

						</div>

					</li>*/ ?>

					

				</ul>

			</div>

		</div>

	</nav>   

<!--************************************************ END MENU SUPERIOR *********************************** -->	







<!--***************************************************** OPCION CONTACTOS ****************************************************** -->

  <?php /* <div class="chat-sidebar" id="chat">

		<div class="chat-sidebar-content">

			<header class="chat-sidebar-header">

				<h5 class="chat-sidebar-title">Contactos</h5>

				<div class="form-group no-margin">

					<div class="input-group input-group-transparent">

						<input class="form-control fs-mini" id="chat-sidebar-search" type="text" placeholder="Buscar...">

						<span class="input-group-append">

							<span class="input-group-text">

								<i class="fa fa-search"></i>

							</span>

						</span>

					</div>

				</div>

			</header>

			<div class="chat-sidebar-contacts chat-sidebar-panel open">

				<h5 class="sidebar-nav-title">Hoy</h5>

				<div class="list-group chat-sidebar-user-group">

					<a class="list-group-item" href="#chat-sidebar-user-1">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a2.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Chris Gray</h6>

							<p class="message-preview">Hey! What's up? So many times since we</p>

						</div>

						<i class="fa fa-circle text-success ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-2">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../img/avatar.png" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Jamey Brownlow</h6>

							<p class="message-preview">Good news coming tonight. Seems they agreed to proceed</p>

						</div>

						<i class="fa fa-circle text-gray-light ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-3">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a1.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Livia Walsh</h6>

							<p class="message-preview">Check out my latest email plz!</p>

						</div>

						<i class="fa fa-circle text-danger ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-4">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../img/avatar.png" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Jaron Fitzroy</h6>

							<p class="message-preview">What about summer break?</p>

						</div>

						<i class="fa fa-circle text-gray-light ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-5">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a4.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Mike Lewis</h6>

							<p class="message-preview">Just ain't sure about the weekend now. 90% I'll make it.</p>

						</div>

						<i class="fa fa-circle text-success ml-auto"></i>

					</a>

				</div>

				<h5 class="sidebar-nav-title">La semana pasada</h5>

				<div class="list-group chat-sidebar-user-group">

					<a class="list-group-item" href="#chat-sidebar-user-6">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a6.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Freda Edison</h6>

							<p class="message-preview">Hey what's up? Me and Monica going for a lunch somewhere. Wanna join?</p>

						</div>

						<i class="fa fa-circle text-gray-light ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-7">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a5.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Livia Walsh</h6>

							<p class="message-preview">Check out my latest email plz!</p>

						</div>

						<i class="fa fa-circle text-success ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-8">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../demo/img/people/a3.jpg" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Jaron Fitzroy</h6>

							<p class="message-preview">What about summer break?</p>

						</div>

						<i class="fa fa-circle text-warning ml-auto"></i>

					</a>

					<a class="list-group-item" href="#chat-sidebar-user-9">

						<span class="thumb-sm float-left mr-3">

							<img class="rounded-circle" src="../img/avatar.png" alt="...">

						</span>

						<div>

							<h6 class="message-sender">Mike Lewis</h6>

							<p class="message-preview">Just ain't sure about the weekend now. 90% I'll make it.</p>

						</div>

						<i class="fa fa-circle text-gray-light ml-auto"></i>

					</a>

				</div>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-1">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Chris Gray

					</a>

				</h6>

				<ul class="message-list">

					<li class="message">

						<span class="thumb-sm">

							<img class="rounded-circle" src="../demo/img/people/a2.jpg" alt="...">

						</span>

						<div class="message-body">

							Hey! What's up?

						</div>

					</li>

					<li class="message">

						<span class="thumb-sm">

							<img class="rounded-circle" src="../demo/img/people/a2.jpg" alt="...">

						</span>

						<div class="message-body">

							Are you there?

						</div>

					</li>

					<li class="message">

						<span class="thumb-sm">

							<img class="rounded-circle" src="../demo/img/people/a2.jpg" alt="...">

						</span>

						<div class="message-body">

							Let me know when you come back.

						</div>

					</li>

					<li class="message from-me">

						<span class="thumb-sm">

							<img class="rounded-circle" src="../img/avatar.png" alt="...">

						</span>

						<div class="message-body">

							I am here!

						</div>

					</li>

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-2">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Jamey Brownlow

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-3">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Livia Walsh

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-4">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Jaron Fitzroy

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-5">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Mike Lewis

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-6">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Freda Edison

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-7">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Livia Walsh

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-8">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Jaron Fitzroy

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<div class="chat-sidebar-chat chat-sidebar-panel" id="chat-sidebar-user-9">

				<h6 class="title">

					<a class="js-back" href="javascript:void(0)">

						<i class="fa fa-angle-left mr-xs"></i>

						Mike Lewis

					</a>

				</h6>

				<ul class="message-list">

				</ul>

			</div>

			<footer class="chat-sidebar-footer form-group">

				<input class="form-control fs-sm" id="chat-sidebar-input" type="text"  placeholder="Type your message">

			</footer>

		</div>

	</div>   */ ?> 

<!--************************************************************* END OPCION DE CONTACTO ******************************************************************-->







<!--********************************************* OPCION DE CONIGURACION DERECHA ****************************************-->

	<?php /*<div class="theme-helper">

		<section class="widget theme-helper-content">

			<header class="theme-helper-header d-flex p-0">

				<div class="theme-helper-toggler">

					<div class="theme-helper-spinner bg-warning text-white">

						<i class="la la-cog"></i>

						<i class="la la-cog fs-smaller"></i>

					</div>

				</div>

				<h6>Configuración</h6>

			</header>

			<div class="widget-body mt-3">

				<div class="theme-switcher d-flex justify-content-center">

					<div class="form-check abc-radio abc-radio-warning form-check-inline">

						<input class="form-check-input" type="radio" id="css-light" value="option2" name="css-light" checked aria-label="Sing Light">

						<label class="form-check-label" for="css-light"></label>

					</div>

					<div class="form-check abc-radio abc-radio-secondary mr-0 form-check-inline">

						<input class="form-check-input" type="radio" id="css-dark" value="option1" name="css-light" aria-label="Single Dark">

						<label class="form-check-label" for="css-dark"></label>

					</div>

				</div>

				<div class="mt-4">

					<a href="javascript:void(0)" role="button" class="btn btn-outline-default btn-rounded-f btn-block fs-mini text-muted">

					<i class="glyphicon glyphicon-headphones mr-xs"></i>  Soporte

					</a>

					<a href="javascript:void(0)" role="button" class="btn btn-outline-default btn-rounded-f btn-block fs-mini text-muted">

					<i class="glyphicon glyphicon-book mr-xs"></i> Documentación</a>

				</div>

				<div class="mt-lg d-flex flex-column align-items-center theme-sharing">

					<span class="fs-sm">

						Grema 7.0 - Software

					</span>

				</div>

			</div>

		</section>

	</div>*/?>

<!--************************************************ END OPCION DE CONFIGURACION DERECHA ******************************************** -->

