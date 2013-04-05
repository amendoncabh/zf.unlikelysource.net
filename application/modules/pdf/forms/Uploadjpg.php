<?php
class Pdf_Form_Uploadjpg extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setEnctype('multipart/form-data'); 
		// pull options
		$options = Zend_Registry::get('options');
		// file upload fields
		$field = new Zend_Form_Element_File('upload_file');
		$field->setLabel('Upload JPG')
			  ->setDestination($options['pdf']['dir'])
			  ->setAllowEmpty(true)
			  ->addValidator('File_IsImage')
			  ->addValidator('File_Upload')
			  ->addValidator('Extension', false, 'jpg,jpeg')
			  ->addValidator('Count', false, array('min' => 1, 'max' => $options['pdf']['maxPages']));
		$field->setMultiFile($options['pdf']['maxPages']);
		$this->addElement($field);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Upload');
		$this->addElement($submit);
	}
}