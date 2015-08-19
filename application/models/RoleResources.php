<?php

class Application_Model_RoleResources {

    protected $_id;
    protected $_roleId;
    protected $_resourceId;
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
            throw new Exception('Invalid role resource property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid role resource property');
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

    public function setRoleId($roleId) {
        $this->_roleId = $roleId;
        return $this;
    }

    public function getRoleId() {
        return $this->_roleId;
    }

    public function setResourceId($resourceId) {
        $this->_resourceId = $resourceId;
        return $this;
    }

    public function getResourceId() {
        return $this->_resourceId;
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

