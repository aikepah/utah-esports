<?php

// application/models/NewsMapper.php

class Application_Model_NewsMapper {

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
            $this->setDbTable('Application_Model_DbTable_News');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_News $news) {
        $data = array(
            'creator_id' => $news->getCreatorId(),
            'type_id' => $news->getTypeId(),
            'is_public' => $news->getIsPublic(),
            'title' => $news->getTitle(),
            'content' => $news->getContent(),
            'created_date' => date('Y-m-d H:i:s'), //hmm not sure how I wanna do this.
            'modified_date' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $news->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_News $news) {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $news->setId($row->id)
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
            $entry = new Application_Model_News();
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