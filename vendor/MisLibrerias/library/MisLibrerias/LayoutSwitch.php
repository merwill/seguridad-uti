<?php
namespace MisLibrerias;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend_Controller_Plugin_Abstract;

/**
 * @description Deshabilita/Habilita el layout de la aplicacion si es una peticion AJAX
 * @author walvarez
*/
class LayoutSwitch extends AbstractPlugin  {
	
//	public function preDispatch(\Zend_Controller_Request_Abstract $request) {
//
//		$viewHelper = \Zend_Controller_Action_HelperBroker::getStaticHelper("ViewRenderer");
//
//		if($request->isXmlHttpRequest()){
//			$viewHelper->setNoRender(true);
//			\Zend_Layout::getMvcInstance()->disableLayout();
//		}else{
//			$viewHelper->setNoRender(false);
//			\Zend_Layout::getMvcInstance()->enableLayout();
//		}
//	}

    public function onDispatch(\Zend\Mvc\MvcEvent $e){

        //$this->layout()->setTemplate('layout/layout');
        echo  "<script>alert('onDispachtPlugin')</script>";

        //echo "ssssss";
        //$e->set
        return parent::onDispatch( $e );
    }

    public function algo(){

        //$this->layout()->setTemplate('layout/layout');
       echo  "<script>alert('onDispachtPlugin')</script>";

        //echo "ssssss";
        //$e->set

    }




}