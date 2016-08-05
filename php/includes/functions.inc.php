<?php


function app_base_path() {
	// 	echo $_SERVER['PHP_SELF'] . "<br/>";
	// 	echo $_SERVER['SCRIPT_NAME'] . "<br/>";
	// 	echo $_SERVER['SCRIPT_FILENAME'] . "<br/>";
	// 	echo "<br/>";
	// 	echo __FILE__ . "<br/>";
	// 	echo __DIR__ . "<br/>";
	// 	echo "<br/>";
	// 	echo $_SERVER['SCRIPT_FILENAME'] . "<br/>";
	// 	echo " - <br/>";
	// 	echo $_SERVER['SCRIPT_NAME'] . "<br/>";
	// 	echo " = <br/>";
	$webroot = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
	// 	echo $webroot . "<br/><br/>";
	// 	echo __DIR__ . "<br/>";
	// 	echo " - <br/>";
	// 	echo $webroot . "<br/>";
	// 	echo " = <br/>";
	$app_base_path = str_replace($webroot, '', __DIR__);
	$app_base_path = dirname(dirname($app_base_path)); //  because we are in a subdir, we must go to parent
	// 	echo $app_base_path . "<br/><br/>";
	return $app_base_path;
}

/* date functions */
function format_datetime($datetime) {
	if(isset($datetime)) {
		$datetime = new DateTime($datetime);
		$datetime = $datetime->format('Y-m-d H:i');
	}
	return $datetime;
}

function format_time($datetime) {
	if(isset($datetime)) {
		$datetime = new DateTime($datetime);
		$datetime = $datetime->format('H:i');
	}
	return $datetime;
}

function format_date($datetime) {
	if(isset($datetime)) {
		$datetime = new DateTime($datetime);
		$datetime = $datetime->format('Y-m-d');
	}
	return $datetime;
}

function format_interval($diff) {
	if(isset($diff)) {
		$diff = $diff->format('%R %H:%I');
	}
	return $diff;
}

function calculate_interval($time1, $time2) {
	if(isset($time1) && isset($time2)) {
		$time1 = new DateTime('01-01-01 '. $time1);
		$time2 = new DateTime('01-01-01 '. $time2);
		$diff = $time2->diff($time1);
		return $diff;
	}
	else {
		return NULL;
	}
}

