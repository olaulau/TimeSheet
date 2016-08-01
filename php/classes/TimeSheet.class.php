<?php

require_once __DIR__ . '/../ALL.inc.php';


class TimeSheet {
	
	private $id = NULL;
	private $start = NULL;
	private $stop = NULL;
	private $comment = NULL;
	
	
	/* getters and setters */
	public function get_id() {
		return $this->id;
	}
	
	public function get_start() {
		return $this->start;
	}
	
	public function get_stop() {
		return $this->stop;
	}
	
	public function get_comment() {
		return $this->comment;
	}
	
	public function set_id($id) {
		$this->id = $id;
	}
	
	public function set_start($start) {
		$this->start = $start;
	}
	
	public function set_stop($stop) {
		$this->stop = $stop;
	}
	
	public function set_comment($comment) {
		$this->comment = $comment;
	}
	
	
	public function save() {
		global $conf;
		
		DB::get()->beginTransaction();
		
		$sql = "LOCK TABLE " . $conf['mysql_table_prefix'].$conf['table_name_data'] . " IN EXCLUSIVE MODE";
		$res = DB::get()->exec($sql);
		
		$sql = "
		UPDATE " . $conf['mysql_table_prefix'].$conf['table_name_data'] . "
		SET id = :id,
			start = :start,
			stop = :stop,
			comment = :comment
		WHERE id = :id";
		$st = DB::get()->prepare($sql);
		$array = array(
			'id' => $this->id,
			'start' => $this->start,
			'stop' => $this->stop,
			'comment' => $this->comment,);
		DB::bindArrayValue($st, $array);
		$res = $st->execute();
		if($st->errorCode() != 0) {
			echo '<pre>' . $sql . '</pre>';
			foreach($st->errorInfo() as $info) {
				echo $info . '<br>';
			}
			die;
		}
		$row_count = $st->rowCount();
// 		var_dump($row_count);
				
		if($row_count === 0) {
			$sql = "
			INSERT INTO " . $conf['mysql_table_prefix'].$conf['table_name_data'] . " (id, start, stop, comment)
			VALUES (:id, :start, :stop, :comment)";
			$st = DB::get()->prepare($sql);
			$array = array(
				'id' => $this->id,
				'start' => $this->start,
				'stop' => $this->stop,
				'comment' => $this->comment,);
			DB::bindArrayValue($st, $array);
			$res = $st->execute();
			if($st->errorCode() != 0) {
				echo '<pre>' . $sql . '</pre>';
				foreach($st->errorInfo() as $info) {
					echo $info . '<br>';
				}
				die;
			}
			$row_count = $st->rowCount();
//			var_dump($row_count);
		}
		
		DB::get()->commit();
	}
	
	
	public function delete() {
		global $conf;
	
		$sql = "
		DELETE FROM " . $conf['mysql_table_prefix'].$conf['table_name_data'] . "
		WHERE id = :id";
		$st = DB::get()->prepare($sql);
		$array = array('id' => $this->id);
		DB::bindArrayValue($st, $array);
		$res = $st->execute();
		if($st->errorCode() != 0) {
			echo '<pre>' . $sql . '</pre>';
			foreach($st->errorInfo() as $info) {
				echo $info . '<br>';
			}
			die;
		}
		$row_count = $st->rowCount();
		// 		var_dump($row_count);
	
		if($row_count === 0) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	
	
	
	public static function get_last() {
		global $conf;
		$dbh = DB::get();
		$sql = '
			SELECT id, start, stop, comment
			FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . ' 
			ORDER BY start DESC
			LIMIT 1';
		//echo "<pre> $sql </pre>";
		$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
		$st->setFetchMode(PDO::FETCH_CLASS, 'TimeSheet');
		$res = $st->fetch(PDO::FETCH_CLASS);
		if($res === FALSE)
			$res = NULL;
		return($res);
	}
	
	
	public static function get_from_id($id) {
		global $conf;
		$dbh = DB::get();
		$sql = '
			SELECT id, start, stop, comment
			FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . ' 
			WHERE id = ' . DB::get()->quote($id);
		//echo "<pre> $sql </pre>";
		$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
		$st->setFetchMode(PDO::FETCH_CLASS, 'TimeSheet');
		$res = $st->fetch(PDO::FETCH_CLASS);
		if($res === FALSE)
			$res = NULL;
		return($res);
	}
	
	
	public static function get_all() {
		global $conf;
		$dbh = DB::get();
		$sql = '
			SELECT id, start, stop, comment
			FROM ' . $conf['mysql_table_prefix'].$conf['table_name_data'] . '
			ORDER BY start ASC';
		//echo "<pre> $sql </pre>";
		$st = $dbh->query($sql) or die(print_r($dbh->errorInfo(), true));
		$st->setFetchMode(PDO::FETCH_CLASS, 'TimeSheet');
		$res = $st->fetchAll(PDO::FETCH_CLASS, 'TimeSheet');
		if($res === FALSE)
			$res = NULL;
		return($res);
	}
	
	
	public static function can_start() {
		$ts = self::get_last();
		if(!isset($ts)) // table vide
			return TRUE;
		else
			return (isset($ts->stop)) ;
	}
	
	public static function can_stop() {
		return !(self::can_start());
	}

	
	
	public static function start($comment) {
		global $conf;
		if(self::can_start()) {
			$ts = new TimeSheet();
			$ts->start =  DB::get_sql_date();
			$ts->comment = isset($comment) ? $comment : 'tâche en cours';
			$ts->save();
		}
		else {
			// exception
			die("can't start timesheet.");
		}
	}
	
	
	public static function stop($comment) {
		global $conf;
		if(self::can_stop()) {
			$ts = TimeSheet::get_last();
			$ts->stop = DB::get_sql_date();
			$ts->comment = isset($comment) ? $comment : NULL;
			$ts->save();
		}
		else {
			// exception
			die("can't stop timesheet.");
		}
	}
	
	
	
}

