<?php
namespace AuthDoctrine\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        /*
		$this->add(array(
            'name' => 'usr_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		*/
        $this->add(array(
            'name' => 'username', // 'usr_name',
            'attributes' => array(
                'type'  => 'text',
                'required'  => 'required',
                'class' => 'form-control',
                'placeholder' => 'Usuario',
            ),
            'options' => array(
               // 'label' => 'Username',

            ),
        ));
        $this->add(array(
            'name' => 'password', // 'usr_password',
            'attributes' => array(
                'type'  => 'password',
           		'required'  => 'required',
                'class' => 'form-control',
                'placeholder' => 'Clave',
            ),
            'options' => array(
                //'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
			'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',			
//            'attributes' => array(
//                'type'  => '\Zend\Form\Element\Checkbox',
//            ),
            'options' => array(
                'label' => 'Recordarme?',
//				'checked_value' => 'true', without value here will be 1
//				'unchecked_value' => 'false', // witll be 1
            ),
        ));	

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary btn-lg btn-block',
                'value' => 'Iniciar Sesión',
                //'id' => 'submitbutton',

            ),
        )); 
    }
}