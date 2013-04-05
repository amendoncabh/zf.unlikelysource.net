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
            $this->addRole($green,$guest);

            // Define role for a user red
            $red =  new Zend_Acl_Role('red');
            $this->addRole($red,$guest);

            // Define role for a user purple - inherits from red and green
            $purple = new Zend_Acl_Role('purple');
            $this->addRole($purple, array($red,$green));

            // define resources
            $this->addResource(new Zend_Acl_Resource('redFiles'))			// Red Files
            	 ->addResource(new Zend_Acl_Resource('greenFiles'))			// Green Files
            	 ->addResource(new Zend_Acl_Resource('yellowFiles'));		// Yellow Files
            	 
            // Assign access control for the resources
            // green user has access privileges to green files
            $this->allow($green, 'greenFiles', 'access');

            // Assign access control for the resources
            // red user has access privileges to red files
            $this->allow($red, 'redFiles', 'access');
            
            // purple user has access privileges to ANY resources
            // Not needed
			// $this->allow('purple', array('greenFiles','redFiles'), 'access');

            // define actions as resources
            $this->addResource(new Zend_Acl_Resource('view-green'))			// Green Files
            	 ->addResource(new Zend_Acl_Resource('view-red'))			// Red Files
            	 ->addResource(new Zend_Acl_Resource('view-purple'))		// Purple Files
            	 ->addResource(new Zend_Acl_Resource('view-yellow'))		// Yellow Files
            	 ->addResource(new Zend_Acl_Resource('edit-green'))			// Green Files
            	 ->addResource(new Zend_Acl_Resource('edit-red'))			// Red Files
            	 ->addResource(new Zend_Acl_Resource('edit-purple'))		// Purple Files
            	 ->addResource(new Zend_Acl_Resource('edit-yellow'));		// Yellow Files
            	 
            // Assign rights based on controller actions (see AclpluginController.php)
            $this->allow($green, array('view-green', 'edit-green', 'edit-yellow'));
            $this->allow($red,   array('view-red', 'edit-red', 'edit-yellow'));

            // add menu resources
            $this->addResource(new Zend_Acl_Resource('viewMenuGreen'))
            	 ->addResource(new Zend_Acl_Resource('viewMenuRed'))
            	 ->addResource(new Zend_Acl_Resource('viewMenuYellow'))
            	 ->addResource(new Zend_Acl_Resource('viewMenuPurple'))
            	 ->addResource(new Zend_Acl_Resource('editMenuGreen'))
            	 ->addResource(new Zend_Acl_Resource('editMenuRed'))
            	 ->addResource(new Zend_Acl_Resource('editMenuYellow'))
            	 ->addResource(new Zend_Acl_Resource('editMenuPurple'));
            	 
            // Assign rights based on menu options
            $this->allow($green, array('viewMenuGreen', 'editMenuGreen', 'editMenuYellow'));
            $this->allow($red,   array('viewMenuRed', 'editMenuRed', 'editMenuYellow'));

            // Add login and index action and allow all
            $this->addResource(new Zend_Acl_Resource('index'))
                 ->addResource(new Zend_Acl_Resource('login'));
            $this->allow(NULL, array('index', 'login'));
            
            // Guest is allowed to view yellow
            $this->allow($guest, array('view-yellow', 'viewMenuYellow'));
            
            // admin user is allowed any right to any resource
            $this->allow('admin');            
            
        } catch (Zend_Acl_Exception $e) {
            throw $e;
        }
    }
}
