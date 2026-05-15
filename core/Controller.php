<?php
class Controller {
    // Base class untuk semua controller
    public function view($name, $data = []) { require_once '../app/views/' . $name . '.php'; }
}
