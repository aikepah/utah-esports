<?php

// application/models/EventDatesMapper.php
 
class Application_Model_EventDatesMapper
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
            $this->setDbTable('Application_Model_DbTable_EventDates');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_EventDates $eventDates)
    {
        $data = array(
            'event_id'   => $eventDates->getEventId(),
            'start_date' => $eventDates->getStartDate(),
            'end_date' => $eventDates->getEndDate(),
        );
 
        if (null === ($id = $eventDates->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_EventDates $eventDates)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $eventDates->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setStartDate($row->start_date)
                  ->setEndDate($row->end_date);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EventDates();
            $entry->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setStartDate($row->start_date)
                  ->setEndDate($row->end_date);
            $entries[] = $entry;
        }
        return $entries;
    }
}