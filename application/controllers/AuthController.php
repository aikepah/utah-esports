<?php

class AuthController extends Zend_Controller_Action {

    public function loginAction() {
        $db = new Zend_Db_Adapter_Pdo_Mysql(array('dbname' => 'utahesports', 'username' => 'ueSporTs', 'password' => 'eSp0RTSutah'));

        $loginForm = new Application_Form_Auth_Login();

        Zend_Registry::set('staticSalt', '5572Utah032eSports11players88Association');
        if ($loginForm->isValid($_POST)) {
            $adapter = $this->_getAuthAdapter();

            $adapter->setIdentity($loginForm->getValue('username'));
            $adapter->setCredential($loginForm->getValue('password'));

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                $user = $adapter->getResultRowObject();
                $role = new Application_Model_RolesMapper();
                $user->role = $role->find($user->role_id, new Application_Model_Roles())->getName();
                $auth->getStorage()->write($user);
                $this->_helper->FlashMessenger('Successful Login');
                $this->_redirect('index');
                return;
            } else {
                $this->view->loginError = $result->getCode();
            }
        }

        $this->view->loginForm = $loginForm;
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
    }

    protected function _getAuthAdapter() {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('ue_users')
                ->setIdentityColumn('username')
                ->setCredentialColumn('password')
                ->setCredentialTreatment('MD5(CONCAT("' . Zend_Registry::get('staticSalt') . '",?,password_salt))');


        return $authAdapter;
    }

}