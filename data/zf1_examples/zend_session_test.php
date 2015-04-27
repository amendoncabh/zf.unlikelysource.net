<?php
require_once 'Zend/Session.php';
$defaultNamespace = new Zend_Session_Namespace('Default');
if (isset($defaultNamespace->numberOfPageRequests)) {
	$defaultNamespace->numberOfPageRequests++;
} else {
	$defaultNamespace->numberOfPageRequests = 1;
}
$msg = "Page requests: " . $defaultNamespace->numberOfPageRequests;
?>
<html>
<body>
<?php echo $msg; ?>
<p>
<form>
<input type=submit />
</form>
</p>
</body>
</html>
