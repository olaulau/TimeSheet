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
	$app_base_path = dirname($app_base_path); //  because we are in a subdir, we must go to parent
	// 	echo $app_base_path . "<br/><br/>";
	return $app_base_path;
}

