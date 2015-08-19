<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
    }
    
    public function usersAction() {
        $users = new Application_Model_UsersMapper();
        $this->view->users = $users->fetchAll();        
    }
    
    public function rolesAction() {
        $roles = new Application_Model_RolesMapper();
        $this->view->roles = $roles->fetchAll();
    }
    
    public function resourcesAction() {
        $resources = new Application_Model_ResourcesMapper();
        $this->view->resources = $resources->fetchAll();
    }
    
    public function roleresourcesAction() {
        $role_resources = new Application_Model_RoleResources();
        $this->view->role_resources = $role_resources->fetchAll();
    }

}

