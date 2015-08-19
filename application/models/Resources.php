<?php

class Application_Model_Resources {

    protected $_id;
    protected $_module;
    protected $_controller;
    protected $_action;
    protected $_name;
    protected $_routeName;
    protected $_modified;
    protected $_created;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid resource property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid resource property');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setId($id) {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function setModule($module) {
        $this->_module = $module;
        return $this;
    }

    public function getModule() {
        return $this->_module;
    }
    
    public function setController($controller) {
        $this->_controller = $controller;
        return $this;
    }
    
    public function getController() {
        return $this->_controller;
    }
    
    public function setAction($action) {
        $this->_action = $action;
        return $this;
    }
    
    public function getAction() {
        return $this->_action;
    }
    
    public function setRouteName($routeName) {
        $this->_routeName = $routeName;
        return $this;
    }
    
    public function getRouteName() {
        return $this->_routeName;
    }
    
    public function setCreated($created) {
        $this->_created = $created;
        return $this;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function setModified($modified) {
        $this->_modified = $modified;
        return $this;
    }

    public function getModified() {
        return $this->_modified;
    }

}

