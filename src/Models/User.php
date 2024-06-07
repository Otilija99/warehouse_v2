<?php

namespace Warehouse\Models;

use Warehouse\Utilities\FileStorage;

class User {
    private $filePath;

    public function __construct() {
        $this->filePath = 'data/users.json';
    }

    public function authenticate($access_code) {
        $users = FileStorage::read($this->filePath);
        foreach ($users as $user) {
            if ($user['access_code'] === $access_code) {
                return $user;
            }
        }
        return false;
    }
}
