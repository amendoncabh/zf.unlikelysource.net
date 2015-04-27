<?php
$loc  = strtolower(strip_tags($_GET['loc']));
$loc  = ($loc == 'flash') ? 'Flash' : 'Labs';
$head = sprintf('Location: http://php.zff/%s/player.html', $loc);
header($head);
exit;
