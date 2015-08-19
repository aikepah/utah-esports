<?php

class UsersController extends Zend_Controller_Action {

    protected $_redirector = null;

    public function init() {

        $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    public function indexAction() {
        // action body
        $users = new Application_Model_UsersMapper();
        $this->view->users = $users->fetchAll();
    }

    public function registerAction() {
        $request = $this->getRequest();
        $userform = new Application_Form_Users_Register();
        $playerform = new Application_Form_Players_Register();
        $this->view->playerform = $playerform;
        $this->view->userform = $userform;
        if ($this->getRequest()->isPost()) {
            $reqUserForm = $request->getPost('user');
            $reqUserForm['csrf'] = $request->getPost('csrf');
            $reqUserForm['securityAnswer'] = $reqUserForm['securityanswer'];
            $reqUserForm['securityQuestion'] = $reqUserForm['securityquestion'];
            if ($userform->isValid($reqUserForm)) {
                if ($reqUserForm['password'] === $request->getPost('passwordrepeat')) {
                    $user = new Application_Model_Users($userform->getValues());
                    $dynamicSalt = null;
                    for ($i = 0; $i < 50; $i++) {
                        $dynamicSalt .= rand(0, 9);
                    }
                    $user->setPasswordSalt($dynamicSalt);
                    Zend_Registry::set('staticSalt', '5572Utah032eSports11players88Association');
                    $concat = Zend_Registry::get('staticSalt') . $user->getPassword() . $dynamicSalt;
                    $saltedPass = md5($concat);
                    $user->setPassword($saltedPass);
                    $defaultRole = new Application_Model_RolesMapper();
                    $user->setRoleId($defaultRole->getDefaultRole());
                    $mapper = new Application_Model_UsersMapper();
                    $userId = $mapper->save($user);
                    $reqPlayerForm = $request->getPost('player');
                    $reqPlayerForm['firstName'] = $reqPlayerForm['firstname'];
                    $reqPlayerForm['lastName'] = $reqPlayerForm['lastname'];
                    $reqPlayerForm['showEmail'] = $reqPlayerForm['showemail'];
                    $reqPlayerForm['contactInfo'] = $reqPlayerForm['contactinfo'];
                    if ($playerform->isValid($reqPlayerForm)) {
                        $player = new Application_Model_Players($playerform->getValues());
                        $player->setUserId($userId['id']);
                        $mapper = new Application_Model_PlayersMapper();
                        $saved = $mapper->save($player);
                        if ($saved === true) {
                            $this->_redirector->gotoSimple('new', 'users', null, array('signup' => 'success'));
                        } else {
                            $this->_redirector->gotoSimple('new', 'users', null, array('signup' => 'error'));
                        }
                    } else {
                        $playerForm->getErrors();
                        die();
                        $this->view->playerform = $playerform;
                    }
                } else {
                    $this->view->passmissmatch = "Password doesn't match";
                }
            } else {
                $this->view->userform = $userform;
            }
        }
    }

    public function profileAction() {
        $request = $this->getRequest();
        $user = new Application_Model_UsersMapper();
        $userInfo = $user->find($request->getParam('id'));
        $player = new Application_Model_PlayersMapper();
        $playerInfo = $player->findByUserId($request->getParam('id'));
        if ($userInfo !== "" && $userInfo !== null) {
            $this->view->playerInfo = $playerInfo;
            $this->view->userInfo = $userInfo;
        } else {
            $this->view->noUser = true;
        }
    }

    public function newAction() {
        print_r($this->getRequest);
        die();
    }

}

