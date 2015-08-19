<?php

class My_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $objAuth = Zend_Auth::getInstance();
        $clearACL = true;

        // initially treat the user as a guest so we can determine if the current
        // resource is accessible by guest users
        $role = 'guest';

        // if its not accessible then we need to check for a user login
        // if the user is logged in then we check if the role of the logged
        // in user has the credentials to access the current resource

        try {
            if ($objAuth->hasIdentity()) {
                $user = $objAuth->getIdentity();

                $sess = new Zend_Session_Namespace('MY_ACL');
                if ($sess->clearACL) {
                    $clearACL = true;
                    unset($sess->clearACL);
                }

                $objAcl = My_ACL_Factory::get($objAuth, $clearACL);
                if (!$objAcl->isAllowed($user->role, $request->getModuleName() . '::' . $request->getControllerName() . '::' . $request->getActionName())) {
                    $request->setModuleName('default');
                    $request->setControllerName('error');
                    $request->setActionName('noauth');
                }
            } else {
                $objAcl = My_ACL_Factory::get($objAuth, $clearACL);
                if (!$objAcl->isAllowed($role, $request->getModuleName() . '::' . $request->getControllerName() . '::' . $request->getActionName())) {
                    return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoSimple(array('controller' => 'auth', 'action' => 'login'));
                }
            }
        } catch (Zend_Exception $e) {
            $request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('noresource');
        }
    }

}
