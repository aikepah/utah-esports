<?php

class Application_Model_Users {

    protected $_id;
    protected $_username;
    protected $_password;
    protected $_passwordSalt;
    protected $_securityQuestion;
    protected $_securityAnswer;
    protected $_loggedIn;
    protected $_createdDate;
    protected $_modifiedDate;
    protected $_isBanned;
    protected $_roleId;
    protected $_role;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
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

    public function setUsername($username) {
        $this->_username = (string) $username;
        return $this;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function setPassword($password) {
        $this->_password = $password;
        return $this;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPasswordSalt($passwordSalt) {
        $this->_passwordSalt = $passwordSalt;
        return $this;
    }

    public function getPasswordSalt() {
        return $this->_passwordSalt;
    }

    public function setSecurityQuestion($securityQuestion) {
        $this->_securityQuestion = (string) $securityQuestion;
        return $this;
    }

    public function getSecurityQuestion() {
        return $this->_securityQuestion;
    }

    public function setSecurityAnswer($securityAnswer) {
        $this->_securityAnswer = (string) $securityAnswer;
        return $this;
    }

    public function getSecurityAnswer() {
        return $this->_securityAnswer;
    }

    public function setLoggedIn($loggedIn) {
        $this->_loggedIn = (int) $loggedIn;
        return $this;
    }

    public function getLoggedIn() {
        return $this->_loggedIn;
    }

    public function setCreatedDate($createdDate) {
        $this->_createdDate = $createdDate;
        return $this;
    }

    public function getCreatedDate() {
        return $this->_createdDate;
    }

    public function setModifiedDate($modifiedDate) {
        $this->_modifiedDate = $modifiedDate;
        return $this;
    }

    public function getModifiedDate() {
        return $this->_modifiedDate;
    }

    public function setIsBanned($isBanned) {
        $this->_isBanned = (int) $isBanned;
        return $this;
    }

    public function getIsBanned() {
        return $this->_isBanned;
    }
    
    public function setRoleId($roleId) {
        $this->_roleId = (int) $roleId;
        return $this;
    }
    
    public function getRoleId() {
        return $this->_roleId;
    }
    
    public function setRole($role) {
        $this->_role = $role;
        return $this;
    }
    
    public function getRole() {
        return $this->_role;
    }

}

