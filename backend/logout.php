<?php
session_start();
session_destroy();
header('Location: ../frontend/log_reg.php');
exit();
?> 