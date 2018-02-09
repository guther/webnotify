<?php

if(isset($_GET["id"]))
	$id = $_GET["id"];
else
	$id = 0;


$notificacoes = [];

$notificacoes[1] = ["id" => 1, "notificacao" => ["icon" => "http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png", "title" => "Titulo 1", "body" => "Hey there! You've been notified!"]];
$notificacoes[2] = ["id" => 2, "notificacao" => ["icon" => "http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png", "title" => "Titulo 2", "body" => "Notificacao 2"]];
$notificacoes[3] = ["id" => 3, "notificacao" => ["icon" => "http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png", "title" => "Titulo 3", "body" => "Notificacao 3 !!!"]];
//$notificacoes[4] = ["id" => 4, "notificacao" => ["icon" => "http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png", "title" => "Titulo Teste", "body" => "Notificacao Qualquer."]];

$json = false;

if($id>0){
	foreach($notificacoes as $key => $value){
		if($key > $id){
			$json = json_encode($notificacoes[$key]);
			break;
		}
	}
}
else{
	$first_key = key($notificacoes); // First Element's Key
	$json = json_encode($notificacoes[$first_key]);
}

//header('Content-Type: application/json');

echo $json;

?>
