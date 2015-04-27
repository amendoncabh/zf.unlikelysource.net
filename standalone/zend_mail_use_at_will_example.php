<?php
require_once "Zend/Mail.php";
try {
	$message = new Zend_Mail('utf-8');
	$message->setFrom('doug@unlikelysource.com','Doug Bierer')
			->setSubject('New Photo')
			->addTo('test@unlikelysource.com', 'Test User');
	$img = $message->createAttachment(file_get_contents('photo.jpg'));
	$img->type		= 'images/jpeg';
	$img->filename	= 'photo.jpg';
	$img->id		= 'GWB';
	$img->disposition	= Zend_Mime::DISPOSITION_INLINE;
	$message->setBodyHtml(
		"Dear Test,<br /><br />Attached please find the photo you requested." .
		"Cheers,<br />db" .
		'<img src="cid:GWB" alt="GWB" />'
	);
	$message->setType(Zend_Mime::MULTIPART_RELATED);
	$message->send(); 
	echo "<br /><b>Message Sent</b>\n";
} catch (Exception $e) {
	echo "<br /><b>Error Sending Message</b> " . $e->getMessage() . "\n";
}
?>