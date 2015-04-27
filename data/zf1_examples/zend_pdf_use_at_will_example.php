<?php
class Zend_Pdf_Exception extends Exception {
	// Nothing
}

include "Zend/Pdf.php";

$pdfPath = dirname(__FILE__) . "/ZFF_VMWare_Instructions_v5.pdf";
try {
	$pdf_in = file_get_contents($pdfPath);
	$pdf = Zend_Pdf::parse($pdf_in);
	echo "\nProperties\n";
	foreach ($pdf->properties as $key => $value) {
		printf("<br />%20s = %s\n", $key, $value);
	}
} catch (Exception $e) {
	echo "<br />" . $e->getMessage() . "\n";
}
