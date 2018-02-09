<?php
$servername = $_ENV["MYSQL_HOST"];
$username = $_ENV["MYSQL_USER"];
$password = $_ENV["MYSQL_PWD"];
$db = $_ENV["MYSQL_DB"];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if(isset($_GET["id"]))
	$id = intval($_GET["id"]);
else
	$id = 0;
	

$st = $conn->prepare("select * from tb_notifications where id > ? order by id asc");
$st->execute([$id]);

$notificacoes = [];


for($i=0; $row = $st->fetch(PDO::FETCH_ASSOC); $i++){
	$icon = empty($row["icon"])?"http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png":$row["icon"];
	$notificacoes[$row["id"]] = ["id" => $row["id"], "notificacao" => ["icon" => $icon,
																		"title" => $row["title"],
																		"body" => $row["body"]]];	
}

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

header('Content-Type: application/json');

echo $json;

?>
