<?php

class Application_Model_DbTable_DenyResources extends Zend_Db_Table_Abstract {

    protected $_name = 'denyresources';

    public function getDenyResources($userId) {
        $db = $this->_db;

        $select = $db->select()
                ->from(array('ar' => 'denyresources'), array('id'))
                ->join(array('re' => 'resources'), 're.id = ar.resourceId')
                ->where('ar.accountId = '. $userId);
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        return $result;
    }

}

