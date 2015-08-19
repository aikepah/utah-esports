<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Zend_View_Helper_ProfileLink {

    public $view;

    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }

    public function profileLink() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;
            $userId = $auth->getIdentity()->id;
            return 'Welcome, <a href="' . $this->view->baseUrl() . '/user/' . $userId . '">' . $username . '</a> - <a href="'.$this->view->baseUrl().'/auth/logout">Logout</a>';
        }

        return '<a href="'.$this->view->baseUrl().'/auth/login">Login</a> - <a href="'. $this->view->baseUrl() .'/users/register">Register</a>';
    }

}

?>