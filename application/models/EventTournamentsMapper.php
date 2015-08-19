<?php

// application/models/EventTournamentsMapper.php
 
class Application_Model_EventTournamentsMapper
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
            $this->setDbTable('Application_Model_DbTable_EventTournaments');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_EventTournaments $eventTournaments)
    {
        $data = array(
            'event_id'   => $eventTournaments->getEventId(),
            'tournament_id' => $eventTournaments->getTournamentId(),
        );
 
        if (null === ($id = $eventTournaments->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_EventTournaments $eventTournaments)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $eventTournaments->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setTournamentId($row->tournament_id);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EventTournaments();
            $entry->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setTournamentId($row->tournament_id);
            $entries[] = $entry;
        }
        return $entries;
    }
}