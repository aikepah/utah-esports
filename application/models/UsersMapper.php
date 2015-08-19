<?php

// application/models/UsersMapper.php

class Application_Model_UsersMapper {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Users');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Users $users) {
        $data = array(
            'username' => $users->getUsername(),
            'password' => $users->getPassword(),
            'password_salt' => $users->getPasswordSalt(),
            'security_question' => $users->getSecurityQuestion(),
            'security_answer' => $users->getSecurityAnswer(),
            'logged_in' => $users->getLoggedIn(),
            'created_date' => $users->getCreatedDate(),
            'modified_date' => date('Y-m-d H:i:s'),
            'is_banned' => $users->getModifiedDate(),
            'role_id' => $users->getRoleId(),
        );

        if (null === ($id = $users->getId())) {
            unset($data['id']);
            $data['created_date'] = date('Y-m-d H:i:s');
            $last = $this->getDbTable()->insert($data);
            return $last;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id) {
        $users = new Application_Model_Users();
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result[0];
        $users->setId($row['id'])
                ->setUsername($row['username'])
                ->setSecurityQuestion($row['security_question'])
                ->setSecurityAnswer($row['security_answer'])
                ->setLoggedIn($row['logged_in'])
                ->setCreatedDate($row['created_date'])
                ->setModifiedDate($row['modified_date'])
                ->setIsBanned($row['is_banned'])
                ->setRoleId($row['role_id'])
                ->setRole($row['name']);
        return $users;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Users();
            $entry->setId($row['id'])
                    ->setUsername($row['username'])
                    ->setSecurityQuestion($row['security_question'])
                    ->setSecurityAnswer($row['security_answer'])
                    ->setLoggedIn($row['logged_in'])
                    ->setCreatedDate($row['created_date'])
                    ->setModifiedDate($row['modified_date'])
                    ->setIsBanned($row['is_banned'])
                    ->setRoleId($row['role_id'])
                    ->setRole($row['name']);
            $entries[] = $entry;
        }
        return $entries;
    }

}