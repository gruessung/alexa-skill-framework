<?php
header('HTTP/1.1 400 Bad Request');
require_once('vendor/autoload.php');
ini_set("log_errors", 1);
ini_set("error_log", "./alexa.log");

$aSkills = array(
		"SKILL_FOLDER_NAME" => "SKILL_ID"
);

if (isset($_GET['skill']) && !empty($_GET['skill'])){
	$sName = $_GET['skill'];
}

$applicationId = @$aSkills[$sName]; // See developer.amazon.com and your Application. Will start with "amzn1.echo-sdk-ams.app."
$rawRequest = file_get_contents('php://input');


if (file_exists('Skill'.$sName.'/index.php')) {
	require_once('Skill'.$sName.'/index.php');
	$oSkill = new $sName($rawRequest, $applicationId);
} else {
    $response = new \Alexa\Response\Response;
    $response->respond('Sorry, i cannot find the requested skill.');
    $response->endSession(true);
    header('Content-Type: application/json');
    $sRespond = json_encode($response->render());
    header('HTTP/1.1 200 OK');
    echo $sRespond;
}
?>
