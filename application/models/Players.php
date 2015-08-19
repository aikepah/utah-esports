<?php

class Application_Model_Players {

    protected $_id;
    protected $_userId;
    protected $_firstName;
    protected $_lastName;
    protected $_email;
    protected $_showEmail;
    protected $_contactInfo;
    protected $_createdDate;
    protected $_modifiedDate;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid player property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid player property');
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

    public function setUserId($userId) {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId() {
        return $this->_userId;
    }

    public function setFirstName($firstName) {
        $this->_firstName = $firstName;
        return $this;
    }

    public function getFirstName() {
        return $this->_firstName;
    }

    public function setLastName($lastName) {
        $this->_lastName = $lastName;
        return $this;
    }

    public function getLastName() {
        return $this->_lastName;
    }

    public function setEmail($email) {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setShowEmail($showEmail) {
        $this->_showEmail = (int) $showEmail;
        return $this;
    }

    public function getShowEmail() {
        return $this->_showEmail;
    }

    public function setContactInfo($contactInfo) {
        $this->_contactInfo = (string) $contactInfo;
        return $this;
    }

    public function getContactInfo() {
        return $this->_contactInfo;
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

}

