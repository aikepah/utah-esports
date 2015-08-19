<?php

// application/models/AllowedResourcesMapper.php

class Application_Model_AllowedResourcesMapper {

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
            $this->setDbTable('Application_Model_DbTable_AllowedResources');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_AllowedResources $resources) {
        $data = array(
        );

        if (null === ($id = $resources->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Resources $resources) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $resources->setId($row->id);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Resources();
            $entry->setId($row->id);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function getAllResources($userId) {
        $result = $this->getDbTable()->getAllowResources($userId);
        if (0 == count($result)) {
            return;
        }
        $resources = array();
        foreach($result as $row) {
            $resources[] = $row['name'];
        }
        return $resources;
    }

}