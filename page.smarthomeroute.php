<?php
//CustomerDB 1.00 written by Keith Dowell 2006-04-07
//Copyright (C) 2006 Keith Dowell (snowolfex@yahoo.com)
// re-written 2012-04-09 by Kenneth Kolbly to be a "SmartHome Routing" table
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

//Set all the vars so there are not a ton of errors in the httpd error_log
$display = isset($_REQUEST['display'])?$_REQUEST['display']:'smarthomeroute';
$type = isset($_REQUEST['type'])?$_REQUEST['type']:'tool';

$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$name = isset($_REQUEST['name'])?$_REQUEST['name']:'';
$cid = isset($_REQUEST['cid'])?$_REQUEST['cid']:'';
$destination = isset($_REQUEST['destination'])?$_REQUEST['destination']:'';

extract($_REQUEST);

$dispnum='smarthomeroute';

if(!isset($action))
	$action='';
switch($action) {
	case "add":
		smarthomeroute_add($name, $cid, $destination);
		$name='';
		$cid='';
		$destination='';
		//needreload(); 
		//right now... not writing config files... don't need to reload
		redirect_standard();
	break;
	case "del":
		smarthomeroute_del($extdisplay);
		//needreload();
		redirect_standard();
	break;
	case "edit":
		smarthomeroute_edit($extdisplay, $name, $cid, $destination);
		//needreload();
		redirect_standard('extdisplay');
	break;
	
}
?>
<div class="rnav">
<?php
$customers=smarthomeroute_list();
drawListMenu($customers, $skip, $type, $dispnum, $extdisplay, _("SmartHome Route"));
?>
</div>


<div class="content">
<?php
if($action=='del'){
	echo "<br><h3>ID ".$extdisplay." "._("deleted")."!</h3><br><Br><br><br><br><br><br>";
}
else if(!isset($extdisplay)) {

		
	echo "<h2>"._("Add a SmartHome Route")."</h2>";
//	echo "<li><a href=\"".$_SERVER['PHP_SELF']."?$action=add\";>Add</a><br>";

}
else {
	$delURL = $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."&action=del&extdisplay=$extdisplay";

	//If we have some data, load it up... this means we are editing.
	if($extdisplay!=""){
		$customerInfo=smarthomeroute_get($extdisplay);
		$name=$customerInfo['name'];
		$cid=$customerInfo['cid'];
		$destination=$customerInfo['destination'];
	}
		
	
	if(isset($customerInfo) && is_array($customerInfo)){
		$action="edit";
		echo "<h2> ".$extdisplay." ".$name."</h2>";
		echo "<p><a href=\"".$delURL."\">"._("Delete SmartHome Route Entry")."</a></p>";
	}
	else {
		echo "<h2>"._("Add SmartHome Route Entry")."</h2>";
	}

}

echo "<form name=\"addNew\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" onsubmit=\"return addNew_onsubmit();\">";
echo "<input type=hidden name=type value='tool'>\n";
echo "<input type=hidden name=extdisplay value=$extdisplay>\n";
echo "<input type=hidden name=action value=\"";
echo ($action=="" ? "add" : $action);
echo "\">\n";
echo "<input type=hidden name=display value=\"smarthomeroute\">";

echo "<table>";
	
echo "<tr><td colspan=2><h5>";
echo ($extdisplay ? _('Edit SmartHome Route Entry') : _('Add SmartHome Route'));
echo "</h5></td></tr>\n";

//Name
echo "<tr ";
echo ($extdisplay ? '' : '');
echo "><td>";
echo "<a href=\"#\" class=\"info\" >"._("Name")."\n";
echo "<span>"._("Entry Name (REQUIRED)")."</span></a>\n";
echo "</td>";
echo "<td>";
echo "<input type=text name=\"name\" value=\"$name\" tabindex=".++$tabindex.">\n";
echo "</td></tr>\n";

//CID (Caller ID)
echo "<tr><td>\n";
echo "<a href=\"#\" class=\"info\">"._("Caller ID")."\n";
echo "<span>"._("Caller-ID")."</span></a>\n";
echo "</td><td>\n";
echo "<input type=text name=\"cid\" value=\"$cid\" tabindex=".++$tabindex.">\n";
echo "</td></tr>\n";

//Action or Destination
echo "<tr><td>\n";
echo "<a href=\"#\" class=\"info\">"._("Destination")."\n";
echo "<span>"._("Action or Destination")."</span></a>\n";
echo "</td><td>\n";
echo "<input type=text name=\"destination\" value=\"$destination\" tabindex=".++$tabindex.">\n";
echo "</td></tr>\n";


?>
<tr><td></td><td><input type=submit Value="Submit Changes" tabindex="<?php echo ++$tabindex;?>"></td></tr></table>

<script language="javascript">
var cform = document.addNew;
if(cform.name.value == ""){
	cform.name.focus();
}


function addNew_onsubmit() {

	var msgInvalidName = "<?php echo _("Please enter a descriptive name for the entry");?>";
	var msgInvalidCid = "<?php echo _("You must have a Caller_ID for each entry.");?>";

	if(isEmpty(cform.name.value)){
		return warnInvalid(cform.name, msgInvalidName);
	}
}


</script>



</form>
