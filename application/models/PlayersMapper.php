<?php

// application/models/PlayersMapper.php

class Application_Model_PlayersMapper {

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
            $this->setDbTable('Application_Model_DbTable_Players');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Players $players) {
        $data = array(
            'user_id' => $players->getUserId(),
            'first_name' => $players->getFirstName(),
            'last_name' => $players->getLastName(),
            'email' => $players->getEmail(),
            'show_email' => $players->getShowEmail(),
            'contact_info' => $players->getContactInfo(),
            'created_date' => 'now()',
            'modified_date' => 'now()',
        );

        if (null === ($id = $players->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
            return true;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Players $players) {
        $result = $this->getDbTable()->fetchAll($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $players->setId($row->id)
                ->setUserId($row->user_id)
                ->setFirstName($row->first_name)
                ->setLastName($row->last_name)
                ->setEmail($row->email)
                ->setShowEmail($row->show_email)
                ->setContactInfo($row->contact_info)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
    }

    public function findByUserId($userId) {
        $player = new Application_Model_Players();
        $result = $this->getDbTable()->fetchRow(
                $this->getDbTable()->select()
                        ->where('user_id = ' . $userId)
        );
        if (0 == count($result)) {
            return;
        }
        $row = $result;
        $player->setId($row->id)
                ->setUserId($row->user_id)
                ->setFirstName($row->first_name)
                ->setLastName($row->last_name)
                ->setEmail($row->email)
                ->setShowEmail($row->show_email)
                ->setContactInfo($row->contact_info)
                ->setCreatedDate($row->created_date)
                ->setModifiedDate($row->modified_date);
        return $player;
    }

    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_EventDates();
            $entry->setId($row->id)
                    ->setUserId($row->user_id)
                    ->setFirstName($row->first_name)
                    ->setLastName($row->last_name)
                    ->setEmail($row->email)
                    ->setShowEmail($row->show_email)
                    ->setContactInfo($row->contact_info)
                    ->setCreatedDate($row->created_date)
                    ->setModifiedDate($row->modified_date);
            $entries[] = $entry;
        }
        return $entries;
    }

}