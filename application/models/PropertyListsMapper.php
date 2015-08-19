<?php

// application/models/PropertyListsMapper.php

class Application_Model_PropertyListsMapper {

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
            $this->setDbTable('Application_Model_DbTable_PropertyLists');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_PropertyLists $propertyLists) {
        $data = array(
            'category_id' => $propertyLists->getListId(),
            'title' => $propertyLists->getTitle(),
            'comment' => $propertyLists->getComment(),
            'display_order' => $propertyLists->getDisplayOrder(),
        );

        if (null === ($id = $propertyLists->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_PropertyLists $propertyLists) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $propertyLists->setId($row->id)
                ->setCategoryId($row->category_id)
                ->setTitle($row->title)
                ->setComment($row->comment)
                ->setDisplayOrder($row->display_order);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_PropertyLists();
            $entry->setId($row->id)
                    ->setCategoryId($row->category_id)
                    ->setTitle($row->title)
                    ->setComment($row->comment)
                    ->setDisplayOrder($row->display_order);
            $entries[] = $entry;
        }
        return $entries;
    }

}