<?php

class Application_Model_Acl extends Zend_Acl
{
    public function __construct()
    {
        try {
        	
            // Define role admin
            $this->addRole(new Zend_Acl_Role('admin'));

        	// Define role guest
            $guest = new Zend_Acl_Role('guest');
            $this->addRole($guest);

        	// Define role for a user green
            $green = new Zend_Acl_Role('green');
            $this->addRole($green, $guest);

            // Define role for a user red
            $red =  new Zend_Acl_Role('red');
            $this->addRole($red, $guest);

            // Define role for a user purple - inherits from red and green
            $purple = new Zend_Acl_Role('purple');
            $this->addRole($purple, array($red,$green));

            // define resources
            $this->add(new Zend_Acl_Resource('redFiles'))			// Red Files
            	 ->add(new Zend_Acl_Resource('greenFiles'))			// Green Files
            	 ->add(new Zend_Acl_Resource('yellowFiles'));		// Yellow Files
            //$this->addResource($resource);
            	 
            // Assign access control for the resources
            // green user has access privileges to green files
            $this->allow($green, 'greenFiles', 'access');

            // Assign access control for the resources
            // red user has access privileges to red files
            $this->allow($red, 'redFiles', 'access');
            
            // purple user has access privileges to ANY resources
            //$this->allow('purple', array('greenFiles','redFiles'), 'access');
            
            // admin user is allowed any right to any resource
            $this->allow('admin');
            
            // Guest is denied all except yellow
 			$this->allow($guest, 'yellowFiles', 'access');
 			           
        } catch (Zend_Acl_Exception $e) {
            throw $e;
        }
    }
}
