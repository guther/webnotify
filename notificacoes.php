<?php

var_dump($_ENV);
exit;


$servername = $_ENV["MYSQL_HOST"];
$username = $_ENV["MYSQL_USER"];
$password = $_ENV["MYSQL_PWD"];
$db = $_ENV["MYSQL_DB"];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

exit;


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
