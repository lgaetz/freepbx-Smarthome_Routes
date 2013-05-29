<?php
if (! function_exists("out")) {
	function out($text) {
		echo $text."<br />";
	}
}

if (! function_exists("outn")) {
	function outn($text) {
		echo $text;
	}
}

global $db;
global $amp_conf;

if($amp_conf["AMPDBENGINE"] == "sqlite3")  {
	$sql = "
	CREATE TABLE IF NOT EXISTS smarthomeroute 
	(
		`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
		`name` varchar(45) not null, 
		`cid` varchar(45) null, 
		`destination` varchar(50) null 
	);
	";
}
else  {
	$sql = "
	CREATE TABLE IF NOT EXISTS smarthomeroute 
	(
		`id` int UNIQUE AUTO_INCREMENT,	 
		`name` varchar(45) not null, 
		`cid` varchar(45) not null,  
		`destination` varchar(50) null 
	);
	";
}
$check = $db->query($sql);
if(DB::IsError($check)) {
	die_freepbx("Can not create SmartHomeRoute DB table");
}

?>
