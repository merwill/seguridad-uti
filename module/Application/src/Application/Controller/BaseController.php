<?php
namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use MisLibrerias\DbFactory;
use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

//        public function onDispatch(\Zend\Mvc\MvcEvent $e){
//        //echo  "<script>alert('onDispatchIndex')</script>";
//
//           //$e =  new \Zend\Mvc\MvcEvent();
//
//
//         // $a = $e->getApplication();
//
//           // var_dump($a);
//            //echo $m ."--". $c ."--". $a;
//
////        $e->setModuleName("default");
////        $e->setControllerName("index");
////        $e->setActionName("login");
//
//
//        return parent::onDispatch( $e );
//    }

        public function __construct(){
           // echo  "<script>alert('__construct')</script>";

            //return parent::onDispatch( $e );


        }


/*    public function init(){

        $datosCabecera = array(
            "usuario"=>"WILMER",
            "cargo"=>"CARGO",
            "aplicacion"=>"APLICACION",
            "institucion"=>"MEFP(UTI)",
        );

        $this->getRequest()->get
        var_dump($datosCabecera);
    }*/


    public function onDispatch(\Zend\Mvc\MvcEvent $e){
        //echo  "<script>alert('onDispatchIndex')</script>";

/*        if(true){
            return $this->redirect()->toRoute('application/login');
        }*/
//
//           //$e =  new \Zend\Mvc\MvcEvent();
//
//
          //$a = $e->getApplication();

        $request = $e->getRouteMatch();
        $controller = $request->getParam("controller");
        $action = $request->getParam("action");

       $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
      
        if (!$auth->hasIdentity() || \MisLibrerias\DatosSesion::getSiglaAplicacion() != "SAA") {
        	//return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
        	return $this->redirect()->toRoute('auth-doctrine/login');
        }
        
        
//         if($controller != 'Application\Controller\Login'){
//             if(true){
//                // return $this->redirect()->toRoute('application/login');
//             }
//         }

            //var_dump($a);
          // echo $controller ."--". $action;
//
//        $e->setModuleName("default");
////        $e->setControllerName("index");
////        $e->setActionName("login");
//
//
        return parent::onDispatch( $e );
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * for managing entities via Doctrine
     * @return \Doctrine\ORM\EntityManager
     */
    /*public function getEntityManager()
    {
        if (null === $this->em) {
            //$this->em = $this->getServiceLocator()->get('\Doctrine\ORM\EntityManager');
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;

    }*/

    public function getEntityManager($database = 'seguridad')
    {
       // if (null === $this->em) {
            //$this->em = $this->getServiceLocator()->get('\Doctrine\ORM\EntityManager');
            //$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

            $applicationConfig = $this->getServiceLocator()->get('config');
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $emDefaultConfig = $em->getConfiguration();

            $dbFactory = new DbFactory($applicationConfig);
            $anotherConnection = $dbFactory->getConnectionToDatabase($database );
            $anotherEntityManager = $dbFactory->getEntityManager($anotherConnection, $emDefaultConfig);

            $this->em =  $anotherEntityManager;


        //}
        return $this->em;

    }
    
//     public function getEntityManager()
//     {
//         if (null === $this->em) {
//             //$this->em = $this->getServiceLocator()->get('\Doctrine\ORM\EntityManager');
//             //$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

//             $applicationConfig = $this->getServiceLocator()->get('config');
//             $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//             $emDefaultConfig = $em->getConfiguration();

//             $dbFactory = new DbFactory($applicationConfig);
//             $anotherConnection = $dbFactory->getConnectionToDatabase('seguridad');
//             $anotherEntityManager = $dbFactory->getEntityManager($anotherConnection, $emDefaultConfig);

//             $this->em =  $anotherEntityManager;


//         }
//         return $this->em;

//     }

}