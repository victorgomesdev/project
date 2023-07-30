<?php

class Chat
{

    // public string $id;
    // public string $contact;// email do usuário
    // public string $img_url;
    // public string $user;

    public static function create(string $contact, string $user, string $img_url)
    {

        $query = "INSERT INTO chats(id, contact, img_url, user) VALUES(?,?,?,?);";
        $id  = hash('sha1', $contact . $user);
        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ssss', $id, $contact, $user, $img_url);
            $execution->execute();

            $conn->close();
            Response::send(200, ['img_url' => $img_url, 'contact' => $contact]);
        } catch (Exception $err) {
            $conn->close();
            Response::send(200, [$err->getMessage()]);
        }
    }

    public static function delete(string $user, string $contact)
    {

        $query = "DELETE * FROM chats WHERE user = ? AND contact = ?;";

        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ss', $user, $contact);
            $execution->execute();

            $conn->close();
            Response::send(200, ['message' => 'Conversa excluída.']);
        } catch (Exception $err) {

            $conn->close();
            Response::send(200, ['message' => 'Ocorreu um erro inesperado.']);
        }
    }

    public static function send_message(string $content)
    {
        $query = "INSERT INTO messages(content, sent_at) VALUES(?,?);";
        $sent_at = date(DATE_RFC822);
        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ss', $content, $sent_at);
            $execution->execute();

            $conn->close();
            Response::send(200, []);
        } catch (Exception $err) {

            $conn->close();
            Response::send(200, ['message' => 'Ocorreu um erro.']);
        }
    }
}
