<?php

class Quiz {

    private string $title;
    private string $description;
    private string $code;
    private int $userId;

    public function __construct($title, $description, $code, $userId) {
        $this->title = $title;
        $this->description = $description;
        $this->code = $code;
        $this->userId = $userId;
    }

    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getCode() { return $this->code; }
    public function getUserId() { return $this->userId; }
}