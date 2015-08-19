<?php

class Application_Model_DbTable_AllowedResources extends Zend_Db_Table_Abstract {

    protected $_name = 'allowresources';

    public function getAllowResources($userId) {
        $db = $this->_db;

        $select = $db->select()
                ->from(array('ar' => 'allowresources'), array('id'))
                ->join(array('re' => 'resources'), 're.id = ar.resourceId')
                ->where('ar.accountId = '. $userId);
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        return $result;
    }

}

