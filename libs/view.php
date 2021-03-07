<?php

class View {
    
    function __construct() {
    }

    function render($nombre, $data = []) {
        $this->d = $data;

        $this->handleMessages();

        require 'views/' . $nombre . '.php';
    }

    private function hadleMessages() {
        if (isset($_GET['success']) && isset($_GET['error'])) {
            // error
        } else if ($_GET['success']) {
            $this->handleSuccess();
        } else if ($_GET['error']) {
            $this->handleError();
        }
    }

    private function handleError() {
        $hash = $_GET['error'];
        $error = new ErrorMessages();

        if ($error->existsKey($hash)) {
            $this->d['error'] = $error->get($hash);
        }
    }

    private function handleSuccess() {
        $hash = $_GET['success'];
        $success = new SuccessMessages();

        if ($success->existsKey($hash)) {
            $this->d['success'] = $success->get($hash);
        }
    }

    public function showMessages() {
        $this->showError();
        $this->showSuccess();
    }

    function showErrors() {
        if (array_key_exists('error', $this->d)) {
            echo '<div class="error">' . $this->d['error'] . '</div>';
        }
    }

    public function showSuccess() {
        if (array_key_exists('success', $this->d)) {
            echo '<div class="success">' . $this->d['success'] . '</div>';
        }
    }

}