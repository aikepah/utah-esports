<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'ue_users';

    public function find($id) {
        $db = $this->_db;
        
        $select = $db->select()
                ->from(array('r' => 'roles'),
                        array('id', 'name'))
                ->join(array('u' => 'ue_users'),
                        'r.id = u.role_id')
                ->where('u.id = ' . $id);
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        return $result;
    }
    
    public function fetchAll() {
        $db = $this->_db;
        
        $select = $db->select()
                ->from(array('r' => 'roles'),
                        array('id', 'name'))
                ->join(array('u' => 'ue_users'),
                        'r.id = u.role_id');
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        return $result;
        
    }
}

