<?php
class Game {
    private $conn;
    private $table_name = "games";

    public $id;
    public $title;
    public $developer;
    public $category_id; 
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT games.id, games.title, games.developer, categories.name AS genre, games.status 
                  FROM " . $this->table_name . " 
                  LEFT JOIN categories ON games.category_id = categories.id 
                  ORDER BY games.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (title, developer, category_id, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->title, $this->developer, $this->category_id, $this->status])) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET title=?, developer=?, category_id=?, status=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->title, $this->developer, $this->category_id, $this->status, $this->id])) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}
?>