<?php

class Response
{ // Classe que representa a resposta do servidor ao cliente

    public static function send(int $status, array $data)
    {// Realiza o envio da resposta, definndo o status, os headers e o corpo da resposta

        http_response_code($status);
        header('Content-Type: application/json');// A troca de informações é feita usando JSON
        echo json_encode($data);
        exit;// Também finaliza a execução do script
    }
}
