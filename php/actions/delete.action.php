<?php

require_once __DIR__ . '/../ALL.inc.php';


/* parameters handling */
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	die('no id parameter provided');
}

/* timesheet getting */
$id = intval($id);
$ts = TimeSheet::get_from_id($id);
if(!isset($ts)) {
	die('cannot find timesheet #' . $id);
}

/* timesheet delete */
$ts->delete();


header('Location: ../../');
exit;
