<?php

// application/models/EventsMapper.php

class Application_Model_EventsMapper {

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
            $this->setDbTable('Application_Model_DbTable_Events');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Events $events) {
        $data = array(
            'creator_id' => $events->getCreatorId(),
            'type_id' => $events->getTypeId(),
            'is_public' => $events->getIsPublic(),
            'title' => $events->getTitle(),
            'content' => $events->getContent(),
            'created_date' => date('Y-m-d H:i:s'), //hmm not sure how I wanna do this.
            'modified_date' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $events->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Events $events) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $events->setId($row->id)
                ->setCreatorId($row->creator_id)
                ->setTypeId($row->type_id)
                ->setIsPublic($row->is_public)
                ->setTitle($row->title)
                ->setContent($row->content)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Events();
            $entry->setId($row->id)
                ->setCreatorId($row->creator_id)
                ->setTypeId($row->type_id)
                ->setIsPublic($row->is_public)
                ->setTitle($row->title)
                ->setContent($row->content)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
            $entries[] = $entry;
        }
        return $entries;
    }

}