<?php
namespace MisLibrerias;

use Zend\Session\Container;
class DatosSesion{
	
	
	static function getPerfiles() {
		$session = new Container('datos_sesion');
		//$sessionData = $session->datos_sesion["rol"] ;
	
		if(isset($session->datos_sesion["lista_perfiles"])){
				
			$option = "<select id='id_perfil'>";
			foreach ($session->datos_sesion["lista_perfiles"] as $id=>$perfil){
				$option .= "<option id='$id'>$perfil</option>";
			}
			$option .= "</select>";
				
			return $option;
		}else{
			return "Invitado";
		}
	}
	
	public static function getRol() {
	
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["id_rol"])){
			return $session->datos_sesion["id_rol"];
		}else{
			return "Invitado";
		}
	}
	
	static function getPerfil() {
		$session = new Container('datos_sesion');
		//$sessionData = $session->datos_sesion["rol"] ;
	
		if(isset($session->datos_sesion["nombre_rol"])){
			return $session->datos_sesion["nombre_rol"];
		}else{
			return "NOMBRE_PERFIL";
		}
	}
	
	static function getNombreRol() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["nombre_rol"])){
			return $session->datos_sesion["nombre_rol"];
		}else{
			return "Invitado";
		}
	}	
	
	static function getSiglaPerfil() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["sigla_rol"])){
			return $session->datos_sesion["sigla_rol"];
		}else{
			return "SIGLA_PERFIL";
		}
	}
	
	static function getSiglaAplicacion() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["sigla_aplicacion"])){
			return $session->datos_sesion["sigla_aplicacion"];
		}else{
			return "Sigla Aplicacion";
		}
	}
	
	static function getAplicacion() {
		$session = new Container('datos_sesion');
		//$sessionData = $session->datos_sesion["nombre_aplicacion"] ;
	
		if(isset($session->datos_sesion["nombre_aplicacion"])){
			return $session->datos_sesion["nombre_aplicacion"];
		}else{
			return "NOMBRE APLICACION";
		}
	}
	
	static function getUrlAplicacion() {
		$session = new Container('datos_sesion');
		//$sessionData = $session->datos_sesion["nombre_aplicacion"] ;
	
		if(isset($session->datos_sesion["url"])){
			return $session->datos_sesion["url"];
		}else{
			return "URL APLICACION";
		}
	}
	
	static function getIdUsuario() {
	
		$session = new Container('datos_sesion');
		if(isset($session->datos_sesion["id_usuario"])){
			return $session->datos_sesion["id_usuario"];
		}else{
			return "0";
		}
	}
	
	static function getLoginUsuario() {
	
		$session = new Container('datos_sesion');
		if(isset($session->datos_sesion["login_usuario"])){
			return $session->datos_sesion["login_usuario"];
		}else{
			return "invitado";
		}
	}
	
	static function getNombreUsuario() {
		$session = new Container('datos_sesion');
		if(isset($session->datos_sesion["nombre_usuario"])){
			return $session->datos_sesion["nombre_usuario"];
		}else{
			return "Nombre Usuario";
		}
	}
	
	static function getCargo() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["cargo"])){
			return $session->datos_sesion["cargo"];
		}else{
			return "Cargo";
		}
	}
	
	static function getPuesto() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["puesto"])){
			return $session->datos_sesion["puesto"];
		}else{
			return "Puesto";
		}
	}
	
	static function getNombreEntidad() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["nombre_entidad"])){
			return $session->datos_sesion["nombre_entidad"];
		}else{
			return "Nombre Entidad";
		}
	}
	
	static function getSiglaEntidadOpcional() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["sigla_entidad"])){
			return $session->datos_sesion["sigla_entidad"];
		}else{
			return "Sigla Entidad";
		}
	}
	
	static function getSiglaEntidad() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["entidad"])){
			return $session->datos_sesion["entidad"];
		}else{
			return "MEFP";
		}
	}
	
	static function getUnidad() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["unidad_organizacional"])){
			return $session->datos_sesion["unidad_organizacional"];
		}else{
			return "0";
		}
	}
	
	static function getNombreUnidad() {
		$session = new Container('datos_sesion');
	
		if(isset($session->datos_sesion["unidad_organizacional_nombre"])){
			return $session->datos_sesion["unidad_organizacional_nombre"];
		}else{
			return "Nombre Unidad";
		}
	}
	
	static function getSiglaUnidad() {
		$session = new Container('datos_sesion');
		if(isset($session->datos_sesion["unidad_organizacional_sigla"])){
			return $session->datos_sesion["unidad_organizacional_sigla"];
		}else{
			return "Sigla Unidad";
		}
		
	}
	
	static function getFechaHoy() {
		//return date("m-d-Y");
		
		$format = 'd-m-Y';
		$date = \DateTime::createFromFormat($format, date("d-m-Y"));
		return  $date->format('d-m-Y') ;
		
	}
	

	static function getEstacion() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
	
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
	
		return $_SERVER['REMOTE_ADDR'];
	}
	
	static function getEstado() {
		return "R";
	}
	
	static function getMensajeConfirmacion() {
		return "DATOS REGISTRADOS CORRECTAMENTE ";
	}
	
	static function getMensajeError() {
		return "ERROR AL REGISTRAR LOS DATOS, COMUNIQUESE CON SU ADMINISTRADOR ";
	}
	
	static function getExceptionError() {
		return "OCURRIO UN ERROR AL CONSULTAR ";
	}
	
}

?>