<?php

// application/models/EventGamesMapper.php
 
class Application_Model_EventGamesMapper
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
            $this->setDbTable('Application_Model_DbTable_EventGames');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_EventGames $eventGames)
    {
        $data = array(
            'event_id'   => $eventGames->getEventId(),
            'game_id' => $eventGames->getGameId(),
        );
 
        if (null === ($id = $eventGames->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_EventGames $eventGames)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $eventGames->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setGameId($row->game_id);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EventGames();
            $entry->setId($row->id)
                  ->setEventId($row->event_id)
                  ->setGameId($row->game_id);
            $entries[] = $entry;
        }
        return $entries;
    }
}