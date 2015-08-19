<?php

class My_ACL_Factory {

    private static $_sessionNameSpace = 'My_ACL_Namespace';
    private static $_objAuth;
    private static $_objAclSession;
    private static $_objAcl;
    private static $_adminRoleId;

    public static function get(Zend_Auth $objAuth, $clearACL=false) {

        self::$_objAuth = $objAuth;
        self::$_objAclSession = new Zend_Session_Namespace(self::$_sessionNameSpace);

        if ($clearACL) {
            self::_clear();
        }

        if (isset(self::$_objAclSession->acl)) {
            return self::$_objAclSession->acl;
        } else {
            return self::_loadAclFromDB();
        }
    }

    private static function _clear() {
        unset(self::$_objAclSession->acl);
    }

    private static function _saveAclToSession() {
        self::$_objAclSession->acl = self::$_objAcl;
    }

    private static function _loadAclFromDB() {
        $roles = new Application_Model_RolesMapper();
        $arrRoles = $roles->fetchAllArray();
        $resources = new Application_Model_ResourcesMapper();
        $arrResources = $resources->fetchAllArray();
        $roleresources = new Application_Model_RoleResourcesMapper();
        $arrRoleResources = $roleresources->fetchAllArray();
        if (self::$_adminRoleId == "" || self::$_adminRoleId == null) {
            self::$_adminRoleId = $roles->getAdminRoleId();
        }

        // Create an array of core roles to check inherited roles against
        foreach ($arrRoles as $role) {
            if ($role['id'] != self::$_adminRoleId) {
                $arrCoreRoles[] = $role['role'];
            }
        }

        self::$_objAcl = new Zend_Acl();

        self::$_objAcl->addRole(new Zend_Acl_Role($roles->getGuestRoleName()));
        while (count($arrRoles) > 0) {
            $role = array_shift($arrRoles);
            if ($role['id'] != self::$_adminRoleId) {
                if (isset($role['inherits'])) {
                    $exists = true;
                    $isCore = false;
                    foreach ($role['inherits'] as $index => $inherited) {
                        if (in_array($inherited, $arrCoreRoles)) {
                            $isCore = true;
                        } else {
                            unset($role['inherits'][$index]);
                        }

                        if (!self::$_objAcl->hasRole($inherited)) {
                            $exists = false;
                        }
                    }

                    if ($exists && $isCore) {
                        $role['inherits'][] = $roles->getGuestRoleName();
                        self::$_objAcl->addRole(new Zend_Acl_Role($role['role']), $role['inherits']);
                    } else {
                        $arrRoles[] = $role;
                    }
                } else {
                    self::$_objAcl->addRole(new Zend_Acl_Role($role['role']), array($roles->getGuestRoleName()));
                }
            }
        }

        // add admin account and inherit all roles
        self::$_objAcl->addRole(new Zend_Acl_Role($roles->getAdminRoleName()), $arrCoreRoles);

        // add all resources to the acl
        foreach ($arrResources as $resource) {
            self::$_objAcl->add(new Zend_Acl_Resource($resource['module'] . '::' . $resource['controller'] . '::' . $resource['action']));
        }

        // allow roles to resources
        foreach ($arrRoleResources as $roleResource) {
            self::$_objAcl->allow($roleResource['role']['roleName'], $roleResource['resource']['module'] . '::' . $roleResource['resource']['controller'] . '::' . $roleResource['resource']['action']);
        }

        // exceptions to the rule - add and remove specific resources per role
        if (self::$_objAuth->hasIdentity()) {
            $arrRole = self::$_objAuth->getIdentity();
            $roleName = $arrRole->role;
            $userId = $arrRole->id;
            $accountId = $arrRole->id;
            $allow = new Application_Model_AllowedResourcesMapper();
            $arrAllow = $allow->getAllResources($accountId);
            $deny = new Application_Model_DenyResourcesMapper();
            $arrDeny = $deny->getAllResources($accountId);
            if (count($arrAllow) > 0) {
                foreach ($arrAllow as $resource) {
                    self::$_objAcl->allow($roleName, $resource);
                }
            }

            if (count($arrDeny) > 0) {
                foreach ($arrDeny as $resource) {
                    self::$_objAcl->deny($roleName, $resource);
                }
            }
        }

        self::_saveAclToSession();
        return self::$_objAcl;
    }

}