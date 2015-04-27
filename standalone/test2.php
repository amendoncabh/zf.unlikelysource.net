<?php
   public function info2Action()
    {
    	$this->_userSess->section = $this->_translate->_('Personal Information 2');
    	$this->view->section = $this->_userSess->section;
    	$this->view->msg = '';
    	$this->_form->setAction('/form-ds11/info2');
    	if (isset($this->_params['dob_date_m'])) {
    		$this->_form->getDOBDate((int)$this->_params['dob_date_m']);
   		} else {
    		$this->_form->getDOBDate($this->_date['m']);
    	}
        $this->_form->addElements( array(
					$this->_form->element['dob_date_m'],
					$this->_form->element['dob_date_d'],
					$this->_form->element['dob_date_y']
		));
    	if (!isset($this->_userSess->data['dob_date_m'])) {
			$this->_form->element['dob_date_m']->setValue($this->_date['m']);
			$this->_form->element['dob_date_d']->setValue($this->_date['d']);
			$this->_form->element['dob_date_y']->setValue($this->_date['y']);
    	}
		$this->_form->addElement($this->_form->element['sex']);
    	if (isset($this->_params['applicant_pob_which'])) {
    		$this->_userSess->data['applicant_pob_which'] = ($this->_params['applicant_pob_which'] == 's') ? 's' : 'c';
    	} else {
    		$this->_userSess->data['applicant_pob_which'] = (isset($this->_userSess->data['applicant_pob_which'])) ? $this->_userSess->data['applicant_pob_which'] : 's';
    	}
    	$this->_form->addElements($this->_form->getPOB( 'applicant',
    													$this->_states,
    													$this->_countries,
    													$this->_translate->_('Applicant') . ' - ' . $this->_translate->_('Place of Birth'),
    													$this->_userSess->data['applicant_pob_which']
    	));
    	$this->_form->addElements($this->_form->getHeight());
    	$this->_form->addElements(	array(
        			$this->_form->element['hair_color'],
        			$this->_form->element['eye_color']
        ));
        $this->_form->addSubForm($this->_form->buttons,'navigation');
    	$this->_processForm('info2','info1','addressandphone');
    }
