<?php

// application/models/RoleResourcesMapper.php

class Application_Model_RoleResourcesMapper {

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
            $this->setDbTable('Application_Model_DbTable_RoleResources');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_RoleResources $roleresources) {
        $data = array(
            'roleId' => $roleresources->getRoleId(),
            'resourceId' => $roleresources->getResourceId(),
            'modified' => 'now()',
            'created' => $roleresources->getCreated(),
        );

        if (null === ($id = $roleresources->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_RoleResources $roleresources) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $roleresources->setId($row->id)
                ->setRoleId($row->roleId)
                ->setResourceId($row->resourceId)
                ->setModified($row->modified)
                ->setCreated($row->created);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_RoleResources();
            $entry->setId($row->id)
                    ->setRoleId($row->roleId)
                    ->setResourceId($row->resourceId)
                    ->setModified($row->modified)
                    ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function fetchAllArray() {
        $resultSet = $this->getDbTable()->fetchACLRoleResources();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry['role']['roleName'] = $row['name'];
            $entry['resource']['module'] = $row['module'];
            $entry['resource']['controller'] = $row['controller'];
            $entry['resource']['action'] = $row['action'];
            $entries[] = $entry;
        }
        return $entries;
    }

}