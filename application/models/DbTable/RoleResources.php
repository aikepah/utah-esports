<?php

class Application_Model_DbTable_RoleResources extends Zend_Db_Table_Abstract {

    protected $_name = 'roleresources';

    public function fetchACLRoleResources() {
        $db = $this->_db;
        
        $select = $db->select()
                ->from(array('rr' => 'roleresources'),
                        array('id'))
                ->join(array('re' => 'resources'),
                        're.id = rr.resourceId')
                ->join(array('ro' => 'roles'),
                        'ro.id = rr.roleId');
        $stmt = $db->query($select);
        $result = $stmt->fetchAll();
        return $result;
    }

}

