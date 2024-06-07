<?php

namespace Warehouse\Utilities;

class FileStorage {
    public static function read($filePath) {
        if (!file_exists($filePath)) {
            return [];
        }
        $data = file_get_contents($filePath);
        return json_decode($data, true);
    }

    public static function write($filePath, $data) {
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
