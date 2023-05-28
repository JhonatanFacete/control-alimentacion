<?php

	

	

	class Proceso{

		

		//****** Llamamos la conexion 

		function __construct(){}

		

		//***** FUNCION CARGAR ARCHIVO

		public static function FilesMasivo($ID, $Name, $tipo, $Proceso, $Documen){

			

			$Insert="INSERT INTO tbl_gestion_archivos (fld_IDgestion, fld_proceso, fld_tipo_documento, fld_archivo, fld_fecha) VALUES(?,?,?,?,now())";

			$Sql= Database::getInstance()->getDb()->prepare($Insert);

			$Sql->execute(array($ID, $Proceso, $Documen, $Name));

			

		}// END FUNCION 

		

		public static function Loguearse($user,$pass){

			

			$Consultar="SELECT u.fld_id, u.fld_nombre, u.fld_tipo, u.fld_estado, u.fld_img, e.fld_id as IDe, e.fld_razonsocial, e.fld_estado as Status FROM tbl_usuarios u INNER JOIN tbl_empresa e ON u.fld_IDempresa=e.fld_id WHERE u.fld_usuario=? AND u.fld_clave=?";

			

			try {

				$Sql= Database::getInstance()->getDb()->prepare($Consultar);

				$Sql->execute(array($user,$pass));

				$row=$Sql->fetch(PDO::FETCH_ASSOC);

				

				if($row){

					

					if($row['Status']==1){

						

						if($row['fld_estado']==1){

							

							session_start();

							

							//Colocamos el nombre al final la etiqueta strong

							$Name=explode(' ',ucwords(mb_strtolower($row['fld_nombre'],'utf-8')));

							$Cant=count($Name)-1;

							$Nombre='';

							for($I=0;$I<count($Name);$I++){

								if($Cant==$I){

									$Nombre.='<strong>';

								}

								$Nombre.=$Name[$I].' ';

								if($Cant==$I){

									$Nombre.='</strong>';

								}

							}

							

							//Verificamos si tiene imagen el usuario

							if($row['fld_img']!='avatar.png'){

								$IMG='<img class="rounded-circle" src="../img/perfil/'.$row['fld_img'].'" alt="'.$row['fld_nombre'].'">';

							}else{

								$IMG='<img class="rounded-circle" src="../img/avatar.png" alt="'.$row['fld_img'].'">';

							}

							

							

							$_SESSION['IDp']=$row['fld_id'];

							$_SESSION['IDe']=$row['IDe'];

							$_SESSION['Nombre']=$Nombre;

							$_SESSION['Image']=$IMG;

							$_SESSION['Tipo']=$row['fld_tipo'];

							$_SESSION['Acceso']='Yes_wey';



							$Mensaje='OK';

							

						}else{

							$Mensaje='Se le informa que su usuario se encuentra <span class="fw-semi-bold">Suspendida</span>, por favor comunicarse con el área encargada de su empresa.';

						}

					}else{

						$Mensaje='La empresa <span class="fw-semi-bold">'.$row['fld_razonsocial'].'</span> en estos momentos se encuentra <span class="fw-semi-bold">suspendida</span>, por favor comunicarse con el área encargada.';

					}

					

				}else{

					$Mensaje='Usuario y/o Contraseña <span class="fw-semi-bold">invalidos!</span>';

				}

				

				return $Mensaje;

				

			}catch(PDOException $e){

				return 0;

			}

		}//End funcion

		

		//*** FUNCION COMPRAR CORREO ELECTRONICO



		public static function comprobar_email($email){ 



			$mail_correcto = 0; 

			//compruebo unas cosas primeras 



			if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 



				if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 



					//miro si tiene caracter . 



					if (substr_count($email,".")>= 1){ 



						//obtengo la terminacion del dominio 



						$term_dom = substr(strrchr ($email, '.'),1); 



						//compruebo que la terminaciÃ³n del dominio sea correcta 



						if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 



						//compruebo que lo de antes del dominio sea correcto 



						$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 



						$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 



						if ($caracter_ult != "@" && $caracter_ult != "."){ 



							$mail_correcto = 1; 



						} 



						} 



					} 



				} 



			} 



			if ($mail_correcto){ 

				return 1; 

			}else{ 

				return 0;



			}

		}//End function

		

		//*** FUNCION BUSCAR LISTADO DE AREAS

		public static function ListadoClientes($nombre, $estado, $page){

			

			$onclic="load";

			include 'pagination.php'; 

			$per_page = 15; 

			$adjacents  = 4; 

			$offset = ($page - 1) * $per_page;

			

			session_start();

			$User=$_SESSION['IDe'];

			

			if($nombre!=''){

				$nombre=" AND (c.fld_nombre LIKE '%".$nombre."%' OR c.fld_cedula LIKE '%".$nombre."%') ";

			}else{

				$nombre=" ";

			}

			if($estado!=''){
				$estado=" AND c.fld_estado=$estado";

			}else{
				$estado=" ";
			}


			$Empresa=" c.fld_IDempresa=? ";

			$WHERE=" WHERE ".$Empresa.$nombre.$estado;

			

			$BuscarW="SELECT count(*) AS numrows FROM tbl_clientes c INNER JOIN tbl_usuarios u ON c.fld_IDuser=u.fld_id $WHERE ORDER BY c.fld_id DESC";

			

			try {

				

				$buscador = Database::getInstance()->getDb()->prepare($BuscarW);

				$buscador->execute(array($User));



				$resul = $buscador->fetch();

				$numrows = $resul[0];

				$total_pages = ceil($numrows/$per_page);

				$reload = 'areas.php';



				$navegador='<tr><td colspan="3"><h6>Mostrando un total de '.$numrows.' registro(s)</h6></td>

				<td colspan="4">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';



				$Consulta="SELECT c.fld_id as id, c.fld_cedula as cedula, c.fld_nombre as nombre, c.fld_estado as estado, DATE_FORMAT(c.fld_registro, '%d-%c-%Y*%h:%i %p') as fecha, u.fld_nombre as usuario FROM tbl_clientes c INNER JOIN tbl_usuarios u ON c.fld_IDuser=u.fld_id $WHERE ORDER BY c.fld_id DESC LIMIT $offset,$per_page";

			

				// Preparar sentencia

				$comando = Database::getInstance()->getDb()->prepare($Consulta);

				$comando->execute(array($User));

				$row = $comando->fetchAll(PDO::FETCH_ASSOC);

				

				$array = array(

					"busqueda" => $row,

					"paginacion" =>$navegador,

					"cantidad" => $numrows

				);

				

				return $array;

				

			}catch (PDOException $e){

				return 0;

       		}

			

		}// END FUNCION 

		

		//*** FUNCION CAMBIAR ESTADO

		public static function EstadoClientes($id){

			

			try {

				

				session_start();

				$User=$_SESSION['IDe'];

				

				$Consultar="SELECT fld_estado FROM tbl_clientes WHERE fld_id=?";



				$cmd= Database::getInstance()->getDb()->prepare($Consultar);

				$cmd->execute(array($id));

				$resul = $cmd->fetch();

				$estado = $resul[0];



				if($estado==1){

					$estado=0;

				}else{

					$estado=1;

				}



				$Update="UPDATE tbl_clientes SET fld_estado=? WHERE fld_id=?";

				$sql= Database::getInstance()->getDb()->prepare($Update);

				$sql->execute(array($estado,$id));

				

				return array('validacion'=>'OK');

				

			}catch (PDOException $e){

				return array('validacion'=>'error', 'mensaje'=>'Error '.$e->getMessage());

       		}

		}// END FUCNION 

		

		//*** FUNCION ELIMINAR AREA

		public static function EliminarCliente($id){

			try {
				
				session_start();
				$User=$_SESSION['IDe'];
				$UserP=$_SESSION['IDp'];

				$Consultar="SELECT fld_nombre, fld_id FROM tbl_clientes WHERE fld_id=?";
				$cmd = Database::getInstance()->getDb()->prepare($Consultar);
				$cmd->execute(array($id));
				$rowB=$cmd->fetch();

				//** Consultamos si tiene registro
				$Buscar="SELECT fld_id FROM tbl_entrega WHERE fld_IDpersona=? AND fld_IDempresa=?";
				$sql = Database::getInstance()->getDb()->prepare($Buscar);
				$sql->execute(array($rowB[1], $User));
				$Cantidad=$sql->rowCount();

				if($Cantidad==0){
					
					$Eliminar="DELETE FROM tbl_clientes WHERE fld_id=?";
					$delete = Database::getInstance()->getDb()->prepare($Eliminar);
					$delete->execute(array($id));

					//Historial
					Proceso::HistorialUsuario($User, $UserP, 'ELIMINACIÓN', '<b>Persona</b> ('.$rowB[0].') ');


					return array('Validacion'=>'OK');

				}else{
					return array('Validacion'=>'Error', 'Mensaje'=>'No se puede eliminar esta persona porque tiene registro de entraga de alimento.');
				}

			}catch (PDOException $e){

				return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());

       		}

		}// END FUCNION

		

		//*** FUNCION AGREGAR AREA

		public static function AgregarCliente($empresa, $representante, $nit){

			session_start();

			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];
			

			//Buscar el codigo

			$Consultar="SELECT fld_id FROM tbl_clientes WHERE fld_nit=? AND fld_IDempresa=?";

			

			try {

				$sql = Database::getInstance()->getDb()->prepare($Consultar);

				$sql->execute(array($nit, $User));

				$Num=$sql->rowCount();



				if($Num==0){

					

					$Insert="INSERT INTO tbl_clientes (fld_IDempresa, fld_empresa, fld_representante, fld_nit, fld_registro) VALUES (?,?,?,?,now())";

					$cmd = Database::getInstance()->getDb()->prepare($Insert);

					$cmd->execute(array($User, $empresa, $representante, $nit));

					//Historial
					Proceso::HistorialUsuario($User, $UserP, 'NUEVO', '<b>Cliente</b> ('.$empresa.')');


					return array('validacion'=>'OK');

				}else{

					return array('validacion'=>'Error', 'mensaje'=>'El nit '.$nit.' ya existe, ingrese otro.');

				}

			

			}catch(PDOException $e){

				return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

			}

		}// END FUNCION 

		

		//*** FUNCION BUSCAR INFORMACION AREA

		public static function InformacionCliente($id){

			try {

				
				$Buscar="SELECT fld_nombre, fld_cedula FROM tbl_clientes WHERE fld_id=?";
				$cmd = Database::getInstance()->getDb()->prepare($Buscar);
				$cmd->execute(array($id));
				$row=$cmd->fetch();

				

				return $row;

				

			}catch(PDOException $e){

				return 0;

			}

		}//End funcion

		

		//*** FUNCION ACTUAIZAE AREA

		public static function ActualizarCliente($id, $representante, $nit){

			
			
			

			

			try {
				
				session_start();
				$User=$_SESSION['IDe'];
				$UserP=$_SESSION['IDp'];
				
				//Buscar el codigo
				$Consultar="SELECT fld_id FROM tbl_clientes WHERE fld_cedula=? AND fld_id!=? AND fld_IDempresa=?";
				$sql = Database::getInstance()->getDb()->prepare($Consultar);

				$sql->execute(array($nit, $id, $User));

				$Num=$sql->rowCount();



				if($Num==0){

					

					$Update="UPDATE tbl_clientes SET fld_nombre=?, fld_cedula=? WHERE fld_id=?";

					$cmd = Database::getInstance()->getDb()->prepare($Update);

					$cmd->execute(array($representante, $nit, $id));
					
					//Historial
					Proceso::HistorialUsuario($User, $UserP, 'ACTUALIZACIÓN', '<b>Persona</b> ('.$representante.')');



					return array('validacion'=>'OK');

				}else{

					return array('validacion'=>'Error', 'mensaje'=>'El número de identificacion '.$texto.' ya existe, ingrese otro.');

				}

			

			}catch(PDOException $e){

				return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

			}

		}// END FUNCION 



		//*** FUNCION IMPORTAR 

		public static function ImportarClientes($tipoCarga, $IDempresa, $file, $tmp_name, $tipo){

			

			$array=array();

			$archivo='Importar_'.time().'.xlsx';

			

			if(copy($tmp_name,$archivo)){

				$Estado='OK';	

			}else{

				$Estado='Mal';

			}



			if(file_exists($archivo)){



				/** Clases necesarias */

				require_once('../bower_components/Classes/PHPExcel.php');

				require_once('../bower_components/Classes/PHPExcel/Reader/Excel2007.php');

				require_once('../bower_components/Classes/PHPExcel/IOFactory.php');



				// Cargando la hoja de calculo

				$objReader = new PHPExcel_Reader_Excel2007();

				$objPHPExcel = $objReader->load($archivo);

				$objFecha = new PHPExcel_Shared_Date();



				// Asignar hoja de excel activa

				$objPHPExcel->setActiveSheetIndex(0);

				$totalregistros = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;





				$i = 2; //Iniciamos con la segunda fila del archivo

				$Error=0;

				$OK=0;

				$Msj='';

				$Cons=0;

				$Letra='A';

				$IDcliente=0;

				
				session_start();
				$UserP=$_SESSION['IDp'];
	

				try {



					while($objPHPExcel->getActiveSheet()->getCell($Letra.$i)->getValue() != ''){



						if($tipoCarga==1){//Cargar Clientes

							

							$EMPRESA=mb_strtoupper($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(), 'UTF-8');

							$REPRESENTANTE=mb_strtoupper($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(), 'UTF-8');

							$NIT=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

							

							//Buscar si ya se encuentra registrado el nit

							if($NIT!=''){

								$BuscarCliente="SELECT fld_id FROM tbl_clientes WHERE fld_IDempresa=? AND fld_nit=?";

								$Sql= Database::getInstance()->getDb()->prepare($BuscarCliente);

								$Sql->execute(array($IDempresa, $NIT));

								$NumBusqueda=$Sql->rowCount();

							}

							

							if($EMPRESA==''){ 

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, escriba nombre de la empresa<br>';



							}else if($REPRESENTANTE==''){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, escriba nombre del representante<br>';

								

							}else if($NIT==''){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, escriba número de nit<br>';

								

							}else if($NumBusqueda>0){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> El número de nit '.$NIT.' ya existe en un cliente. ingrese otro<br>';

								

							}else{

								$Guardar="INSERT INTO tbl_clientes (fld_IDempresa, fld_empresa, fld_representante, fld_nit, fld_registro) VALUES (?,?,?,?,?,now())";

								$cmd= Database::getInstance()->getDb()->prepare($Guardar);

								$cmd->execute(array($IDempresa, $EMPRESA, $REPRESENTANTE, $NIT));


								//Historial
								Proceso::HistorialUsuario($IDcliente, $UserP, 'NUEVO', '<b>Cliente</b> ('.$EMPRESA.')');

								if($cmd){

									$OK++;



								}else{ 

									$Error++;

									$Msj.='<strong>FILA #'.$i.':</strong> No se pudo guardar el registro, verifique los datos. <br>';

								}

								

							}

							

						}else if($tipoCarga==2){//Cargar Ubicaciones

							

							$NIT=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();

							$UBICACION=mb_strtoupper($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(), 'UTF-8');

							

							if($NIT!='' and $IDcliente!=$NIT){

								$BuscarCliente="SELECT fld_id FROM tbl_clientes WHERE fld_IDempresa=? AND fld_nit=?";

								$Sql= Database::getInstance()->getDb()->prepare($BuscarCliente);

								$Sql->execute(array($IDempresa, $NIT));

								$RowSql=$Sql->fetch();

								$IDcliente=$RowSql[0];

								$NumBusqueda=$Sql->rowCount();

							}

							

							

							if($NIT==''){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, escriba número de nit<br>';

								

							}else if($NumBusqueda==0){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, ingrese un número de nit válido, el ingresado '.$NIT.' no existe. <br>';

								

							}else if($UBICACION==''){

								$Error++;

								$Msj.='<strong>FILA #'.$i.':</strong> Por favor, escriba nombre de la ubicación<br>';

								

							}else{

								$Guardar="INSERT INTO tbl_clientes_ubicacion (fld_IDcliente, fld_nombre) VALUES (?,?)";

								$cmd= Database::getInstance()->getDb()->prepare($Guardar);

								$cmd->execute(array($IDcliente, $UBICACION));

								

								if($cmd){

									$OK++;



								}else{ 

									$Error++;

									$Msj.='<strong>FILA #'.$i.':</strong> No se pudo guardar el registro, verifique los datos. <br>';

								}

							}

						}

						



						$i++;

						$Cons++;

					}//End While*/





					if($Cons>=1){

						$validacion='OK';

						$array['Error']=$Error;

						$Mensaje='';

						

						if($tipoCarga==1){

							$Texto="clientes";

						}else{

							$Texto="ubicaciones";

						}

						if($OK>0){

							$Mensaje.='<h4 class="mt-0 mb-0 text-center text-white">Se registraron '.$OK.' '.$Texto.' de '.$totalregistros.' con éxito <i class="fa fa-check"></i></h4>';

						}



						if($Error>0){

							$Mensaje.='<h4 align="left">Número errores encontrados '.$Error.' de '.$totalregistros.' registros. <i class="fa fa-user-times"></i></h4>';

							$Mensaje.='<p align="left">'.$Msj.'</p>';

						}



					}else{ 

						$validacion='Mal'; 

						$Mensaje='Ocurrió un error al momento de leer los datos del archivo, por favor verifique los datos e inténtelo de nuevo.';



					}



					

					

					}catch(PDOException $e){

						$validacion='Mal';

						$Mensaje=$e->getMessage();

					}



				

				$array['validacion']=$validacion;

				$array['mensaje']=$Mensaje;



			}else{//END VALIDACION SI EXISTE EL ARCHIVO 

				$array['validacion']='Mal';

				$array['mensaje']='Ocurrió un error al cargar el archivo, inténtelo de nuevo.';

			}

			

			if($Estado=='OK'){

				unlink($archivo);	

			}



			return $array;

		}// END FUNCION

		

		//*** FUNCION ACTUALIZAR INFORMACION DATOS DE LA EMPRESA

		public static function ActualizarDatosEmpresa($User, $nombre, $nit, $tel, $dir, $correo, $imgBD, $file, $archivo, $tipo){

			try{

				$Ruta=Database::RutaEmpresa();

				

				if($file!='null'){

				

					$tipo=explode('/',$tipo);

					$logo=rand().'.'.$tipo[1];



					if(move_uploaded_file($archivo, $Ruta.$logo)){

						$Proceso=1;

						if(opendir($Ruta)){ // Eliminamos la imegen que estaba anterior

							if(file_exists($Ruta.$imgBD)){

								unlink($Ruta.$imgBD);

							}

						}

					}else{

						$Proceso=0;

					}



					if($Proceso==1){

						$Img=", fld_logo='".$logo."' ";

					}else{

						$Img=" ";

					}



				}else{

					$Img=" ";

					$logo='';

				}

				

				$Update="UPDATE tbl_empresa SET fld_razonsocial=?, fld_nit=?, fld_telefono=?, fld_direccion=?, fld_correo=? ".$Img." WHERE fld_id=?";

				$cmd= Database::getInstance()->getDb()->prepare($Update);

				$cmd->execute(array($nombre, $nit, $tel, $dir, $correo, $User));

				

				return array('Logo'=>$logo, 'Ruta'=>$Ruta);

				

			}catch(PDOException $e){

				return 0;

			}

		}// END FUNCION 

		

		//**** FUNCION BUSCAR LISTADO USUARIO

		public static function ListadoUsuarios($nombre, $estado, $page){

			

			$onclic="load";

			include 'pagination.php'; 

			$per_page = 15; 

			$adjacents  = 4; 

			$offset = ($page - 1) * $per_page;

			

			session_start();

			$User=$_SESSION['IDe'];

			

			if($nombre!=''){

				$nombre=" AND u.fld_nombre LIKE '%".$nombre."%' ";

			}else{

				$nombre=" ";

			}

			if($estado!=''){

				$estado=" AND u.fld_estado=$estado";

			}else{

				$estado=" ";

			}



			$Empresa=" u.fld_IDempresa=? ";

			$WHERE=" WHERE ".$Empresa.$nombre.$estado;

			

			$BuscarW="SELECT count(*) AS numrows FROM tbl_usuarios u INNER JOIN tbl_usuarios_tipo t ON u.fld_tipo=t.fld_id ".$WHERE." ORDER BY u.fld_id DESC";

			

			try {

				

				$buscador = Database::getInstance()->getDb()->prepare($BuscarW);

				$buscador->execute(array($User));



				$resul = $buscador->fetch();

				$numrows = $resul[0];

				$total_pages = ceil($numrows/$per_page);

				$reload = 'areas.php';



				$navegador='<tr><td colspan="4"><h6>Mostrando un total de '.$numrows.' registro(s)</h6></td>

				<td colspan="5">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';



				$Consulta="SELECT u.fld_id as id, u.fld_nombre as nombre, u.fld_usuario as user, u.fld_clave as pass, t.fld_nombre as tipo, u.fld_img as img, u.fld_fecharegistro as Fregistro, u.fld_estado as stado FROM tbl_usuarios u INNER JOIN tbl_usuarios_tipo t ON u.fld_tipo=t.fld_id ".$WHERE." ORDER BY u.fld_id DESC LIMIT $offset,$per_page";

			

				// Preparar sentencia

				$comando = Database::getInstance()->getDb()->prepare($Consulta);

				$comando->execute(array($User));

				$row = $comando->fetchAll(PDO::FETCH_ASSOC);

				

				//Consultar Ruta Imagen

				$Ruta=Database::RutaPerfil();

				

				$array = array(

					"busqueda" => $row,

					"paginacion" =>$navegador,

					"cantidad" => $numrows,

					"Ruta" => $Ruta

				);

				

				return $array;

				

			}catch (PDOException $e){

				return 0;

       		}

		}// END FUNCION 

		

		//*** FUNCION CAMBIAR ESTADO

		public static function EstadoUsuario($id){

			

			try {

				

				session_start();

				$User=$_SESSION['IDe'];

				

				$Consultar="SELECT fld_estado FROM tbl_usuarios WHERE fld_id=?";



				$cmd= Database::getInstance()->getDb()->prepare($Consultar);

				$cmd->execute(array($id));

				$resul = $cmd->fetch();

				$estado = $resul[0];



				if($estado==1){

					$estado=0;

				}else{

					$estado=1;

				}



				$Update="UPDATE tbl_usuarios SET fld_estado=? WHERE fld_id=?";

				$sql= Database::getInstance()->getDb()->prepare($Update);

				$sql->execute(array($estado,$id));

				

				return array('validacion'=>'OK');

				

			}catch (PDOException $e){

				return array('validacion'=>'error', 'mensaje'=>'Error '.$e->getMessage());

       		}

		}// END FUCNION 

		

		//*** FUNCION ELIMINAR USUARIO

		public static function EliminarUsuario($id){

			

			$Eliminar="DELETE FROM tbl_usuarios WHERE fld_id=?";

			try {
				
				session_start();
				$User=$_SESSION['IDe'];
				$UserP=$_SESSION['IDp'];
				
				$Buscar="SELECT fld_nombre FROM tbl_usuarios WHERE fld_id=?";
				$cmd = Database::getInstance()->getDb()->prepare($Buscar);
				$cmd->execute(array($id));
				$rowb=$cmd->fetch();
				
				
				$delete = Database::getInstance()->getDb()->prepare($Eliminar);
				$delete->execute(array($id));

				//Historial
				Proceso::HistorialUsuario($User, $UserP, 'ELIMINACIÓN', '<b>Usuario</b> ('.$rowb[0].')');

				return 1;

				

			}catch (PDOException $e){

				return 0;

       		}

		}// END FUCNION

		

		//*** FUNCION BUSCAR EMPLEADO

		public static function BuscarEmpleado($ide){

			

			session_start();

			$IDe=$_SESSION['IDe'];

			

			$Consultar="SELECT fld_id, concat_ws(' ', fld_per_Pnombre, fld_per_Snombre, fld_per_Papellido, fld_per_Sapellido) as nombre, fld_per_correo FROM tbl_afiliacion WHERE fld_IDempresa=? AND fld_per_identificacion=? ORDER BY fld_id DESC LIMIT 1";

			

			try {

				$sql= Database::getInstance()->getDb()->prepare($Consultar);

				$sql->execute(array($IDe, $ide));

				$resul = $sql->fetch();

				

				if($resul){

					return $resul;

				}else{

					return 'N';

				}



			}catch (PDOException $e){

				return 0;

       		}

		}// END FUNCION 

		

		//*** FUNCION BUSCAR TIPO USUARIO

		public static function BuscarTiposUser(){

		

			

			//Buscar

			$Buscar="SELECT fld_id, fld_nombre FROM tbl_usuarios_tipo ORDER BY fld_nombre ASC";

			try {

				$cmd= Database::getInstance()->getDb()->prepare($Buscar);

				$cmd->execute();

				$row=$cmd->fetchAll();



				if($row){

					return $row;

				}else{

					return 0;

				}

			}catch(PDOException $e){

				return 0;

			}

			

		}//End Funcion 

		

		//*** FUNCION AGREGAR TIPO USUARIO

		public static function AgregarUsuario($nombre, $correo, $user, $clave, $tipo){

			

			session_start();

			$IDempresa=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];

			

			//Buscar el codigo

			$Consultar="SELECT fld_id FROM tbl_usuarios WHERE fld_usuario=?";

			

			try {

				$sql = Database::getInstance()->getDb()->prepare($Consultar);

				$sql->execute(array($user));

				$Num=$sql->rowCount();



				if($Num==0){

					

					$Insert="INSERT INTO tbl_usuarios (fld_IDempresa, fld_nombre, fld_usuario, fld_clave, fld_correo, fld_tipo, fld_fecharegistro) VALUES (?,?,?,?,?,?,now())";

					$cmd = Database::getInstance()->getDb()->prepare($Insert);

					$cmd->execute(array($IDempresa, $nombre, $user, $clave, $correo, $tipo));
					
					
					//Historial
					Proceso::HistorialUsuario($IDempresa, $UserP, 'NUEVO', '<b>Usuario</b> ('.$nombre.')');




					return array('validacion'=>'OK');

				}else{

					return array('validacion'=>'Error', 'mensaje'=>'El usuario '.$user.' no se encuentra disponible, ingrese otro.');

				}

			

			}catch(PDOException $e){

				return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

			}

			

		}// END FUNCION 

		

		//*** FUNCION BUSCAR INFORMACION USUARIO

		public static function InformacionUser($id){

			try {

				

				$Buscar="SELECT fld_nombre, fld_correo, fld_usuario, fld_clave, fld_tipo FROM tbl_usuarios WHERE fld_id=?";

				$cmd = Database::getInstance()->getDb()->prepare($Buscar);

				$cmd->execute(array($id));

				$row=$cmd->fetch();

				

				return $row;

				

			}catch(PDOException $e){

				return 0;

			}

		}//End funcion

		

		//*** FUNCION ACTUAIZAE USUARIO

		public static function ActualizarUsuario($IDuser, $nombre, $correo, $user, $clave, $tipo){

			

			//Buscar el codigo

			$Consultar="SELECT fld_id FROM tbl_usuarios WHERE fld_usuario=? AND fld_id!=?";

			

			try {
				
				session_start();
				$User=$_SESSION['IDe'];
				$UserP=$_SESSION['IDp'];

				$sql = Database::getInstance()->getDb()->prepare($Consultar);

				$sql->execute(array($user, $IDuser));

				$Num=$sql->rowCount();



				if($Num==0){

					

					$Update="UPDATE tbl_usuarios SET fld_nombre=?, fld_correo=?, fld_usuario=?, fld_clave=?, fld_tipo=? WHERE fld_id=?";

					$cmd = Database::getInstance()->getDb()->prepare($Update);

					$cmd->execute(array($nombre, $correo, $user, $clave, $tipo, $IDuser));


					//Historial
					Proceso::HistorialUsuario($User, $UserP, 'ACTUALIZACIÓN', '<b>Usuario</b> ('.$nombre.')');
					
					
					return array('validacion'=>'OK');

				}else{

					return array('validacion'=>'Error', 'mensaje'=>'El usuario '.$user.' no se encuentra disponible, ingrese otro.');

				}

			

			}catch(PDOException $e){

				return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

			}

		}// END FUNCION 

		

		//** FUNCION ACTUALIZAR DATOS USUARIO PERSONA CUENTA

		public static function ActualizarDatosUsuario($IDuser, $nombre, $correo){

			try {

				

				$Update="UPDATE tbl_usuarios SET fld_nombre=?, fld_correo=? WHERE fld_id=?";

				$cmd = Database::getInstance()->getDb()->prepare($Update);

				$cmd->execute(array($nombre, $correo, $IDuser));

				

				return 1;

			}catch(PDOException $e){

				return 0;

			}

		}// END FUNCION 

		

		//*** FUNCION ACTUALIZAR LOGO USUARIO

		public static function ActualizarImagenUsuario($User, $imgBD, $file, $archivo, $tipo){

			

			try{

				$Ruta=Database::RutaPerfil();

				

				//*** IMAGEN USUARIO

				if($file!='null'){

				

					$tipo=explode('/',$tipo);

					$logo=rand().'.'.$tipo[1];



					if(move_uploaded_file($archivo, $Ruta.$logo)){

						$Proceso=1;

						if(opendir($Ruta)){ // Eliminamos la imegen que estaba anterior

							if(file_exists($Ruta.$imgBD)){

								unlink($Ruta.$imgBD);

							}

						}

					}else{

						$Proceso=0;

					}



					if($Proceso==1){

						$Img=" fld_img='".$logo."' ";

					}else{

						$Img=" ";

					}



				}else{

					$Img=" ";

					$logo='';

				}

				

			

				

				if($logo!=''){

					$Update="UPDATE tbl_usuarios SET ".$Img." WHERE fld_id=?";

					$cmd= Database::getInstance()->getDb()->prepare($Update);

					$cmd->execute(array($User));

					

					if($logo!=''){

						session_start();

						$_SESSION['Image']='<img class="rounded-circle" src="'.$Ruta.$logo.'" alt="'.$logo.'">';

					}

					

				}

				

				return array('Logo'=>$logo, 'Ruta'=>$Ruta);

				

			}catch(PDOException $e){

				return 0;

			}

		}//End Funcion

		

		//*** FUNCION RESTABLECER LA CONTRASEÑA

		public static function RestablecerClaveUser($User, $clave){

			try {

				

				$Update="UPDATE tbl_usuarios SET fld_clave=? WHERE fld_id=?";

				$cmd = Database::getInstance()->getDb()->prepare($Update);

				$cmd->execute(array($clave, $User));

				

				return 1;

			}catch(PDOException $e){

				return 0;

			}

		}// END FUNCION 

		

		//*** FUNCION BUSCAR FIRMA MEDIANTE CEDULA

		public static function BuscarFirma($cc){

			try {

				session_start();

				$User=$_SESSION['IDe'];

				

				$Buscar="SELECT u.fld_id as id, concat_ws(' ', a.fld_per_Pnombre, a.fld_per_Snombre, a.fld_per_Papellido, a.fld_per_Sapellido) as nombre, u.fld_firma as firma FROM tbl_afiliacion a INNER JOIN tbl_usuarios u ON a.fld_id=u.fld_IDempleado WHERE a.fld_per_identificacion=? AND a.fld_IDempresa=?";

				$cmd = Database::getInstance()->getDb()->prepare($Buscar);

				$cmd->execute(array($cc, $User));

				$row=$cmd->fetch();

				

				if($row){

					$Ruta=Database::RutaPerfil();

					

					return array('validacion'=>'OK', 'Campos'=>$row, 'Ruta'=>$Ruta);

				}else{

					return array('validacion'=>'Error');

				}

				

			}catch(PDOException $e){

				return 0;

			}

		}// END FUNCION

		

		//*** FUNCION CAMBIAR FORMATO DE FECHA

		public static function FormatoFecha($fecha){

			 $Name=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Aagosto','Septiembre','Octubre','Noviembre','Diciembre');



			 $f=explode('-',$fecha);



			 return $f[0].' '.$Name[$f[1]].' '.$f[2];



		}// END FUNCION 

		

		//*** FUNCION RESTAR FECHA

		public static function RestarDias($FechaI,$FechaF){



		  $dias	= (strtotime($FechaI)-strtotime($FechaF))/86400;



		  $dias = abs($dias); $dias = floor($dias);		



		  return $dias;



	  }// END FUNCTION 

		

	//*** FUNCION BUSCAR CIUDAD

	public static function BuscarCiudad($dpto){

		try {





			$Buscar="SELECT m.fld_id, m.fld_codigo, m.fld_nombre, d.fld_codigo FROM tbl_municipios m INNER JOIN tbl_departamento d ON m.fld_departamento=d.fld_id WHERE m.fld_estado=1 AND m.fld_departamento=? ORDER BY m.fld_nombre ASC";

			$cmd = Database::getInstance()->getDb()->prepare($Buscar);

			$cmd->execute(array($dpto));

			$row=$cmd->fetchAll();

			$Num=$cmd->rowCount();

			

			

			

			if($Num>0){



				return array('validacion'=>'OK', 'Campos'=>$row);

			}else{

				return array('validacion'=>'Error');

			}



		}catch(PDOException $e){

			return 0;

		}

	}// END FUNCION 

		

	

		//*** FUNCION BUSCAR LISTADO DE PUNTOS DE EMPRESAS

	public static function ListadoPuntos($nombre, $page){



		$onclic="puntos";

		include 'pagination.php'; 

		$per_page = 15; 

		$adjacents  = 4; 

		$offset = ($page - 1) * $per_page;



		session_start();

		$User=$_SESSION['IDe'];



		if($nombre!=''){

			$nombre=" AND (c.fld_empresa LIKE '%".$nombre."%' OR c.fld_representante LIKE '%".$nombre."%' OR c.fld_nit LIKE '%".$nombre."%' OR c.fld_codigo LIKE '%".$nombre."%' OR u.fld_nombre LIKE '%".$nombre."%') ";

		}else{

			$nombre=" ";

		}



		$Empresa=" c.fld_IDempresa=? ";

		$WHERE=" WHERE ".$Empresa.$nombre;



		$BuscarW="SELECT count(*) AS numrows FROM tbl_clientes_ubicacion u INNER JOIN tbl_clientes c ON u.fld_IDcliente=c.fld_id ".$WHERE." ORDER BY u.fld_id DESC";



		try {



			$buscador = Database::getInstance()->getDb()->prepare($BuscarW);

			$buscador->execute(array($User));



			$resul = $buscador->fetch();

			$numrows = $resul[0];

			$total_pages = ceil($numrows/$per_page);

			$reload = 'areas.php';



			$navegador='<tr><td colspan="4"><h6>Mostrando un total de '.$numrows.' registro(s)</h6></td></tr>

			<tr><td colspan="4">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';



			$Consulta="SELECT u.fld_id as id, c.fld_empresa as empresa, u.fld_nombre as nombre FROM tbl_clientes_ubicacion u INNER JOIN tbl_clientes c ON u.fld_IDcliente=c.fld_id ".$WHERE." ORDER BY u.fld_id DESC LIMIT $offset,$per_page";



			// Preparar sentencia

			$comando = Database::getInstance()->getDb()->prepare($Consulta);

			$comando->execute(array($User));

			$row = $comando->fetchAll(PDO::FETCH_ASSOC);



			$array = array(

				"busqueda" => $row,

				"paginacion" =>$navegador,

				"cantidad" => $numrows

			);



			return $array;



		}catch (PDOException $e){

			return 0;

		}



	}// END FUNCION 

		

	//*** FUCION BUSCAR TODOS LOS CLIENTES

	public static function BuscarClientes(){

		try {

			

			session_start();

			$User=$_SESSION['IDe'];



			$Buscar="SELECT fld_id, fld_empresa FROM tbl_clientes WHERE fld_IDempresa=? ORDER BY fld_empresa ASC";

			$cmd = Database::getInstance()->getDb()->prepare($Buscar);

			$cmd->execute(array($User));

			$row=$cmd->fetchAll();

			$Num=$cmd->rowCount();

			

			

			if($Num>0){



				return array('validacion'=>'OK', 'Campos'=>$row);

			}else{

				return array('validacion'=>'Error');

			}



		}catch(PDOException $e){

			return 0;

		}

	}// END FUNCION

		

	//*** FUNCION AGREGAR PUNTO

	public static function AgregarPunto($cliente, $ubicacion){



		//Buscar el codigo

		$Consultar="SELECT fld_id FROM tbl_clientes_ubicacion WHERE fld_nombre=? AND fld_IDcliente=?";



		try {

			$sql = Database::getInstance()->getDb()->prepare($Consultar);

			$sql->execute(array($ubicacion, $cliente));

			$Num=$sql->rowCount();



			if($Num==0){



				$Insert="INSERT INTO tbl_clientes_ubicacion (fld_IDcliente, fld_nombre) VALUES (?,?)";

				$cmd = Database::getInstance()->getDb()->prepare($Insert);

				$cmd->execute(array($cliente, $ubicacion));



				return array('validacion'=>'OK');

			}else{

				return array('validacion'=>'Error', 'mensaje'=>'El punto '.$ubicacion.' ya existe para este cliente, ingrese otro.');

			}



		}catch(PDOException $e){

			return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

		}

	}// END FUNCION 

		

	//*** FUNCION ACTUALIZAR PUNTO 

	public static function ActualizarPunto($id, $cliente, $ubicacion){



		//Buscar el codigo

		$Consultar="SELECT fld_id FROM tbl_clientes_ubicacion WHERE fld_nombre=? AND fld_IDcliente=? AND fld_id!=?";



		try {

			$sql = Database::getInstance()->getDb()->prepare($Consultar);

			$sql->execute(array($ubicacion, $cliente, $id));

			$Num=$sql->rowCount();



			if($Num==0){



				$UPDATE="UPDATE tbl_clientes_ubicacion SET fld_IDcliente=?, fld_nombre=? WHERE fld_id=?";

				$cmd = Database::getInstance()->getDb()->prepare($UPDATE);

				$cmd->execute(array($cliente, $ubicacion, $id));



				return array('validacion'=>'OK');

			}else{

				return array('validacion'=>'Error', 'mensaje'=>'El punto '.$ubicacion.' ya existe para este cliente, ingrese otro.');

			}



		}catch(PDOException $e){

			return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

		}

	}// END FUNCION 

		

	//*** FNCION BUSCAR CLIENTE DONDE ALMACENAR

	public static function BuscarClienteAlmacenar($cliente){

		try {



			session_start();

			$User=$_SESSION['IDe'];

			

			

			$Buscar="SELECT u.fld_id, u.fld_nombre FROM tbl_clientes_ubicacion u INNER JOIN tbl_clientes c ON u.fld_IDcliente=c.fld_id WHERE u.fld_IDcliente=? AND c.fld_IDempresa=?";

			$cmd = Database::getInstance()->getDb()->prepare($Buscar);

			$cmd->execute(array($cliente, $User));

			$row=$cmd->fetchAll();

			$Num=$cmd->rowCount();



			if($Num>0){



				return array('validacion'=>'OK', 'Campos'=>$row);

			}else{

				return array('validacion'=>'Error');

			}



		}catch(PDOException $e){

			return 0;

		}

	}// END FUNCION 

		

	//*** FUNCION SUBIR GESTION DE DATOS CLIENTE

	public static function SubirGestionCliente($IDempresa, $IDacceso, $cliente, $almacenar, $radicado, $identificacion, $nombre, $proceso, $documento, $editar){

		
		try {

			

			//**** Buscamos si ya existe *****
			$Buscar="SELECT fld_id FROM tbl_gestion WHERE fld_radicado=? AND fld_IDempresa=?";
			$cmdB= Database::getInstance()->getDb()->prepare($Buscar);
			$cmdB->execute(array($radicado, $IDempresa));
			$Cantidad=$cmdB->rowCount();
			
			//Buscamos proceso y el tipo documento
			$Consultar="SELECT p.fld_nombre as proceso, d.fld_nombre as documento FROM tbl_procesos p INNER JOIN tbl_tipo_documentos d ON p.fld_id=d.fld_IDproceso WHERE p.fld_id=? AND d.fld_id=?";
			$sqlb= Database::getInstance()->getDb()->prepare($Consultar);
			$sqlb->execute(array($proceso, $documento));
			$rws=$sqlb->fetch(PDO::FETCH_ASSOC);
			
			if($Cantidad==0){ //Validamos que no exista
				
				$Insert="INSERT INTO tbl_gestion (fld_IDempresa, fld_cliente, fld_almacenado, fld_radicado, fld_identificacion, fld_nombre, fld_registro) VALUES (?,?,?,?,?,?,now())";
				$cmd= Database::getInstance()->getDb()->prepare($Insert);
				$cmd->execute(array($IDempresa, $cliente, $almacenar, $radicado, $identificacion, $nombre));
				
				//Buscar el ultimo Idp creado
				$Buscar="SELECT fld_id FROM tbl_gestion WHERE fld_IDempresa=? AND fld_cliente=? AND fld_almacenado=? ORDER BY fld_id DESC LIMIT 1";
				$Sql= Database::getInstance()->getDb()->prepare($Buscar);
				$Sql->execute(array($IDempresa, $cliente, $almacenar));
				$row = $Sql->fetch();
				$IDp=$row[0];
				
				//Historial
				Proceso::HistorialUsuario($IDempresa, $IDacceso, 'REGISTRO', '<b>Radicado</b> ('.$radicado.')');
				//Historial
				Proceso::HistorialUsuario($IDempresa, $IDacceso, 'NUEVO', '<b>Archivo</b> ('.$rws['proceso'].') ('.$rws['documento'].') Radicado ('.$radicado.')');
				
	
			}else{
				
				$Row=$cmdB->fetch();
				$IDp=$Row[0];
				
				if($editar==1){
					$Actualiza=", fld_identificacion=$identificacion, fld_nombre='$nombre' ";
					//Historial
					Proceso::HistorialUsuario($IDempresa, $IDacceso, 'ACTUALIZACIÓN', 'Datos Demandante ('.$nombre.') ('.$identificacion.') Radicado ('.$radicado.')');
				}else{
					$Actualiza="";
				}
				
				$Update="UPDATE tbl_gestion SET fld_registro=now() $Actualiza WHERE fld_id=?";
				$cmd= Database::getInstance()->getDb()->prepare($Update);
				$cmd->execute(array($IDp));
				
				//Historial
				Proceso::HistorialUsuario($IDempresa, $IDacceso, 'NUEVO', '<b>Archivo</b> ('.$rws['proceso'].') ('.$rws['documento'].') Radicado ('.$radicado.')');
			}
			
			
			
				
			return array('validacion'=>'OK', 'ID'=>$IDp);

		}catch(PDOException $e){

			return array('validacion'=>'Error', 'mensaje'=>$e->getMessage());

		}

		

	}// END FUNCION

		
	//************** FUNCION GUARDAR HISTORIAL **************
	public static function HistorialUsuario($User, $Usuario, $Proceso, $Accion){
		try{
			
			$Insert="INSERT INTO tbl_historial (fld_IDempresa, fld_proceso, fld_accion, fld_usuario, fld_fecha) VALUES(?,?,?,?,now())";
			$cmd= Database::getInstance()->getDb()->prepare($Insert);
			$cmd->execute(array($User, $Proceso, $Accion, $Usuario));
			
			return array('Validacion'>='OK');
			
		}catch(PDOException $e){
			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());
		}
	}// END FUNCION
	

	//** FUNCION BUSCAE LISTADO

	public static function ListadoEntrega($buscar, $cliente, $fechaI, $fechaF, $page){

		
		
		$onclic="load";
		$Group="  ";
		

		include 'pagination.php'; 

		$per_page = 15; 

		$adjacents  = 4; 

		$offset = ($page - 1) * $per_page;



		session_start();

		$User=$_SESSION['IDe'];



		if($buscar!=''){

			$buscar=" AND (c.fld_nombre LIKE '%".$buscar."%' OR c.fld_cedula LIKE '%".$buscar."%' OR u.fld_nombre LIKE '%".$buscar."%')";

		}else{

			$buscar=" ";

		}

		if($cliente!=''){

			$cliente=" AND e.fld_IDpersona=".$cliente;

		}else{

			$cliente="";

		}


		if($fechaI!='' && $fechaF!=''){

			$fecha=" AND DATE_FORMAT(e.fld_registro, '%Y-%m-%d') BETWEEN '$fechaI' AND '$fechaF' ";

		}else{

			$fecha=" ";

		}
		
		if($especial==1){
			$radicado=" AND g.fld_radicado=".$ID;
		}else{
			$radicado="";
		}



		$Empresa=" e.fld_IDempresa=? ";

		$WHERE=" WHERE ".$Empresa.$buscar.$cliente.$almacenar.$fecha.$radicado;



		$BuscarW="SELECT count(*) AS numrows FROM tbl_entrega e INNER JOIN tbl_clientes c ON e.fld_IDpersona=c.fld_id INNER JOIN tbl_usuarios u ON e.fld_IDuser=u.fld_id  ".$WHERE." ORDER BY e.fld_id DESC";



		try {

			$buscador = Database::getInstance()->getDb()->prepare($BuscarW);
			$buscador->execute(array($User));
			$resul = $buscador->fetch();
			$numrows = $resul[0];
			//$numrows = $buscador->rowCount();

			$total_pages = ceil($numrows/$per_page);

			$reload = 'afiliacion.php';



			$navegador='<tr><td colspan="3"><h6>Mostrando un total de '.$numrows.' registros</h6></td>

			<td colspan="4">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';



			$Consulta="SELECT e.fld_id as id, c.fld_cedula as cedula, c.fld_nombre as persona, DATE_FORMAT(e.fld_registro, '%d-%c-%Y*%h:%i %p') as registro, e.fld_observaciones as observacion, u.fld_nombre as usuario, ca.fld_nombre as Categoria, e.fld_soporte as Soporte FROM tbl_entrega e INNER JOIN tbl_clientes c ON e.fld_IDpersona=c.fld_id INNER JOIN tbl_usuarios u ON e.fld_IDuser=u.fld_id INNER JOIN tbl_categorias ca ON e.fld_IDcategoria=ca.fld_id $WHERE ORDER BY e.fld_id DESC LIMIT $offset,$per_page";



			// Preparar sentencia

			$comando = Database::getInstance()->getDb()->prepare($Consulta);

			$comando->execute(array($User));

			$row = $comando->fetchAll(PDO::FETCH_ASSOC);


			$LINK=Database::LinkSoporte();


			$array = array(
				"Validacion" => 'OK',
				"busqueda" => $row,
				"paginacion" =>$navegador,
				"cantidad" => $numrows,
				"Link" => $LINK
			);

			return $array;

		}catch (PDOException $e){

			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());

		}



	}// END FUNCION 

		

	//** FUNCION ELIMMINAR GESTION DE ARCHIVO

	public static function EliminarEntrega($id){
		try {

			$Consultar="SELECT c.fld_nombre as nombre FROM tbl_entrega e INNER JOIN tbl_clientes c ON e.fld_IDpersona=c.fld_id WHERE e.fld_id=?";
			$sql = Database::getInstance()->getDb()->prepare($Consultar);
			$sql->execute(array($id));
			$row=$sql->fetch();
			
			$Eliminar="DELETE FROM tbl_entrega WHERE fld_id=?";
			$delete = Database::getInstance()->getDb()->prepare($Eliminar);
			$delete->execute(array($id));

			session_start();
			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];
			
			//Historial
			Proceso::HistorialUsuario($User, $UserP, 'ELIMINACIÓN', '<b>Entrega Alimento</b> Persona ('.$row[0].')');

			return 1;

		}catch(PDOException $e){

			return 0;

		}

	}// END FUNCION 

		

	//*** FUNCION BUSCAR SOPORTE

	public static function BuscarSoporteGestion($id){

		try {

			//Buscar Nombre
			$Consulta="SELECT c.fld_empresa as cliente, g.fld_nombre as demandante, g.fld_radicado as radicado, g.fld_identificacion, g.fld_registro FROM tbl_gestion g INNER JOIN tbl_clientes c ON g.fld_cliente=c.fld_id WHERE g.fld_id=? ";
			$cmd= Database::getInstance()->getDb()->prepare($Consulta);
			$cmd->execute(array($id));
			$resul=$cmd->fetch();
			return array('Name'=>$resul, 'Ruta'=>$Ruta.'/');

		}catch(PDOException $e){
			return 0;
		}

	}// END FUNCION 

		

	//*** ELIMINAR ARCHIVO DE GESTION

	public static function EliminarArchivoGestion($id){

		

		try {
			
			session_start();
			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];

			//Buscamos el nombre
			$Consultar="SELECT fld_archivo, fld_IDgestion FROM tbl_gestion_archivos WHERE fld_id=?";
			$Cmd=Database::getInstance()->getDb()->prepare($Consultar);
			$Cmd->execute(array($id));
			$row=$Cmd->fetch();
			$Ruta=Database::LinkFiles();

			if($row){

				$IDg=$row[1];
				
				if(opendir($Ruta)){
					if(file_exists($Ruta.'/'.$row[0])){
						unlink($Ruta.'/'.$row[0]);
					}
				}

				
				//*** Consultamos que radicado va eliminar
				$Buscar="SELECT g.fld_radicado, d.fld_nombre FROM tbl_gestion_archivos a INNER JOIN tbl_gestion g ON a.fld_IDgestion=g.fld_id INNER JOIN tbl_tipo_documentos d ON a.fld_tipo_documento=d.fld_id WHERE a.fld_id=?";
				$sql = Database::getInstance()->getDb()->prepare($Buscar);
				$sql->execute(array($id));
				$Rowb=$sql->fetch();
				$Radicado=$Rowb[0];
				$Archivo=$Rowb[1];
				
				
				//Eliminamos el archivo de la tabla
				$Eliminar="DELETE FROM tbl_gestion_archivos WHERE fld_id=?";
				$delete = Database::getInstance()->getDb()->prepare($Eliminar);
				$delete->execute(array($id));
				
				//Historial
				Proceso::HistorialUsuario($User, $UserP, 'ELIMINACIÓN', '<b>Archivo</b> ('.$Archivo.') | Radicado ('.$Radicado.')');
				

				return 1;

			}else{
				return 0;

			}

		}catch(PDOException $e){

			return 0;

		}

	}// END FUNCION 

		

	//** FUNCION BUSCAR RADICADO

	public static function BuscarRadicado($radicado){

		try {

			

			session_start();

			$User=$_SESSION['IDe'];

			

			$Buscar="SELECT fld_identificacion, fld_nombre FROM tbl_gestion WHERE fld_radicado=? AND fld_IDempresa=? ORDER BY fld_id DESC LIMIT 1";

			$cmd = Database::getInstance()->getDb()->prepare($Buscar);

			$cmd->execute(array($radicado, $User));

			$Num=$cmd->rowCount();

			$Row=$cmd->fetch();

			

			return array('Cantidad'=>$Num, 'Row'=>$Row);

			

		}catch(PDOException $e){

			return 0;

		}

		

	}// END FUNCION 

	

	//** FUNCION BUSCAR TIPO DOCUMENTO

	public static function BuscarTipoDocumento($proceso){

		try {





			$Buscar="SELECT fld_id, fld_nombre FROM tbl_tipo_documentos WHERE fld_IDproceso=? ORDER BY fld_nombre ASC";

			$cmd = Database::getInstance()->getDb()->prepare($Buscar);

			$cmd->execute(array($proceso));

			$row=$cmd->fetchAll();

			$Num=$cmd->rowCount();

			

			

			

			if($Num>0){



				return array('validacion'=>'OK', 'Campos'=>$row, 'Cantidad'=>$Num);

			}else{

				return array('validacion'=>'Error', 'Cantidad'=>0);

			}



		}catch(PDOException $e){

			return 0;

		}

	}//END FUNCION
		
	//**** FUNCION BUSCAR ARCHIVO MODAL GESTION DE ARCHIVOS
	public static function BuscarSoporteGestionModal($id, $proceso, $documento, $fechaI, $fechaF, $page){

	
		$onclic="RecargarModal";
		include 'pagination.php'; 

		$per_page = 15; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;

		session_start();
		$User=$_SESSION['IDe'];

		if($proceso!=''){
			$proceso=" AND g.fld_proceso=".$proceso;
		}else{
			$proceso=" ";
		}
		if($documento!=''){
			$documento=" AND g.fld_tipo_documento=".$documento;
		}else{
			$documento="";
		}

		if($fechaI!='' && $fechaF!=''){
			$fecha=" AND DATE_FORMAT(g.fld_fecha, '%Y-%m-%d') BETWEEN '$fechaI' AND '$fechaF' ";
		}else{
			$fecha=" ";
		}

		$Empresa=" g.fld_IDgestion=? ";

		$WHERE=" WHERE ".$Empresa.$proceso.$documento.$fecha;

		$BuscarW="SELECT count(*) AS numrows FROM tbl_gestion_archivos g INNER JOIN tbl_procesos p ON g.fld_proceso=p.fld_id INNER JOIN tbl_tipo_documentos d ON g.fld_tipo_documento=d.fld_id  ".$WHERE." ORDER BY g.fld_id DESC";


		try {

			$buscador = Database::getInstance()->getDb()->prepare($BuscarW);
			$buscador->execute(array($id));
			$resul = $buscador->fetch();
			$numrows = $resul[0];
			//$numrows = $buscador->rowCount();

			$total_pages = ceil($numrows/$per_page);

			$reload = 'afiliacion.php';

			$navegador='<tr><td colspan="5"><h6>Mostrando un total de '.$numrows.' archivos</h6></td></tr>
			<tr><td colspan="5">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';

			$Consulta="SELECT g.fld_id as id, g.fld_archivo as archivo, g.fld_fecha as fecha, p.fld_nombre as proceso, d.fld_nombre as documento FROM tbl_gestion_archivos g INNER JOIN tbl_procesos p ON g.fld_proceso=p.fld_id INNER JOIN tbl_tipo_documentos d ON g.fld_tipo_documento=d.fld_id ".$WHERE." ORDER BY g.fld_id DESC LIMIT $offset,$per_page";

			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($Consulta);
			$comando->execute(array($id));
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);

			$Ruta=Database::LinkFiles();
			
			$array = array(
				"busqueda" => $row,
				"paginacion" =>$navegador,
				"cantidad" => $numrows,
				"Ruta"	=> $Ruta.'/'
			);


			return $array;

		}catch (PDOException $e){
			return 0;
		}
	}// END 
		
	//*** FUNCION BUSCAR LISTADO HISTORIAL 
	public static function ListadoHistorial($nombre, $usuario, $fechaI, $fechaF, $page){

		$onclic="load";
		include 'pagination.php'; 

		$per_page = 15; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;

		session_start();
		$User=$_SESSION['IDe'];

		if($nombre!=''){
			$nombre=" AND (h.fld_proceso LIKE '%".$nombre."%' OR h.fld_accion LIKE '%".$nombre."%') ";
		}else{
			$nombre=" ";
		}

		if($usuario!=''){
			$usuario=" AND h.fld_usuario=$usuario";
		}else{
			$usuario=" ";
		}
		
		if($fechaI!='' && $fechaF!=''){
			$fecha=" AND DATE_FORMAT(h.fld_fecha, '%Y-%m-%d') BETWEEN '$fechaI' AND '$fechaF' ";
		}else{
			$fecha=" ";
		}

		$Empresa=" h.fld_IDempresa=? ";

		$WHERE=" WHERE ".$Empresa.$nombre.$usuario.$fecha;

		$BuscarW="SELECT count(*) AS numrows FROM tbl_historial h INNER JOIN tbl_usuarios u ON h.fld_usuario=u.fld_id ".$WHERE." ORDER BY h.fld_id DESC";

		try {


			$buscador = Database::getInstance()->getDb()->prepare($BuscarW);
			$buscador->execute(array($User));
			$resul = $buscador->fetch();
			$numrows = $resul[0];
			$total_pages = ceil($numrows/$per_page);
			$reload = 'areas.php';

			$navegador='<tr><td colspan="5"><h6>Mostrando un total de '.$numrows.' registro(s)</h6></td></tr>
			<tr><td colspan="5">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';

			$Consulta="SELECT u.fld_nombre as nombre, h.fld_proceso as proceso, h.fld_accion as accion, h.fld_fecha as fecha FROM tbl_historial h INNER JOIN tbl_usuarios u ON h.fld_usuario=u.fld_id ".$WHERE." ORDER BY h.fld_id DESC LIMIT $offset,$per_page";

			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($Consulta);
			$comando->execute(array($User));
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);

			$array = array(
				"busqueda" => $row,
				"paginacion" =>$navegador,
				"cantidad" => $numrows
			);

			return $array;

		}catch (PDOException $e){

			return 0;

		}
	}// END FUNCION 

	//*** FUNCION BUSCAR CEDULA
	public function BuscarCedula($cc, $IDempresa){
		try{

			$Buscar="SELECT fld_id, fld_nombre FROM tbl_clientes WHERE fld_cedula=? AND fld_IDempresa=?";
			$sql = Database::getInstance()->getDb()->prepare($Buscar);
			$sql->execute(array($cc, $IDempresa));
			$row = $sql->fetch();
			$Cantidad=$sql->rowCount();

			return array('Validacion'=>'OK', 'Cantidad'=>$Cantidad, 'Row'=>$row);

		}catch (PDOException $e){
			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());
		}
	}// END FUCNIN

	//*** FUNCION BUSCAR EL TIPO DE ARCHIVO
	public static function TipoDocumento($Tipo){
		try{

			$Doc=explode(".", $Tipo);
			$TipoDocumento='';
			foreach ($Doc as $key){
				$TipoDocumento=$key;
			}//End for

			return $TipoDocumento;

		}catch(PDOException $e){
			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());
		}
	}// END FUNION

	//*** FUNCION GUARDAR LA ENTREGA DE ALIMENTO
	public function GuardarEntregaAlimento($IDacceso, $IDempresa, $IDpersona, $identificacion, $nombre, $Categoria, $observaciones, $Soporte_file, $Sopote_Archivo){
		try{

			$RutaCedula=Database::RutaCedula();
			$RutaSoporte=Database::RutaSoporte();

			$tipo=Proceso::TipoDocumento($Soporte_file);
			$logo=rand().'.'.$tipo;

			if(move_uploaded_file($Sopote_Archivo, $RutaSoporte.$logo)){
				$Proceso2=1;
			}else{
				$Proceso2=0;
			}


			//Si la persona no existe la guardamos
			if($IDpersona==0){
				$Insert="INSERT INTO tbl_clientes (fld_IDempresa, fld_nombre, fld_cedula, fld_registro, fld_IDuser) VALUES(?,?,?,now(),?)";
				$sql = Database::getInstance()->getDb()->prepare($Insert);
				$sql->execute(array($IDempresa, $nombre, $identificacion, $IDacceso));

				$cmd=Database::getInstance()->getDb()->prepare("SELECT LAST_INSERT_ID() FROM tbl_clientes WHERE fld_IDuser=?");
				$cmd->execute(array($IDacceso));
				$IDpersona = $cmd->fetchColumn();

				//Historial
				Proceso::HistorialUsuario($IDempresa, $IDacceso, 'NUEVO', '<b>Persona</b> ('.$nombre.')');
			}


			//*** Registramos la entrega
			$Insert="INSERT INTO tbl_entrega (fld_IDempresa, fld_IDuser, fld_IDpersona, fld_IDcategoria, fld_registro, fld_observaciones, 	fld_soporte) VALUES(?,?,?,?,now(),?,?)";
			$sql = Database::getInstance()->getDb()->prepare($Insert);
			$sql->execute(array($IDempresa, $IDacceso, $IDpersona, $Categoria, $observaciones, $logo));

			//Historial
			Proceso::HistorialUsuario($IDempresa, $IDacceso, 'ENTREGA ALIMENTO', '<b>Persona</b> ('.$nombre.')');

			return array('Validacion'=>'OK');


		}catch(PDOException $e){
			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());
		}
	}// END FUCNION 


	//*** FUNCION AGREGAR CATEGORIA
	public static function AgregarCategoria($nombre){
		try {

			session_start();
			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];
		

			//Buscar el codigo
			$Consultar="SELECT fld_id FROM tbl_categorias WHERE fld_IDempresa=? AND fld_nombre=?";
			$sql = Database::getInstance()->getDb()->prepare($Consultar);
			$sql->execute(array($User, $nombre));
			$Num=$sql->rowCount();

			if($Num==0){

				
				$Insert="INSERT INTO tbl_categorias (fld_IDempresa, fld_nombre, fld_fecha) VALUES (?,?,now())";
				$cmd = Database::getInstance()->getDb()->prepare($Insert);
				$cmd->execute(array($User, $nombre));

				//Historial
				Proceso::HistorialUsuario($User, $UserP, 'NUEVO', '<b>TIPO ALIMENTO</b> ('.$nombre.')');


				return array('validacion'=>'OK');

			}else{

				return array('validacion'=>'Error', 'mensaje'=>'El tipo de alimento '.$nombre.' ya existe, ingrese otro.');

			}



		}catch(PDOException $e){

			return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

		}

	}// END FUNCION 

	//*** FUNCION BUSCAR LISTADO DE CATEGORIAS
	public static function ListadoCategorias($nombre, $page){
		try {

			$onclic="load";
			include 'pagination.php'; 

			$per_page = 15; 
			$adjacents  = 4; 
			$offset = ($page - 1) * $per_page;

			session_start();

			$User=$_SESSION['IDe'];

			

			if($nombre!=''){

				$nombre=" AND (fld_nombre LIKE '%".$nombre."%') ";

			}else{

				$nombre=" ";

			}


			$Empresa=" fld_IDempresa=? ";

			$WHERE=" WHERE ".$Empresa.$nombre;


			$BuscarW="SELECT count(*) AS numrows FROM tbl_categorias $WHERE ORDER BY fld_nombre ASC";
			$buscador = Database::getInstance()->getDb()->prepare($BuscarW);
			$buscador->execute(array($User));

			$resul = $buscador->fetch();
			$numrows = $resul[0];
			$total_pages = ceil($numrows/$per_page);
			$reload = 'areas.php';

			$navegador='<tr><td colspan="3"><h6>Mostrando un total de '.$numrows.' registro(s)</h6></td>

			<td colspan="4">'.paginate($reload, $page, $total_pages, $adjacents,$onclic).'</td></tr>';



			$Consulta="SELECT fld_id as id, fld_nombre as nombre, DATE_FORMAT(fld_fecha, '%d-%c-%Y*%h:%i %p') as fecha FROM tbl_categorias $WHERE ORDER BY fld_nombre ASC LIMIT $offset,$per_page";

		

			// Preparar sentencia

			$comando = Database::getInstance()->getDb()->prepare($Consulta);

			$comando->execute(array($User));

			$row = $comando->fetchAll(PDO::FETCH_ASSOC);

			

			$array = array(

				"busqueda" => $row,

				"paginacion" =>$navegador,

				"cantidad" => $numrows

			);

			

			return $array;

			

		}catch (PDOException $e){

			return 0;

   		}
	}// END FUNCION 

	
	//*** FUNCION ELIMINAR CATEGORIA
	public static function EliminarCategoria($id){

		try {
			
			session_start();
			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];

			$Consultar="SELECT fld_nombre, fld_id FROM tbl_categorias WHERE fld_id=?";
			$cmd = Database::getInstance()->getDb()->prepare($Consultar);
			$cmd->execute(array($id));
			$rowB=$cmd->fetch();

			//** Consultamos si tiene registro
			$Buscar="SELECT fld_id FROM tbl_entrega WHERE fld_IDcategoria=? AND fld_IDempresa=?";
			$sql = Database::getInstance()->getDb()->prepare($Buscar);
			$sql->execute(array($rowB[1], $User));
			$Cantidad=$sql->rowCount();

			if($Cantidad==0){
				
				$Eliminar="DELETE FROM tbl_categorias WHERE fld_id=?";
				$delete = Database::getInstance()->getDb()->prepare($Eliminar);
				$delete->execute(array($id));

				//Historial
				Proceso::HistorialUsuario($User, $UserP, 'ELIMINACIÓN', '<b>Tipo Alimento</b> ('.$rowB[0].') ');


				return array('Validacion'=>'OK');

			}else{
				return array('Validacion'=>'Error', 'Mensaje'=>'No se puede eliminar este tipo de alimento porque tiene registro de entraga de alimento.');
			}

		}catch (PDOException $e){

			return array('Validacion'=>'Error', 'Mensaje'=>$e->getMessage());

   		}

	}// END FUCNION


	//*** FUNCION BUSCAR INFORMACION CATEGORIA
	public static function InformacionCategoria($id){

		try {

			
			$Buscar="SELECT fld_nombre FROM tbl_categorias WHERE fld_id=?";
			$cmd = Database::getInstance()->getDb()->prepare($Buscar);
			$cmd->execute(array($id));
			$row=$cmd->fetch();

			

			return $row;

			

		}catch(PDOException $e){

			return 0;

		}
	}//End funcion

	
	//*** FUNCION ACTUAIZAR CATEGORIA
	public static function ActualizarCategoria($id, $nombre){
		try {
			
			session_start();
			$User=$_SESSION['IDe'];
			$UserP=$_SESSION['IDp'];
			
			//Buscar el codigo
			$Consultar="SELECT fld_id FROM tbl_categorias WHERE fld_nombre=? AND fld_id!=? AND fld_IDempresa=?";
			$sql = Database::getInstance()->getDb()->prepare($Consultar);
			$sql->execute(array($nombre, $id, $User));
			$Num=$sql->rowCount();


			if($Num==0){

				
				$Update="UPDATE tbl_categorias SET fld_nombre=? WHERE fld_id=?";
				$cmd = Database::getInstance()->getDb()->prepare($Update);
				$cmd->execute(array($nombre, $id));
				
				//Historial
				Proceso::HistorialUsuario($User, $UserP, 'ACTUALIZACIÓN', '<b>Tipo Alimento</b> ('.$nombre.')');


				return array('validacion'=>'OK');

			}else{

				return array('validacion'=>'Error', 'mensaje'=>'El tipo de alimento '.$nombre.' ya existe, ingrese otro.');

			}

		

		}catch(PDOException $e){

			return array('validacion'=>'Error', 'mensaje'=>'Error '.$e->getMessage());

		}

	}// END FUNCION 

	//*** FUNCION BUSCAR LOS TIPOS DE ALIMENTOS
	public static function BuscarTiposAlimentos(){
		try{

			session_start();
			$User=$_SESSION['IDe'];

			$Buscar="SELECT fld_id, fld_nombre FROM tbl_categorias WHERE fld_IDempresa=? ORDER BY fld_nombre ASC";
			$cmd = Database::getInstance()->getDb()->prepare($Buscar);
			$cmd->execute(array($User));
			$row=$cmd->fetchAll();
			$Cantidad=$cmd->rowCount();

			return array('validacion'=>'OK', 'row'=>$row, 'Cantidad'=>$Cantidad);

		}catch(PDOException $e){
			return array('validacion'=>'Error', 'Mensaje'=>'Error '.$e->getMessage());
		}
	}// END FUCNION 

}// END CLASS



?>