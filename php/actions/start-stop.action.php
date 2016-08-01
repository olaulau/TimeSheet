<?php

require_once __DIR__ . '/../ALL.inc.php';


if($_POST['action'] === 'start') {
	TimeSheet::start($_POST['comment']);
}
elseif($_POST['action'] === 'stop') {
	TimeSheet::stop($_POST['comment']);
}
else {
	die('no proper action parameter provided');
}

header('Location: ../../');
exit;
