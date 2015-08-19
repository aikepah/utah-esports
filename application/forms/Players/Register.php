<?php

class Application_Form_Players_Register extends Zend_Form {
    
    public function init() {
        $this->addElement('text', 'firstName', array(
            'label' => 'First Name:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(1, 20)),
            )
        ));
        $this->addElement('text', 'lastName', array(
            'label' => 'Last Name:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(1, 20)),
            )
        ));
        $this->addElement('text', 'email', array(
            'label' => 'Email:',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        $this->addElement('checkbox', 'showEmail', array(
            'label' => 'Show Email?',
        ));
        $this->addElement('textarea', 'contactInfo', array(
            'label' => 'Other Contact Info:',
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 400)),
            )
        ));
    }
    
}