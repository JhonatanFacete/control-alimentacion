<?php



//*********** CONEXION ADMINISTRADOR ******

class Database{

    /**

     * Única instancia de la clase

     */

    private static $db = null;

    /**

     * Instancia de PDO

     */

    private static $pdo;



    final private function __construct()

    {

        try {

            // Crear nueva conexión PDO

            self::getDb();

        } catch (PDOException $e) {

            // Manejo de excepciones

        }

    }

	

	public static function LinkFiles(){

		return '../documentos';

	}

	

	//*** FUNCION RUTA IMAGEN USER

	public static function RutaPerfil(){

		return '../img/perfil/';

	}

	public static function RutaEmpresa(){
		return '/home/centermentassess/public_html/entrega/img/empresa/';
	}

    public static function RutaCedula(){
        return '/home/centermentassess/public_html/entrega/img/cedula/';
    }

    public static function RutaSoporte(){
        return '/home/centermentassess/public_html/entrega/img/soportes/';
    }

    public static function LinkSoporte(){
        return 'https://assessmentcentersonline.com/entrega/img/soportes/';
    }


	

    public static function getInstance()

    {

        if (self::$db === null) {

            self::$db = new self();

        }

        return self::$db;

    }

	

    public function getDb(){

		

		

        if (self::$pdo == null) {

			

			define("HOSTNAMEA", "localhost");

			define("DATABASEA", "xxx"); 

			define("USERNAMEA", "xxx"); 

			define("PASSWORDA", "xxx"); 

				

            self::$pdo = new PDO(

                'mysql:dbname=' . DATABASEA .

                ';host=' . HOSTNAMEA .

                ';port:63343;', // Eliminar este elemento si se usa una instalación por defecto

                USERNAMEA,

                PASSWORDA,

                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")

            );



            // Habilitar excepciones

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }



        return self::$pdo;

    }

	



    final protected function __clone()

    {

    }



    function _destructor()

    {

        self::$pdo = null;

    }

}

?>