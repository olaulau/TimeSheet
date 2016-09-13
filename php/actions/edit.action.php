<?php

require_once __DIR__ . '/../ALL.inc.php';


/* parameters handling */
if(isset($_POST['id'])) {
	$id = $_POST['id'];
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

/* timesheet edit */
if(isset($_POST['start']) && isset($_POST['stop']) && isset($_POST['comment'])) {
	$ts->set_start($_POST['start']);
	$stop = empty($_POST['stop']) ? NULL : $_POST['stop'];
	$ts->set_stop($stop);
	$ts->set_comment($_POST['comment']);
	$ts->save();
}
else {
	die('lack of parameters');
}


header('Location: ../../');
exit;
