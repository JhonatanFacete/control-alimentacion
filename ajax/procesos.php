<?php

	header('Access-Control-Allow-Origin: *');

	require('database.php');

	require_once('../class/class_procesos.php');



	if(isset($_POST['action'])){

		

		if($_POST['action']=='Entrar'){

			Proceso_Loguin();

			

		}else if($_POST['action']=='Cerrar'){

			Proceso_Cerrar();

				

		}else if($_POST['action']=='ListadoClientes'){

			Proceso_ListadoClientes();

				

		}else if($_POST['action']=='EstadoClientes'){

			Proceso_EstadoClientes();

				

		}else if($_POST['action']=='EliminarCliente'){

			Proceso_EliminarCliente();

				

		}else if($_POST['action']=='AgregarCliente'){

			Proceso_AgregarCliente();

				

		}else if($_POST['action']=='InformacionCliente'){

			Proceso_InformacionCliente();

				

		}else if($_POST['action']=='ActualizarCliente'){

			Proceso_ActualizarCliente();

				

		}else if($_POST['action']=='ImportarClientes'){

			Proceso_ImportarClientes();

				

		}else if($_POST['action']=='ActualizarDatosEmpresa'){

			Proceso_ActualizarDatosEmpresa();

				

		}else if($_POST['action']=='ListadoUsuarios'){

			Proceso_ListadoUsuarios();

				

		}else if($_POST['action']=='EstadoUser'){

			Proceso_EstadoUser();

				

		}else if($_POST['action']=='EliminarUsuario'){

			Proceso_EliminarUsuario();

				

		}else if($_POST['action']=='BuscarEmpleado'){

			Proceso_BuscarEmpleado();

				

		}else if($_POST['action']=='BuscarTiposUser'){

			Proceso_BuscarTiposUser();

				

		}else if($_POST['action']=='AgregarUsuario'){

			Proceso_AgregarUsuario();

				

		}else if($_POST['action']=='InformacionUser'){

			Proceso_InformacionUser();

				

		}else if($_POST['action']=='ActualizarUsuario'){

			Proceso_ActualizarUsuario();

				

		}else if($_POST['action']=='ActualizarDatosUsuario'){

			Proceso_ActualizarDatosUsuario();

				

		}else if($_POST['action']=='ActualizarImagenUsuario'){

			Proceso_ActualizarImagenUsuario();

				

		}else if($_POST['action']=='RestablecerClaveUser'){

			Proceso_RestablecerClaveUser();

				

		}else if($_POST['action']=='BuscarFirma'){

			Proceso_BuscarFirma();

				

		}else if($_POST['action']=='BuscarCiudad'){

			Proceso_BuscarCiudad();

				

		}else if($_POST['action']=='ListadoPuntos'){

			Proceso_ListadoPuntos();

				

		}else if($_POST['action']=='BuscarClientes'){

			Proceso_BuscarClientes();

				

		}else if($_POST['action']=='AgregarPunto'){

			Proceso_AgregarPunto();

				

		}else if($_POST['action']=='ActualizarPunto'){

			Proceso_ActualizarPunto();

				

		}else if($_POST['action']=='BuscarClienteAlmacenar'){

			Proceso_BuscarClienteAlmacenar();

				

		}else if($_POST['action']=='SubirGestionCliente'){

			Proceso_SubirGestionCliente();

				

		}else if($_POST['action']=='ListadoEntrega'){

			Proceso_ListadoEntrega();

				

		}else if($_POST['action']=='EliminarEntrega'){

			Proceso_EliminarEntrega();

				

		}else if($_POST['action']=='BuscarSoporteGestion'){

			Proceso_BuscarSoporteGestion();

				

		}else if($_POST['action']=='EliminarArchivoGestion'){

			Proceso_EliminarArchivoGestion();

				

		}else if($_POST['action']=='BuscarRadicado'){

			Proceso_BuscarRadicado();

				

		}else if($_POST['action']=='BuscarTipoDocumento'){

			Proceso_BuscarTipoDocumento();

				

		}else if($_POST['action']=='BuscarSoporteGestionModal'){

			Proceso_BuscarSoporteGestionModal();

				

		}else if($_POST['action']=='ListadoHistorial'){

			Proceso_ListadoHistorial();

				

		}else if($_POST['action']=='BuscarCedula'){

			Proceso_BuscarCedula();

				

		}else if($_POST['action']=='GuardarEntregaAlimento'){

			Proceso_GuardarEntregaAlimento();

				

		}else if($_POST['action']=='RefrescarSesion'){

			Proceso_RefrescarSesion();

				

		}else if($_POST['action']=='ListadoCategorias'){
			Proceso_ListadoCategorias();		

		}else if($_POST['action']=='EliminarCategoria'){
			Proceso_EliminarCategoria();	

		}else if($_POST['action']=='AgregarCategoria'){
			Proceso_AgregarCategoria();	

		}else if($_POST['action']=='InformacionCategoria'){
			Proceso_InformacionCategoria();	

		}else if($_POST['action']=='ActualizarCategoria'){
			Proceso_ActualizarCategoria();		

		}else if($_POST['action']=='BuscarTiposAlimentos'){
			Proceso_BuscarTiposAlimentos();		

		}else{ 

			Error();

		}

	}else if(isset($_GET['action'])){

		

		if($_GET['action']=='FilesMasivo'){

			Proceso_FilesMasivo();

				

		}else{

			Error();

		}

		

	}else{

		Error();

	}



	function Error(){

		header('Content-type: application/json');

		print json_encode(array(

			"estado" => 2,

			"mensaje" => "Acceso Denegado!"

		));

	}



	//** FUNCION CARGAR ARCHIVOS

	function Proceso_FilesMasivo(){

		

		$ds = DIRECTORY_SEPARATOR;

		$Link = Database::LinkFiles();

		$ID=$_GET['ID'];

		$Radicado=$_GET['Radicado'];
		$Documento=$_GET['Documento'];

		$tipo=$_GET['tipo'];

		$Proceso=$_GET['Proceso'];
		$Documen=$_GET['Documen'];

	



		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];              

			$targetPath = dirname( __FILE__ ).$ds.$Link.$ds;

			

			$tipoar=explode('.',$_FILES['file']['name']);

			$conta=count($tipoar);

			for($TB=0;$TB<$conta;$TB++){

				$TIPOARCHI=$tipoar[$TB];

			} 

			

			$Name=$Radicado.'_'.$Documento.'_'.rand().'.'.$TIPOARCHI;

			

			$targetFile =  $targetPath.$Name;

			

			move_uploaded_file($tempFile,$targetFile); 



		}

		

		

		$class=Proceso::FilesMasivo($ID, $Name, $tipo, $Proceso, $Documen);

	}



	function Proceso_Loguin(){

		

		$class=Proceso::Loguearse($_POST['user'], $_POST['pass']);

		

		header('Content-type: application/json');

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrido un error al momento de realizar la busqueda"

			));

		}

		

	}



	//*** FUNCION CERRAR SESION

	function Proceso_Cerrar(){

		session_start();

		session_destroy();

		echo 1;

	}



	//*** FUNCION MOSTRAR LISTADO DE AREAS

	function Proceso_ListadoClientes(){

		

		$class= Proceso::ListadoClientes($_POST['nombre'], $_POST['estado'], $_POST['page']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}



	//*** FUNCION CAMBIAR ESTADO

	function Proceso_EstadoClientes(){

		

		$class= Proceso::EstadoClientes($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de cambiar el estado"

			));

		}

	}



	//*** FUNCION ELIMINAR AREA

	function Proceso_EliminarCliente(){

		

		$class= Proceso::EliminarCliente($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de eliminar los datos"

			));

		}

	}



	//*** FUNCION CREAR LAS AREAS

	function Proceso_AgregarCliente(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::AgregarCliente($empresa, $representante, $nit);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de agregar el area"

			));

		}

	}



	//*** FUNCION INFORMACION AREA

	function Proceso_InformacionCliente(){

		

		$class= Proceso::InformacionCliente($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar datos area"

			));

		}

	}



	//*** FUNCION ACTUALIZAR INFOAREA

	function Proceso_ActualizarCliente(){

		

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::ActualizarCliente($IDempresa, $representante, $nit);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de actualizar el área"

			));

		}

	}



	//*** FUNCION IMPORTAR AREAS

	function Proceso_ImportarClientes(){

		

		$IDempresa=$_POST['User'];

		$tipoCarga=$_POST['tipo'];

	

		$file = $_FILES['archivo']['name'];

		$tmp_name=$_FILES['archivo']['tmp_name'];

		$tipo=$_FILES['archivo']["type"];



		$class=Proceso::ImportarClientes($tipoCarga, $IDempresa, $file, $tmp_name, $tipo);



		header('Content-type: application/json');



		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);



		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de guardar los datos"

			));

		}

	}



	//*** ACTUALIZAR INFORMACION EMPRESA 

	function Proceso_ActualizarDatosEmpresa(){

		

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		if($_POST['imagen']!='null'){

			$file = $_FILES['imagen']['name'];

			$archivo=$_FILES['imagen']['tmp_name'];

			$tipo=$_FILES['imagen']["type"];

		

		  list($width, $height, $type, $attr) = getimagesize($archivo); 

			

		  if($width!=300 or $height!=250){

			   $Validacion=0;

		  }else{

			   $Validacion=1;

		  }

		 

			

		}else{

			$file='null';

			$archivo='null';

			$tipo='null';

			$Validacion=1;

		}

		

		if($Validacion==1){

		

			$class= Proceso::ActualizarDatosEmpresa($User, $nombre, $nit, $tel, $dir, $correo, $imgBD, $file, $archivo, $tipo);



			header('content-type: application/json');



			if($class){

				$datos["estado"] = 1;

				$datos["datos"] = $class;

				print json_encode($datos);

			}else{

				print json_encode(array(

					"estado" => 2,

					"mensaje" => "Ocurrió un error al momento de actualizar los datos"

				));

			}

		}else{

			

			header('content-type: application/json');

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Por favor, seleccione una imagen de dimensiones de 300*250, la imagen seleccionada tiene las siguientes dimensiones (Ancho ".$width.") x (Alto ".$height.")"

			));

			

		}

	}//End funcion 



	//*** FUNCION LISTADO DE USUARIOS

	function Proceso_ListadoUsuarios(){

		

		$class= Proceso::ListadoUsuarios($_POST['nombre'], $_POST['estado'], $_POST['page']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

				));

		}

	}//End Funcion 



	//*** FUNCION CAMBIAR ESTADO USER

	function Proceso_EstadoUser(){

		

		$class= Proceso::EstadoUsuario($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de cambiar el estado"

			));

		}

	}// END FUNCION 



	//*** FUNCION ELIMINAR USUARIO

	function Proceso_EliminarUsuario(){

		

		$class= Proceso::EliminarUsuario($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de eliminar los datos"

			));

		}

	}// END FUNCION 



	//*** FUNCION BUSCAR EMPLEADO

	function Proceso_BuscarEmpleado(){

		

		$class= Proceso::BuscarEmpleado($_POST['ide']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos"

			));

		}

	}// END FUNCION 



	//*** FUNCION BUSCAR TIPO USUARIO

	function Proceso_BuscarTiposUser(){

		

		$class= Proceso::BuscarTiposUser();

	

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los tipo usuario"

			));

		}

	}



	//*** FUNCION AGREGAR TIPO USUARIO -- OK

	function Proceso_AgregarUsuario(){

		

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::AgregarUsuario($nombre, $correo, $user, $clave, $tipo);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de agregar el area"

			));

		}

	}



	//*** FUNCION BUSCAR INFORMACION DE USUARIO

	function Proceso_InformacionUser(){

		

		$class= Proceso::InformacionUser($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar datos usuario"

			));

		}

	}



	//*** FUNCION ACTUAIZAR USUARIO

	function Proceso_ActualizarUsuario(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::ActualizarUsuario($IDuser, $nombre, $correo, $user, $clave, $tipo);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de actualizar el área"

			));

		}

	}



	//*** FUNCION ACTUALIZAR DATOS USUARIO PERSONA NORMAL

	function Proceso_ActualizarDatosUsuario(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::ActualizarDatosUsuario($IDuser, $nombre, $correo);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de actualizar el área"

			));

		}

		

	}



	//*** FUNCION ACTUALIZAR IMAGEN DE USUARIO --- OK

	function Proceso_ActualizarImagenUsuario(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		if($_POST['imagen']!='null'){

			$file = $_FILES['imagen']['name'];

			$archivo=$_FILES['imagen']['tmp_name'];

			$tipo=$_FILES['imagen']["type"];

		

			  list($width, $height, $type, $attr) = getimagesize($archivo); 



			  if($width!=300 or $height!=300){



				header('content-type: application/json');

				print json_encode(array(

					"estado" => 2,

					"mensaje" => "Por favor, seleccione una imagen de dimensiones de 300*300, la imagen seleccionada tiene las siguientes dimensiones (Ancho ".$width.") x (Alto ".$height.")"

				));



				return false;

			}

			

		}else{

			$file='null';

			$archivo='null';

			$tipo='null';

		}

	



		

		$class= Proceso::ActualizarImagenUsuario($User, $imgBD, $file, $archivo, $tipo);



		header('content-type: application/json');



		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de actualizar la imagen"

			));

		}

		

	}



	//*** FUNCION RESTABLECER CLAVE USUARIO

	function Proceso_RestablecerClaveUser(){

		

		$class= Proceso::RestablecerClaveUser($_POST['User'], $_POST['clave']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de restablecer la clave"

			));

		}

	}//End Funcion 



	//FUNCION BUSCAR FIRMA

	function Proceso_BuscarFirma(){

		

		$class= Proceso::BuscarFirma($_POST['cc']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar la firma"

			));

		}

	}



	//** FUNCION BUSCAR CIUDAD

	function Proceso_BuscarCiudad(){



		$class= Proceso::BuscarCiudad($_POST['dpto']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar el departamento"

			));

		}

	}



	//*** FUNCION BUSCAR PUNTOS EMPRESA

	function Proceso_ListadoPuntos(){

		

		$class= Proceso::ListadoPuntos($_POST['nombre'], $_POST['page']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}



	//*** FUNCION BUSCAR CLIENTES

	function Proceso_BuscarClientes(){

		

		$class= Proceso::BuscarClientes();

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}// END FUNCION 



	//*** FUNCION AGREGAR PUNTO

	function Proceso_AgregarPunto(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::AgregarPunto($cliente, $ubicacion);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de agregar el area"

			));

		}

	}



	//*** FUNCION ACTUALIZAR PUNTO

	function Proceso_ActualizarPunto(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::ActualizarPunto($IDempresa, $cliente, $ubicacion);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de agregar el area"

			));

		}

	}



	//*** FUNCION BUSCAR LOS PUNTOS DEL CLIENTE

	function Proceso_BuscarClienteAlmacenar(){

		

		$class= Proceso::BuscarClienteAlmacenar($_POST['cliente']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}



	//** FUNCION SUBIR DATOS DEL CLIENTE

	function Proceso_SubirGestionCliente(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::SubirGestionCliente($IDempresa, $IDacceso, $cliente, $almacenar, $radicado, $identificacion, $nombre, $proceso, $documento, $editar);

		

		header('content-type: application/json');

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de guardar los datos"

			));

		}

	}



	//*** FUNCION BUSCAR LISTADO DE GESTION

	function Proceso_ListadoEntrega(){

		

		$class= Proceso::ListadoEntrega($_POST['buscar'], $_POST['cliente'], $_POST['fechaI'], $_POST['fechaF'], $_POST['page']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}



	//** FUNCION ELIMINAR GESTION DE ARCHIVOS

	function Proceso_EliminarEntrega(){

		

		$class= Proceso::EliminarEntrega($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de eliminar los datos"

			));

		}

	}



	//*** FUNCION BUSCAR TODOS LOS ARCHIVO QUE TIENE LA GESTION

	function Proceso_BuscarSoporteGestion(){

		

		$class= Proceso::BuscarSoporteGestion($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos"

			));

		}

	}



	//** FUNCION ELIMINAR ARCHIVO GESTION

	function Proceso_EliminarArchivoGestion(){

		

		$class= Proceso::EliminarArchivoGestion($_POST['id']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de eliminar los datos"

			));

		}

	}



	//*** FUNCION BUSCAR RADICADO

	function Proceso_BuscarRadicado(){

		

		$class= Proceso::BuscarRadicado($_POST['radicado']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos"

			));

		}

	}



	//** FUNICON BUSCAR TIPO DOCUMENTO

	function Proceso_BuscarTipoDocumento(){

		

		$class= Proceso::BuscarTipoDocumento($_POST['proceso']);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar el tipo documento"

			));

		}

	}

	function Proceso_BuscarSoporteGestionModal(){
		
		$class= Proceso::BuscarSoporteGestionModal($_POST['id'], $_POST['proceso'], $_POST['documento'], $_POST['fechaI'], $_POST['fechaF'], $_POST['page']);

		header('content-type: application/json');

		if($class){
			$datos["estado"] = 1;
			$datos["datos"] = $class;
			print json_encode($datos);

		}else{

			print json_encode(array(
				"estado" => 2,
				"mensaje" => "Ocurrió un error al momento de buscar los datos."
			));
		}
	}

	function Proceso_ListadoHistorial(){
		
		$class= Proceso::ListadoHistorial($_POST['nombre'], $_POST['usuario'], $_POST['fechaI'], $_POST['fechaF'], $_POST['page']);

		header('content-type: application/json');


		if($class){
			$datos["estado"] = 1;
			$datos["datos"] = $class;
			print json_encode($datos);

		}else{
			print json_encode(array(
				"estado" => 2,
				"mensaje" => "Ocurrió un error al momento de buscar los datos."
			));
		}
	}

	function Proceso_BuscarCedula(){

		$class= Proceso::BuscarCedula($_POST['cc'], $_POST['IDempresa']);

		header('content-type: application/json');


		if($class){
			$datos["estado"] = 1;
			$datos["datos"] = $class;
			print json_encode($datos);

		}else{
			print json_encode(array(
				"estado" => 2,
				"mensaje" => "Ocurrió un error al momento de buscar los datos."
			));
		}
	}

	function Proceso_GuardarEntregaAlimento(){

		foreach($_POST as $nombre_campo => $valor){ 
		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
		   eval($asignacion); 
		}



		$Soporte_file = $_FILES['soporte']['name'];
		$Sopote_Archivo=$_FILES['soporte']['tmp_name'];



		$class= Proceso::GuardarEntregaAlimento($IDacceso, $IDempresa, $IDpersona, $identificacion, $nombre, $tipo, $observaciones, $Soporte_file, $Sopote_Archivo);

		header('content-type: application/json');


		if($class){
			$datos["estado"] = 1;
			$datos["datos"] = $class;
			print json_encode($datos);

		}else{
			print json_encode(array(
				"estado" => 2,
				"mensaje" => "Ocurrió un error al momento de buscar los datos."
			));
		}
	}

	function Proceso_RefrescarSesion(){

		session_start();
	}

	//*** FUNCION MOSTRAR LISTADO CATEGORIAS
	function Proceso_ListadoCategorias(){

		$class= Proceso::ListadoCategorias($_POST['nombre'], $_POST['page']);

		header('content-type: application/json');

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar los datos."

			));

		}

	}

	//*** FUNCION ELIMINAR CATEGORIA
	function Proceso_EliminarCategoria(){

		$class= Proceso::EliminarCategoria($_POST['id']);

		header('content-type: application/json');

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de eliminar los datos"

			));

		}
	}

	//*** FUNCION CREAR LAS CATEGORIA
	function Proceso_AgregarCategoria(){

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}	

		$class= Proceso::AgregarCategoria($Mcategoria);

	
		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de agregar el area"

			));

		}

	}

	//*** FUNCION INFORMACION CATEGORIA
	function Proceso_InformacionCategoria(){

		$class= Proceso::InformacionCategoria($_POST['id']);

		header('content-type: application/json');

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de buscar datos area"

			));

		}

	}

	//*** FUNCION ACTUALIZAR CATEGORIA
	function Proceso_ActualizarCategoria(){

		

		foreach($_POST as $nombre_campo => $valor){ 

		   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 

		   eval($asignacion); 

		}

		

		$class= Proceso::ActualizarCategoria($IDcategoria, $Mcategoria);

		

		header('content-type: application/json');

		

		if($class){

			$datos["estado"] = 1;

			$datos["datos"] = $class;

			print json_encode($datos);

		}else{

			print json_encode(array(

				"estado" => 2,

				"mensaje" => "Ocurrió un error al momento de actualizar el área"

			));

		}

	}

	function Proceso_BuscarTiposAlimentos(){

		$class= Proceso::BuscarTiposAlimentos();

	
		header('content-type: application/json');

		if($class){
			$datos["estado"] = 1;
			$datos["datos"] = $class;
			print json_encode($datos);
		}else{
			print json_encode(array(
				"estado" => 2,
				"mensaje" => "Ocurrió un error al momento de actualizar el área"
			));
		}
	}

?>