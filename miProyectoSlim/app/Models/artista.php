<?php
namespace app\Models;

class Artista {
    public static function Info() {
        $db = new \SQLite3(__DIR__ . '/../config/music.db');
        $result = $db->query('SELECT * FROM artista');
        
        $artistas = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $artistas[] = $row;
        }
        return $artistas;
    }
}
