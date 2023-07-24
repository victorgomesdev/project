<?php

class Entity
{

    private string $created_at;
    private string $id;

    public function __construct()
    {
        $this->created_at = date('d-m-Y H:i:s');
        $this->id = hash('sha1', $this->created_at);
    }

    public function get_created_at(): string
    {
        return $this->created_at;
    }

    public function get_id(): string
    {
        return $this->id;
    }
}
