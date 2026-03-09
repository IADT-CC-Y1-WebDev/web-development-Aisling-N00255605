<?php

class Format {
    public $id;
    public $name;

    private $db;

    public function __construct($data = []) {
        $this->db = DB::getInstance()->getConnection();

        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
        }
    }

    public static function findAll() {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM formats ORDER BY name");
        $stmt->execute();

        $formats = [];
        while ($row = $stmt->fetch()) {
            $formats[] = new Format($row);
        }

        return $formats;
    }

    // Find format by ID
    public static function findById($id) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM formats WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();
        if ($row) {
            return new Format($row);
        }

        return null;
    }

    // Find platforms by game (requires JOIN with game_platform table)
    public static function findByBook($book_id) {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT f.*
            FROM format p
            INNER JOIN book_format gp ON p.id = gp.platform_id
            WHERE gp.book_id = :book_id
            ORDER BY f.name
        ");
        $stmt->execute(['book_id' => $bookId]);

        $platforms = [];
        while ($row = $stmt->fetch()) {
            $platforms[] = new Platform($row);
        }

        return $platforms;
    }
   
    // Convert to array for JSON output
    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}