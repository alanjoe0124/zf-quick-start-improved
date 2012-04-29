<?php

class Application_Form_Guestbook extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        // Change dt dd with a div around the label and input
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array('Label'),
            array(array('elementDiv' => 'HtmlTag'), array('tag' => 'div')),
            
        ));
        
        // Remove surrounding element from the form, previously this was a DL
        $this->addDecorator('FormElements')
         ->addDecorator('Form');
 
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
 
        // Add the comment element
        $this->addElement('textarea', 'comment', array(
            'label'      => 'Please Comment:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )
        ));
 
        // Add the recaptcha
        $publickey = '6Le-i7oSAAAAABvOymgTgOGvA-YcHel5ybSiDwju';
        $privatekey = '6Le-i7oSAAAAADNfyQGt7MmxNnw_JHUp_z3rmeiR';      
    
        $captcha = new Zend_Form_Element_Captcha('recaptcha',
            array(
                'label' => 'Enter the words you see below into the box:',
                'captcha'       => 'ReCaptcha',
                'captchaOptions' => array('captcha' => 'recaptcha',        
											  'pubKey' => $publickey,
											  'privKey' => $privatekey,
                                              'theme' => 'clean'),
                'ignore' => true
                )            
        );
        
         
        $this->addElement($captcha);
        
        $captcha->setDecorators(array(
        
            array('Label'),
            'Errors',
            array('HtmlTag', array('tag' => 'div')),
            
        ));

        // Add a captcha
        /*$this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));
         
        // Get the captcha via it's ID and then fix the extra input field that is added when we changed the decorators
        $captcha = $this->getElement('captcha');      
        $captcha->removeDecorator('ViewHelper');*/
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign Guestbook',
        ));
 
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));              
        
        // Get the submit button via it's ID and remove the label next to it
        $submit = $this->getElement('submit');       
        $submit->removeDecorator('label');
        
    }
}