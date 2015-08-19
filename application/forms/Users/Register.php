<?php

class Application_Form_Users_Register extends Zend_Form {

    public function init() {
        $this->addElement('text', 'username', array(
            'label' => 'username:',
            'required' => true,
            'filters' => array('StringToLower'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(1, 20)),
                array('validator' => 'alnum'),
            ),
        ));
        $this->addElement('password', 'password', array(
            'label' => 'password:',
            'required' => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 16))
            ),
        ));
        $this->addElement('text', 'securityQuestion', array(
            'label' => 'Security Question:',
            'required' => true,
            'filters' => array('StringToLower'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 40)),
            ),
        ));
        $this->addElement('text', 'securityAnswer', array(
            'label' => 'Security Answer:',
            'required' => true,
            'filters' => array('StringToLower'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 40)),
            ),
        ));
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Register',
        ));
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }

}

