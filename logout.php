<?php
session_start();
session_unset();
session_destroy();
header('Location: new22.php');
exit;

?>
