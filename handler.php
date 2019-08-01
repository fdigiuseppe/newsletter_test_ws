<?php

//error_reporting(-1);
//ini_set('display_errors', 'On');

require_once ('./class/class_form.php');

$to = (isset($_POST["email"])) ? $_POST["email"] : "";
$sub = (isset($_POST["subject"])) ? $_POST["subject"] : "";
$msg = (isset($_POST["message"])) ? $_POST["message"] : "";

$f = new Form();

$temp_address = explode(';', $to);
$res = [];
foreach ($temp_address as $mail) {
		$f->setForm($mail,$sub,$msg);
		$res = $f->sendMail($f);
		if ($res == 1) {
			$json = array("status" => $res, "msg" => 'Invio OK');
		}
		else $json = array("status" => 0, "msg" => 'Invio KO');
	}


header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($json);

?>