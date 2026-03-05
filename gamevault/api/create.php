<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Game.php';

$database = new Database();
$db = $database->getConnection();
$game = new Game($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->title) && !empty($data->category_id)) {
    
    $game->title = $data->title;
    $game->developer = $data->developer;
    $game->category_id = $data->category_id; 
    $game->status = $data->status;

    if($game->create()) {
        http_response_code(201); 
        echo json_encode(array("message" => "Game berhasil ditambahkan."));
    } else {
        http_response_code(503); 
        echo json_encode(array("message" => "Gagal menambahkan game."));
    }
} else {
   
    http_response_code(400); 
    echo json_encode(array("message" => "Data tidak lengkap. Pastikan mengirim title dan category_id."));
}
?>