<?php
namespace AuthDoctrine\Controller;

// Authentication with Remember Me
// http://samsonasik.wordpress.com/2012/10/23/zend-framework-2-create-login-authentication-using-authenticationservice-with-rememberme/

use Zend\Filter\Encrypt;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Serializer\Serializer;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

// use Auth\Model\Auth;          we don't need the model here we will use Doctrine em 
use AuthDoctrine\Entity\Usuario; // only for the filters
use AuthDoctrine\Form\LoginForm;       // <-- Add this import
use AuthDoctrine\Form\LoginFilter;
use Zend\Authentication\Result;
use Zend\Debug\Debug;
use MisLibrerias\DbFactory;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	$layout = $this->layout('layout/layout-login');
    
     
	    $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
	    if (!$auth->hasIdentity()) {
	    	return $this->redirect()->toRoute('auth-doctrine/login');
	    }
    
    
		// for example, in a controller:
//-		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		// or
//-		$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		// or even better
		$em = $this->getEntityManager();

        //var_dump($em);
		
		// the class for the table
//-		$user = new \AuthDoctrine\Entity\User; 
		
//-		$userRepository = $em->getRepository('AuthDoctrine\Entity\User'); // '\AuthDoctrine\Entity\User'
//-		$users = $userRepository->findAll();
		// $users = $em->findAll('AuthDoctrine\Entity\User');
		
//-		$q = $em->createQuery("select u from AuthDoctrine\Entity\User"); // AuthDoctrine\
//-		$users = $q->getResult();

		$users = null; //$em->getRepository('Application\Entity\Usuario')->findAll();
		
		// I will extra get the records from users
//		$myUsers = $em->getRepository('AuthDoctrine\Entity\Users')->findAll();
		
		/*
		If you have an entity class (Doctrine Repository manual):

		$records = $em->getRepository("Entities\YourTargetEntity")->findAll();
		If you don't have entity class (PDO manual):

		$pdo = $em->getCurrentConnection()->getDbh();
		$result = $pdo->query("select * from table"); //plain sql query here, it's just PDO
		$records = $pdo->fetchAll();
		
		*/
		
		
		//- var_dump($user);
		
		//- $entityManager->persist($product);
		//- $entityManager->flush();
		
		// doctrine.connection.orm_default: a Doctrine\DBAL\Connection instance
		// doctrine.configuration.orm_default: a Doctrine\ORM\Configuration instance
		// doctrine.driver.orm_default: default mapping driver instance
		// doctrine.entitymanager.orm_default: the Doctrine\ORM\EntityManager instance
		// Doctrine\ORM\EntityManager: an alias of doctrine.entitymanager.orm_default
		// doctrine.eventmanager.orm_default: the Doctrine\Common\EventManager instance
		
//-		echo '<pre>';
		// print_r($em);
//-		var_dump($em);
//-		echo '</pre>';
		
		
		
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array(
			'message' => $message,
			'users'	=> $users,
		));
    }
	
    public function loginAction()
    {
        $layout = $this->layout('layout/layout-login');
        
        
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
        	
        	$auth->clearIdentity();
        	$sessionManager = new \Zend\Session\SessionManager();
        	$sessionManager->forgetMe();
        	$session = new Container('datos_sesion');
        	$session->datos_sesion = null;
        	
        }
        

		$form = new LoginForm();
		$messages = null;

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
				$data = $form->getData();			
				
				// If you used another name for the authentication service, change it here
				// it simply returns the Doctrine Auth. This is all it does. lets first create the connection to the DB and the Entity
				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');		
				// Do the same you did for the ordinar Zend AuthService	
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['username']); //$data['usr_name']
				$adapter->setCredentialValue($data['password']); // $data['usr_password']
				$authResult = $authService->authenticate();
				
				switch ($authResult->getCode()) {
				
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						$messages = "Usuario no válido.";
						break;
				
					case Result::FAILURE_CREDENTIAL_INVALID:
						$messages = "Credenciales no válidas.";
						break;
				
					case Result::SUCCESS:
						$messages = "Bienvenido.";
						break;
				
					default:
						$messages = "";
						break;
				}
				
				
				
				// echo "<h1>I am here</h1>";
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
                    //echo '<pre>';
                    //print_r($identity);
                    
					$usrIdPersona = 0;
					if($identity->getUsrIdPersona()){
						$usrIdPersona = $identity->getUsrIdPersona();
					}
					
					
					$entityManager = $this->getEntityManager("sirh");
					$sql = "SELECT * FROM v_planilla3 WHERE id_persona = ".$usrIdPersona."";
					$util = new \Application\Entity\Repositories\UtilsRepository($entityManager);
					$persona = $util->execNativeSql($sql);
					Debug::dump($persona);
					
					$nombrePersona = "";
					$cargo = "";
					$puesto = "";
					$unidadOrganizacional = "";
					$nombreEntidad = "";
					$siglaEntidad = "";
					if(isset($persona)){
						$persona = $persona[0];
						$nombrePersona = $persona['nombres']." ".$persona['paterno']." ".$persona['materno'];
						$cargo = $persona['cargo'];
						$puesto = $persona['puesto'];
						$unidadOrganizacional = $persona['unidad'];
						$nombreEntidad = $persona['entidad'];
						$siglaEntidad = $persona['entidad_sigla'];
					}
					
					$entityManager = $this->getEntityManager('seguridad');
					$sql = "SELECT p.id, p.nombre, p.sigla
							FROM usuario_perfil up left join perfil p on up.id_perfil = p.id 
							    left join usuario u on up.id_usuario = u.usr_id
							where up.id_usuario = ".$identity->getUsrId()."";
					$util = new \Application\Entity\Repositories\UtilsRepository($entityManager);
					$perfiles = $util->execNativeSql($sql);
					
					$listaPerfiles = array();
					if($perfiles){
						foreach ($perfiles as $perfil){
							$listaPerfiles[$perfil['nombre']] = $perfil['sigla'];
						}
					}

					$entityManager = $this->getEntityManager('seguridad');
                    //$user = $entityManager->getRepository('AuthDoctrine\Entity\UsuarioPerfil')->findOneBy(array('idUsuario' => 1)); //

                    $query = $entityManager->createQuery('SELECT up FROM \Application\Entity\UsuarioPerfil up
											WHERE up.idUsuario = :idUsuario');
                    $query->setParameter('idUsuario', $identity->getUsrId());
                    $usuarioPerfilResult = $query->getArrayResult();
                    
//                     $query = $entityManager->createQuery('SELECT up FROM \Application\Entity\UsuarioPerfil up
// 											WHERE up.idUsuario = :idUsuario');
//                     $query->setParameter('idUsuario', $identity->getUsrId());
//                     $usuarioPerfilResult = $query->getArrayResult();

                   // Debug::dump($usuarioPerfilResult);
                    
                    $query = $entityManager->createQuery('SELECT p FROM \Application\Entity\Perfil p
											WHERE p.id = :id');
                    $query->setParameter('id', $usuarioPerfilResult[0]["idPerfil"]);
                    $perfilResult = $query->getArrayResult();
                    
                    $query = $entityManager->createQuery('SELECT a FROM \Application\Entity\Aplicacion a
											WHERE a.id = :id');
                    $query->setParameter('id', $perfilResult[0]["idAplicacion"]);
                    $aplicacionResult = $query->getArrayResult();
                    
                    $urlAplicacion = $aplicacionResult[0]["url"];
                    
                    $datosSesionArray = array(
                        'lista_perfiles'=>$listaPerfiles,
                        'id_rol'=>$perfilResult[0]["id"],
                        'nombre_rol'=>$perfilResult[0]["nombre"],
                        'sigla_rol'=>$perfilResult[0]["sigla"],
                        'sigla_aplicacion'=>$aplicacionResult[0]["sigla"],
                        'nombre_aplicacion'=>$aplicacionResult[0]["nombre"],
                        'url'=>$aplicacionResult[0]["url"],
                        'id_usuario'=>$identity->getUsrId(),
                        'login_usuario'=>$identity->getUsrName(),
                        'nombre_usuario'=>$nombrePersona,
                        'cargo'=> $cargo,
                        'puesto'=> $puesto,
                        'nombre_entidad'=> $nombreEntidad,
                        'sigla_entidad'=> $siglaEntidad,
                        'entidad'=>"MEFP",
                        'unidad_organizacional'=>$usuarioPerfilResult[0]["idUnidad"],
                        'unidad_organizacional_sigla'=>"",
                        'unidad_organizacional_nombre'=> $unidadOrganizacional,
                    );

                    $session = new Container('datos_sesion');
                    $session->datos_sesion = $datosSesionArray;


					$authService->getStorage()->write($identity);
					$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
    		//-		if ($data['rememberme']) $authService->getStorage()->session->getManager()->rememberMe($time); // no way to get the session
					if ($data['rememberme']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}

					//exit();
					
					if($aplicacionResult[0]["sigla"] == "SAA"){
						return $this->redirect()->toRoute('home');
					}else{
	                    $parametros = Serializer::serialize($datosSesionArray);
	                    return $this->redirect()->toUrl($urlAplicacion.'/application/base/index?id='.$parametros);
					}
					
					
                    //return $this->redirect()->toUrl('http://sipp-pruebas.economiayfinanzas.gob.bo/application/base/index?id='.$s);
				}
// 				foreach ($authResult->getMessages() as $message) {
// 					$messages .= "$message\n"; 
// 				}	

		/*
				$identity = $authenticationResult->getIdentity();
				$authService->getStorage()->write($identity);

				$authenticationService = $this->serviceLocator()->get('Zend\Authentication\AuthenticationService');
				$loggedUser = $authenticationService->getIdentity();
		*/
			}
		}
		return new ViewModel(array(
			'error' => 'Your authentication credentials are not valid',
			'form'	=> $form,
			'messages' => $messages,
		));
    }
	
	public function logoutAction()
	{
		// in the controller
		// $auth = new AuthenticationService();
		$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

		// @todo Set up the auth adapter, $authAdapter


		if ($auth->hasIdentity()) {
			// Identity exists; get it
			$identity = $auth->getIdentity();
//-			echo '<pre>';
//-			print_r($identity);
//-			echo '</pre>';
		}
		$auth->clearIdentity();
//-		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get to the sessionManager from the storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();

        $session = new Container('datos_sesion');
        $session->datos_sesion = null;
		
        // $view = new ViewModel(array(
        //    'message' => 'Hello world',
        // ));
        // $view->setTemplate('foo/baz-bat/do-something-crazy');
        // return $view;
		
		 return $this->redirect()->toRoute('home');
		//return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));

	}	
	
	// the use of controller plugin
	public function authTestAction()
	{
		if ($user = $this->identity()) { // controller plugin
			// someone is logged !
		} else {
			// not logged in
		}
	}
	
	/**             
	 * @var Doctrine\ORM\EntityManager
	 */                
	protected $em;
	 
	public function getEntityManager($database = 'seguridad')
	{
// 		if (null === $this->em) {
// 			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
// 		}
		
		$applicationConfig = $this->getServiceLocator()->get('config');
		$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$emDefaultConfig = $em->getConfiguration();
		
		$dbFactory = new DbFactory($applicationConfig);
		$anotherConnection = $dbFactory->getConnectionToDatabase($database);
		$anotherEntityManager = $dbFactory->getEntityManager($anotherConnection, $emDefaultConfig);
		
		$this->em =  $anotherEntityManager;
		
		return $this->em;
	}
}