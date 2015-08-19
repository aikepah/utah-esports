<?php

// application/models/GamesMapper.php
 
class Application_Model_GamesMapper
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
            $this->setDbTable('Application_Model_DbTable_Games');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_Games $games)
    {
        $data = array(
            'event_id'   => $games->getEventId(),
            'start_date' => $games->getStartDate(),
            'end_date' => $games->getEndDate(),
        );
 
        if (null === ($id = $games->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Games $games)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $games->setId($row->id)
                  ->setTitle($row->title)
                  ->setImageUrl($row->img_url)
                  ->setDisplayOrder($row->display_order);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Games();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setImageUrl($row->img_url)
                  ->setDisplayOrder($row->display_order);
            $entries[] = $entry;
        }
        return $entries;
    }
}