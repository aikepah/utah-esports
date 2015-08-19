<?php

class Application_Model_Roles {

    protected $_id;
    protected $_name;
    protected $_default;
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
            throw new Exception('Invalid role property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid role property');
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

    public function setDefault($default) {
        $this->_default = $default;
        return $this;
    }

    public function getDefault() {
        return $this->_default;
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

