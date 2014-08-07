<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Repositories\PeiRepository;
use Application\Entity\Repositories\UtilsRepository;
use MisLibrerias\DbFactory;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Debug\Debug;

class IndexController extends BaseController
{



/*        public function onDispatch(\Zend\Mvc\MvcEvent $e){
        //echo  "<script>alert('onDispatchIndex')</script>";

            if(false){
                return $this->redirect()->toRoute('application/login');
            }
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
        return parent::onDispatch( $e );
    }*/


/*    function __construct()
    {
        $layout = $this->layout();
        $layout->setTemplate('layout/layoutlogin');
    }*/



    public function indexAction()
    {
        //$layout = $this->layout('layout/layout-login');
        //return $this->redirect()->toRoute('application/login');

        //$this->layout('layout/layoutlogin');

		//echo \Zend\Version\Version::getLatest();
       // echo "nnn: ". __NAMESPACE__ ;
       // var_dump($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'));

       // $this->setEntityManager('Doctrine\ORM\EntityManager');

        //var_dump($this->getServiceLocator()->get('doctrine.entitymanager.orm_poappto'));

       // $op = new \Application\Entity\Repositories\PeiRepository($this->getEntityManager());
        //$op = new PeiRepository($this->getEntityManager());
        //$res = $op->findAllPei();

  /*      $util = new UtilsRepository($this->getEntityManager());

        $sql= "select * from formulario_objetos;";
        $res = $util->execNativeSql($sql);

        $log = $this->getServiceLocator()->get('log');

        $log->debug($res);*/


       /* $application = $this->getEventManager();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->get
            getServiceManager();*/

/*        $applicationConfig = $this->getServiceLocator()->get('config');
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $emDefaultConfig = $em->getConfiguration();

        $dbFactory = new DbFactory($applicationConfig);
        $anotherConnection = $dbFactory->getConnectionToDatabase('poa-ppto');
        $anotherEntityManager = $dbFactory->getEntityManager($anotherConnection, $emDefaultConfig);*/

       // $op = new \Application\Entity\Repositories\PeiRepository($this->getEntityManager());
        //$op = new PeiRepository($this->getEntityManager());
        //$res = $op->findAllPei();


        $session = new Container('datos_sesion');
        $datos_sesion = $session->datos_sesion;
       // Debug::dump($res);

        //$usersOnAnotherDb = $anotherEntityManager->getRepository('Application\Entity\Repositories\PeiRepository')->findAllPei();


       // $layout = $this->layout('layout/layout-login');
       // $layout->setTemplate('layout/layoutlogin');
        $viewModel = new ViewModel(array("datos_sesion" => $datos_sesion));
        return $viewModel;


       /* $viewModel = new ViewModel(array("res"=>$res));
        $viewModel->setTemplate('layout/layoutlogin');
        return $viewModel;*/
    }

    public function testAction()
    {
        $op = new PeiRepository($this->getEntityManager());
        $res = $op->findAllPei();

        return new ViewModel(array("res"=>$res));
    }
}
