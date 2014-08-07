<?php

namespace MisLibrerias;

use Zend\Debug\Debug;

class ConnectDataBaseService extends \PDO {

	private $dsn = "";
	
	public function __construct($database) {
		
		$config = new \Zend\Config\Reader\Ini(); 
		$data = $config->fromFile(  getcwd() . "/config/config-multiple-databases.ini");
		
		if($database == "postgresqlSeguridad"){
			$host = $data['postgresqlSeguridad']['host'];
			$port = $data['postgresqlSeguridad']['port'];
			$dbname = $data['postgresqlSeguridad']['dbname'];
			$user = $data['postgresqlSeguridad']['user'];
			$password = $data['postgresqlSeguridad']['password'];
			
			$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

		}elseif ($database == "mysql"){
			$host = $data['mysql']['host'];
			$dbname = $data['mysql']['dbname'];
            $user = $data['mysql']['username'];
			$password = $data['mysql']['password'];
			
			$dsn = "mysql:host=$host;dbname=$dbname";
			
		}
		
		//Debug::dump($dsn);
		
		try {
			$this->dsn = $dsn;
			parent::__construct ( $this->dsn, $user, $password );
			$this->setAttribute ( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			 	
			//new \PDO($this->dsn, $username, $password);
			//new \PDO("mysql:host=localhost;port=3306;dbname=encuesta_bd", $username, $password);
		
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	

	//**** FUNCIONES BASICAS DE CONSULTA
// 	function fetchAssoc($sql) {

// 		try {
// 			$fetchMode = PDO::FETCH_ASSOC;
// 			$stmt = $this->query ( $sql );
// 			while ( $result = $stmt->fetch ( $fetchMode ) ) {
// 				$reg = array ();
// 				foreach ( $result as $fieldname => $fieldvalue ) {
// 					$a = array ();
// 					$a [strtolower ( $fieldname )] = trim(utf8_encode($fieldvalue));
// 					$reg = $reg + $a;
// 				}
// 				$registros [] = $reg;
// 			}
// 			return $registros;
				
// 		} catch (Exception $e) {
// 			App_Helpers_General::mostrarMensaje(App_Helpers_Constantes::MENSAJE_ERROR_SISTEMA, "ERROR");
// 			App_Helpers_General::logger($e);
// 		}
// 	}
	
// 	/* funciones utilitarias */
	
// 	function _getAsRow($sql, $i = 0) {
// 		try {
// 			$sth = $this->query ( $sql );
// 			$arr = $sth->fetchAll ();
// 			$out = array ();
// 			foreach ( $arr as $row ) {
// 				$out [] = $row [$i];
// 			}
// 			return array (1, $out );
// 		} catch ( Exception $e ) {
// 			App_Helpers_General::mostrarMensaje(App_Helpers_Constantes::MENSAJE_ERROR_SISTEMA, "ERROR");
// 			App_Helpers_General::logger($e);
// 		}
// 	}
	
	// Obtener todos los datos devueltos por la consulta
	function _getRows($sql) {
		try {
			$sth = $this->query ( $sql );
			return $sth->fetchAll ( \PDO::FETCH_ASSOC );
		} catch ( \Exception $e ) {
			throw new \Exception($e->getMessage());
		}
	}
	
// 	/* Ejecutar una consulta que no devuelve datos, queremos que las filas afectadas en lugar */
// 	function boolQuery($sql) {
// 		try {
// 			$sth = $this->query ( $sql );
// 			return array (1, $sth->rowCount );
// 		} catch ( Exception $e ) {
// 			App_Helpers_General::mostrarMensaje(App_Helpers_Constantes::MENSAJE_ERROR_SISTEMA, "ERROR");
// 			App_Helpers_General::logger($e);
// 		}
// 	}
	
// 	/* retorna la estructura del error en excepcion */
// 	private function _err($e) {
// 		return array (0, $e->getMessage () );
// 	}
	
// 	// dumper
// 	function _dump($data) { // pass in $_GET, etc
// 		$args = func_get_args ();
// 		if (count ( $args ) > 1) {
// 			return "\n<pre>\n" . print_r ( $args, 1 ) . "\n</pre>\n";
// 		} else {
// 			return "\n<pre>\n" . print_r ( $data, 1 ) . "\n</pre>\n";
// 		}
// 	}
	
// 	function errorDescripcion($e) {
// 		return "<h3>OCURRIO UN ERROR DE CONSULTA:</h3>" . "<br/>" .
// 		       "<strong>DESCRIPCION:</strong> " . $e->getMessage () . "<br/>" . 
// 		       "<strong>CODIGO:</strong> " . $e->getCode () . "<br/>" . 
// 		       "<strong>ARCHIVO:</strong> " . $e->getFile () . "<br/>" . 
// 		       "<strong>LINEA:</strong> " . $e->getLine () . "<br/>";
// 			   //"BACKTRACE: ". $e->getTrace() ;
// 			   //var_dump($e->getTrace());
// 	}

// 	/**
// 	 * Ejecucion de un SQL directo
// 	 */
// 	function _exec($sql) {
// 		try {
// 			$sth = $this->exec($sql);
// 			return $sth;
// 		} catch ( Exception $e ) {
// 			//App_Helpers_General::mostrarMensaje(App_Helpers_Constantes::MENSAJE_ERROR_SISTEMA, "ERROR");
// 			App_Helpers_General::logger($e);
// 		}
// 	}	
	
}

?>
