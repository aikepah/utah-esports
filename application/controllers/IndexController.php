<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        /* Example of how to check if somebody has authorization to a specific thing
         * This is useful for things on a page that only show up on that page to
         * certain users.
         */
        $objAuth = Zend_Auth::getInstance();
        $objAcl = My_ACL_Factory::get($objAuth);
        $user = $objAuth->getIdentity();
        if ($user) {
            if ($objAcl->isAllowed($user->role, 'default::admin::index')) {
                print('hi!');
            }
        }
    }

}

