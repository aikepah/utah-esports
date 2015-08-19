<?php

class Application_Model_ACL_Resources {

    private $arrModules = array();
    private $arrControllers = array();
    private $arrActions = array();
    private $arrIgnore = array('.', '..', '.svn');

    public function __get($strVar) {
        return ( isset($this->$strVar) ) ? $this->$strVar : null;
    }

    public function __set($strVar, $strValue) {
        $this->$strVar = $strValue;
    }

    public function writeToDB() {
        $this->checkForData();

        if (array_key_exists('application', $this->arrControllers)) {
            foreach ($this->arrControllers['application'] as $strControllerName) {
                if (array_key_exists($strControllerName, $this->arrActions['application'])) {
                    foreach ($this->arrActions['application'][$strControllerName] as $strActionName) {
                        // replace this line with your own DB code
                        // write to db if it doesn't exist
                        writeToDB_IfNotExists($strModuleName, $strControllerName, $strActionName);
                    }
                }
            }
        }
        return $this;
    }

    private function checkForData() {
        if (count($this->arrModules) < 1) {
            throw new DJC_ACL_Exception('No modules found.');
        }
        if (count($this->arrControllers) < 1) {
            throw new DJC_ACL_Exception('No Controllers found.');
        }
        if (count($this->arrActions) < 1) {
            throw new DJC_ACL_Exception('No Actions found.');
        }
    }

    public function buildAllArrays() {
        $this->buildControllerArrays();
        $this->buildActionArrays();
        return $this;
    }

    public function buildControllerArrays() {
        $datControllerFolder = opendir(APPLICATION_PATH . '/controllers');
        while (($dstFile = readdir($datControllerFolder) ) !== false) {
            if (!in_array($dstFile, $this->arrIgnore)) {
                if (preg_match('/Controller/', $dstFile)) {
                    $this->arrControllers['application'][] = strtolower(substr($dstFile, 0, -14));
                }
            }
        }
        closedir($datControllerFolder);
    }

    public function buildActionArrays() {
        if (count($this->arrControllers) > 0) {
            foreach ($this->arrControllers as $strModule => $arrController) {
                foreach ($arrController as $strController) {
                    $strClassName = ucfirst($strController . 'Controller');

                    if (!class_exists($strClassName)) {
                        Zend_Loader::loadFile(APPLICATION_PATH . '/controllers/' . ucfirst($strController) . 'Controller.php');
                    }

                    $objReflection = new Zend_Reflection_Class($strClassName);
                    $arrMethods = $objReflection->getMethods();
                    foreach ($arrMethods as $objMethods) {
                        if (preg_match('/Action/', $objMethods->name)) {
                            $this->arrActions[$strModule][$strController][] = substr($this->_camelCaseToHyphens($objMethods->name), 0, -6);
                        }
                    }
                }
            }
        }
    }

    private function _camelCaseToHyphens($string) {
        if ($string == 'currentPermissionsAction') {
            $found = true;
        }
        $length = strlen($string);
        $convertedString = '';
        for ($i = 0; $i < $length; $i++) {
            if (ord($string[$i]) > ord('A') && ord($string[$i]) < ord('Z')) {
                $convertedString .= '-' . strtolower($string[$i]);
            } else {
                $convertedString .= $string[$i];
            }
        }
        return strtolower($convertedString);
    }

}