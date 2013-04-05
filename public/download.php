<?php
require __DIR__ . '/../application/modules/demos/models/Demos.php';
$demosAvailable = Demos_Model_Demos::$demos;
$demoRequested = strip_tags(strtolower($_GET['demo']));
$demoKey = array_search($demoRequested, $demosAvailable);
if ($demoKey) {
    $demoUsed = $demosAvailable[$demoKey];
    $demoFile = __DIR__ . '/../data/demos/' . ucfirst($demoUsed) . 'Demo.zip';
    if (file_exists($demoFile)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($demoFile));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($demoFile));
	    ob_clean();
	    flush();
	    readfile($demoFile);
    }
} else {
   	header('Location: http://zf.unlikelysource.net/');
}
exit;