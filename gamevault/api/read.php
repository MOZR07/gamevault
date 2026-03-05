<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/Database.php';
include_once '../models/Game.php';

$database = new Database();
$db = $database->getConnection();
$game = new Game($db);

$stmt = $game->read();
$num = $stmt->rowCount();

if($num > 0) {
    $game_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $game_item = array(
            "id" => $id,
            "title" => $title,
            "developer" => $developer,
            "genre" => $genre, 
            "status" => $status
        );
        array_push($game_arr, $game_item);
    }
    http_response_code(200);
    echo json_encode($game_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Data game tidak ditemukan."));
}
?>