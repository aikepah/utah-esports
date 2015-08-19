<?php

// application/models/RolesMapper.php

class Application_Model_RolesMapper {

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
            $this->setDbTable('Application_Model_DbTable_Roles');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Roles $roles) {
        $data = array(
            'name' => $roles->getName(),
            'default' => $roles->getDefault(),
            'modified' => 'now()',
        );

        if (null === ($id = $roles->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Roles $roles) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result[0];
        $roles->setId($row->id)
                ->setName($row->name)
                ->setDefault($row->default)
                ->setModified($row->modified)
                ->setCreated($row->created);
        return $roles;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Roles();
            $entry->setId($row->id)
                    ->setName($row->name)
                    ->setDefault($row->default)
                    ->setModified($row->modified)
                    ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllArray() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry['role'] = $row->name;
            $entry['id'] = $row->id;
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getAdminRoleId() {
        $result = $this->getDbTable()->fetchRow(
                $this->getDbTable()->select('id')
                        ->where('name = "admin"')
        );
        if (0 == count($result)) {
            return;
        }
        return $result->id;
    }

    public function getAdminRoleName() {
        $result = $this->getDbTable()->fetchRow(
                $this->getDbTable()->select('name')
                        ->where('name = "admin"')
        );
        if (0 == count($result)) {
            return;
        }
        return $result->name;
    }

    public function getGuestRoleName() {
        
    }

    public function getDefaultRole() {
        $result = $this->getDbTable()->fetchRow(
                $this->getDbTable()->select('id')
                        ->where('`default` = 1')
        );
        if (0 == count($result)) {
            return;
        }
        return $result->id;
    }

}