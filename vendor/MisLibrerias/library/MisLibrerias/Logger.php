<?php

namespace MisLibrerias;

/**
 * 
 * @author walvarez
 *
 */

class Logger {
	
	//protected static $logger;
	public function init() {
		//self::$logger = Zend_Registry::get("logger");
	}
	
	public static function logIntoFirebug($arg, $tipo = \Zend_Log::DEBUG){
		
		$logger = \Zend_Registry::get("logger");
		$logger->log($arg, $tipo);
		
	}
	public static function showDialogError($error){
		
		echo \YsJQuery::newInstance()
		->execute(
				"dialogOpen('".$error."','ERROR');"
				//"alert('".$error."');"
		);
		
	/*
		echo \YsUIDialog::initWidget('dialogIdError','style="display:none" title="ERROR"');
		echo $error;
		echo \YsUIDialog::endWidget();
	
		echo
		\YsJQuery::newInstance()
		->execute(
				\YsUIDialog::build('#dialogIdError')
				->_modal(true)
				->_position(\YsUIPosition::$CENTER_CENTER_POSITION)
				->_show('slide')
				->_buttons(array(
						//'Ok' => new YsJsFunction('alert("Hello world")'),
						'Close' =>  new \YsJsFunction(\YsUIDialog::close('this')))
				)
		);
		*/
	}

	public static function showErrorDoctrine($texto, \Exception $e){
	
		// 		$request = new \Zend_Controller_Request_Simple();
		// 		$request->setModuleName("default");
		// 		$request->setControllerName("error");
		// 		$request->setActionName("error-doctrine");
		
		//Logger::logIntoFirebug($e);
		
		//$error = $e->getTraceAsString();
		$error = $e->getMessage();
		
		throw new \Exception($texto ."<br> ".$error);
	
// 		$error = $e->getMessage();
// 		$redirect = new \Zend_Controller_Action_Helper_Redirector();
// 		//$r->gotoSimpleAndExit("error-doctrine","error","default");
// 		$redirect->gotoUrl('/default/error/error-doctrine/texto/'.$texto.'/error_handler/'.$error)->redirectAndExit();
	}

	public static function showDialog($mensaje){
	
		\YsJQuery::usePlugin(\YsJQueryConstant::PLUGIN_PNOTYFY);
		
		echo
		\YsJQuery::newInstance()
		->execute(		
			new \YsJsFunction(
					\YsPNotify::build(array('pnotify_text' => $mensaje,
							'pnotify_type' => \YsPnotify::NOTICE_TYPE))
			)
		);
		
		//echo "<script>alert('".$mensaje."')</script>";

		
		
		
// 		echo \YsUIDialog::initWidget('dialogIdMensaje','style="display:none" title="MENSAJE"');
// 		echo $mensaje;
// 		echo \YsUIDialog::endWidget();
	
// 		echo
// 		\YsJQuery::newInstance()
// 		->execute(
// 				\YsUIDialog::build('#dialogIdMensaje')
// 				->_modal(true)
// 				->_position(\YsUIPosition::$CENTER_CENTER_POSITION)
// 				->_show('slide')
// 				->_buttons(array(
// 						'Close' =>  new \YsJsFunction(\YsUIDialog::close('this')))
// 				)
// 		);
	}
	
	
}

?>