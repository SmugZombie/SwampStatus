<?php

$status_file = "/var/www/swamp/status.json";

$action = "";
if(isset($_GET['action'])){ $action = $_GET['action']; }

if($action == "set"){
	$status = 0;  $purpose = "";  $updated = "";  $duration = 0;
	if(isset($_GET['status']) && is_int((int)$_GET['status'])){ $status = $_GET['status']; }else{ echo '{"error":"Invalid Status Provided"}'; return; }
	if(isset($_GET['purpose'])){ $purpose = cleanInput($_GET['purpose']); }
	$updated = date('Y-m-d H:i');
	if(isset($_GET['duration']) && is_int((int)$_GET['duration'])){ $duration = $_GET['duration']; }else{ $duration = 15; }

	$newJSON = array();
	$newJSON['status'] = $status;
	$newJSON['duration'] = $duration;
	$newJSON['updated'] = $updated;
	$newJSON['purpose'] = $purpose;

	file_put_contents($status_file, json_encode($newJSON));
	echo file_get_contents($status_file);
}
elseif($action == "get"){
	echo file_get_contents($status_file);
}
elseif($action == "toggle"){

        $current_status = json_decode(file_get_contents($status_file),true)['status'];
        if($current_status == 0){ $new_status = 1; }else{ $new_status = 0; }
        $newJSON = array();
        $newJSON['status'] = $new_status;
        $newJSON['duration'] = "";
        $newJSON['updated'] = date('Y-m-d H:i');
        $newJSON['purpose'] = "SWAMP BUTTON";

        file_put_contents($status_file, json_encode($newJSON));
        echo file_get_contents($status_file);

}

function cleanInput($input){
	return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($input))))));
}
