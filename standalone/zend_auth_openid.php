<?php
require 'Zend/Auth.php';
require 'Zend/Auth/Adapter/OpenId.php';

$status = "";
$auth = Zend_Auth::getInstance();
if ((isset($_POST['openid_action']) &&
     $_POST['openid_action'] == "login" &&
     !empty($_POST['openid_identifier'])) ||
    isset($_GET['openid_mode']) ||
    isset($_POST['openid_mode'])) {
    $result = $auth->authenticate(
        new Zend_Auth_Adapter_OpenId(@$_POST['openid_identifier']));
    if ($result->isValid()) {
        $status = "You are logged in as "
                . $auth->getIdentity()
                . "<br>\n";
    } else {
        $auth->clearIdentity();
        foreach ($result->getMessages() as $message) {
            $status .= "$message<br>\n";
        }
    }
} else if ($auth->hasIdentity()) {
    if (isset($_POST['openid_action']) &&
        $_POST['openid_action'] == "logout") {
        $auth->clearIdentity();
    } else {
        $status = "You are logged in as "
                . $auth->getIdentity()
                . "<br>\n";
    }
}
?>
<html><body>
<?php echo htmlspecialchars($status);?>
<form method="post"><fieldset>
<legend>OpenID Login</legend>
<input type="text" name="openid_identifier" value="">
<input type="submit" name="openid_action" value="login">
<input type="submit" name="openid_action" value="logout">
</fieldset></form></body></html>
