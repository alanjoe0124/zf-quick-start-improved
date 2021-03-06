<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function run(){
        $this->bootstrap('FrontController'); // Initialise the front controller 
        $front = $this->getResource('FrontController'); // Get the front controller
        
        if (in_array($_SERVER["SERVER_NAME"], array("demos.paulalbinson.info", "lcl.demos.paulalbinson.info"))):  // Made it work with my development version (lcl.demos.paulalbinson.info)
            $front->setBaseUrl("/zf-quick-start-improved"); // Set the base URL
        endif;
        
        // Ensure that the bootstrap is a parameter in the front controller
        if ($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $this);
        }

        $this->frontController = $front; // Update the front controller  
        
        self::_dispatch();
    }
    
    protected function _dispatch() {
        // Display an error if we can't find the front controller
        if ($this->frontController == null):
            throw Exception('The front controller has not been initialized.');
        endif;

        $this->frontController->returnResponse(true);
        $response = $this->frontController->dispatch();

        $this->_sendResponse($response); // Call function to execute page/put on screen
    }

    // Specifies what to do with a response - It specifies it as a http response, adds a header, and sends it.
    protected function _sendResponse(Zend_Controller_Response_Http $response) {
        $response->setHeader('Content-Type', 'text/html; charset=UTF-8', true);
        $response->sendResponse(); // Execute page/put on screen
    }
}

