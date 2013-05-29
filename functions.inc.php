<?php

function smarthomeroute_list(){
	$sql = "SELECT id, name FROM smarthomeroute";
	$results= sql($sql, "getAll");

	foreach($results as $result){
		$customers[] = array($result[0],$result[1]);
	}
	return isset($customers)?$customers:null;
}

function smarthomeroute_get($extdisplay){
	$sql="SELECT * FROM smarthomeroute where id=$extdisplay";
	$results=sql($sql, "getRow", DB_FETCHMODE_ASSOC);
	return isset($results)?$results:null;
}

function smarthomeroute_add($name, $cid, $destination){
	$sql="INSERT INTO smarthomeroute (name, cid, destination) values ('$name', '$cid', '$destination')";
	sql($sql);
}

function smarthomeroute_del($extdisplay){
	$sql="DELETE FROM smarthomeroute where id=$extdisplay";
	sql($sql);
}

function smarthomeroute_edit($extdisplay, $name, $cid, $destination){
	$sql="UPDATE smarthomeroute set name='$name' where id='$extdisplay'";
	sql($sql);
	$sql="UPDATE smarthomeroute set cid='$cid' where id='$extdisplay'";
	sql($sql);
	$sql="UPDATE smarthomeroute set destination='$destination' where id='$extdisplay'";
	sql($sql);
}

function smarthomeroute_getcid(){
	$sql="SELECT DISTINCT id from cid order by id";
	$results=sql($sql, "getAll");
	return isset($results)?$results:null;
}
?>
