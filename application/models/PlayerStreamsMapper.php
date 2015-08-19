<?php

// application/models/PlayerStreamsMapper.php

class Application_Model_PlayerStreamsMapper {

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
            $this->setDbTable('Application_Model_DbTable_PlayerStreams');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_PlayerStreams $playerStreams) {
        $data = array(
            'player_id' => $playerStreams->getPlayerId(),
            'game_id' => $playerStreams->getGameId(),
            'is_live' => $playerStreams->getIsLive(),
            'is_featured' => $playerStreams->getIsFeatured(),
            'title' => $playerStreams->getTitle(),
            'description' => $playerStreams->getDescription(),
            'created_date' => $playerStreams->getCreatedDate(),
            'modified_date' => $playerStreams->getModifiedDate(),
        );

        if (null === ($id = $playerStreams->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_PlayerStreams $playerStreams) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $playerStreams->setId($row->id)
                ->setPlayerId($row->player_id)
                ->setGameId($row->game_id)
                ->setIsLive($row->is_live)
                ->setIsFeatured($row->is_featured)
                ->setTitle($row->title)
                ->setDescription($row->description)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_PlayerStreams();
            $entry->setId($row->id)
                ->setPlayerId($row->player_id)
                ->setGameId($row->game_id)
                ->setIsLive($row->is_live)
                ->setIsFeatured($row->is_featured)
                ->setTitle($row->title)
                ->setDescription($row->description)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
            $entries[] = $entry;
        }
        return $entries;
    }

}