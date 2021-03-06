<?php

// application/models/PropertyOptionsMapper.php

class Application_Model_PropertyOptionsMapper {

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
            $this->setDbTable('Application_Model_DbTable_PropertyOptions');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_PropertyOptions $propertyOptions) {
        $data = array(
            'list_id' => $propertyOptions->getListId(),
            'title' => $propertyOptions->getTitle(),
            'comment' => $propertyOptions->getComment(),
            'display_order' => $propertyOptions->getDisplayOrder(),
        );

        if (null === ($id = $propertyOptions->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_PropertyOptions $propertyOptions) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $propertyOptions->setId($row->id)
                ->setListId($row->list_id)
                ->setTitle($row->title)
                ->setComment($row->comment)
                ->setDisplayOrder($row->display_order);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_PropertyOptions();
            $entry->setId($row->id)
                    ->setListId($row->list_id)
                    ->setTitle($row->title)
                    ->setComment($row->comment)
                    ->setDisplayOrder($row->display_order);
            $entries[] = $entry;
        }
        return $entries;
    }

}