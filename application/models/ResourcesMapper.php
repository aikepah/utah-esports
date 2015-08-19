<?php

// application/models/ResourcesMapper.php

class Application_Model_ResourcesMapper {

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
            $this->setDbTable('Application_Model_DbTable_Resources');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Resources $resources) {
        $data = array(
            'module' => $resources->getModule(),
            'controller' => $resources->getController(),
            'action' => $resources->getAction(),
            'name' => $resources->getName(),
            'routeName' => $resources->getRouteName(),
            'modified' => 'now()',
            'created' => $resources->getCreated(),
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
        $resources->setId($row->id)
                ->setModule($row->module)
                ->setController($row->controller)
                ->setAction($row->action)
                ->setName($row->name)
                ->setRouteName($row->routeName)
                ->setModified($row->modified)
                ->setCreated($row->created);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Resources();
            $entry->setId($row->id)
                    ->setModule($row->module)
                    ->setController($row->controller)
                    ->setAction($row->action)
                    ->setName($row->name)
                    ->setRouteName($row->routeName)
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
            $entry = array('id' => $row->id,'module' => $row->module,'controller' => $row->controller,'action' => $row->action,'name' => $row->name,'routeName' => $row->routeName);
            $entries[] = $entry;
        }
        return $entries;
    }

}