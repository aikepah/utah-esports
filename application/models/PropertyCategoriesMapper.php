<?php

// application/models/PropertyCategoriesMapper.php
 
class Application_Model_PropertyCategoriesMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_PropertyCategories');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_PropertyCategories $propertyCategories)
    {
        $data = array(
            'title'   => $propertyCategories->getTitle(),
            'comment' => $propertyCategories->getComment(),
            'display_order' => $propertyCategories->getDisplayOrder(),
        );
 
        if (null === ($id = $propertyCategories->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_PropertyCategories $propertyCategories)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $propertyCategories->setId($row->id)
                  ->setTitle($row->title)
                  ->setComment($row->comment)
                  ->setDisplayOrder($row->display_order);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_PropertyCategories();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setComment($row->comment)
                  ->setDisplayOrder($row->display_order);
            $entries[] = $entry;
        }
        return $entries;
    }
}