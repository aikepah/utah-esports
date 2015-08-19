<?php

// application/models/PlayerGameInfosMapper.php
 
class Application_Model_PlayerGameInfosMapper
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
            $this->setDbTable('Application_Model_DbTable_PlayerGameInfos');
        }
        return $this->_dbTable;
    }
 
    public function save(Application_Model_PlayerGameInfos $playerGameInfos)
    {
        $data = array(
            'player_id'   => $playerGameInfos->getPlayerId(),
            'game_id' => $playerGameInfos->getGameId(),
            'info_id' => $playerGameInfos->getInfoId(),
            'content' => $playerGameInfos->getContent(),
        );
 
        if (null === ($id = $playerGameInfos->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_PlayerGameInfos $playerGameInfos)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $playerGameInfos->setId($row->id)
                  ->setPlayerId($row->player_id)
                  ->setGameId($row->game_id)
                  ->setInfoId($row->info_id)
                  ->setContent($row->content);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_PlayerGameInfos();
            $entry->setId($row->id)
                  ->setPlayerId($row->player_id)
                  ->setGameId($row->game_id)
                  ->setInfoId($row->info_id)
                  ->setContent($row->content);
            $entries[] = $entry;
        }
        return $entries;
    }
}