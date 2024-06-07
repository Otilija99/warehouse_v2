<?php

namespace Warehouse\Controllers;

use Warehouse\Models\User;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function authenticate($access_code) {
        return $this->userModel->authenticate($access_code);
    }
}
