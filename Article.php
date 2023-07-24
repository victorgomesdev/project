<?php

class Article
{

    private string $title;
    private string $author;
    private string $body;
    private string $created_at;
    private string $refer;

    public function __construct(string $title, string $author, string $body, string $refer)
    {
        $this->title = $title;
        $this->author = $author;
        $this->body = $body;
        $this->created_at = date('d-m-Y');
        $this->refer = $refer;
    }

    public function get_content()
    {
        $content = [
            'title' => $this->title,
            'author' => $this->author,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'refer' => $this->refer
        ];

        return $content;
    }

    public function publish()
    {

        $query = "INSERT INTO articles(title, author, body, created_at, refer, alter_at) VALUES(?,?,?,?,?,?);";

        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ssssss', $this->title, $this->author, $this->body, $this->created_at, $this->refer, $this->created_at);
            $execution->execute();
            $result = $execution->error;

            if ($result) {
                $conn->close();
                Response::send(200, ['message' => 'Ocorreu um erro']);
            } else {
                $conn->close();
                Response::send(200, ['message' => 'Artigo adicionado']);
            }
        } catch (Exception $err) {
            Response::send(200, [$err]);
        }
    }

    public static function alter(string $title, string $author, string $new_content, string $field)
    {

        $query = "UPDATE articles SET $field = ?, alter_at = ? WHERE author = ? AND title = ?;";
        $alter = date('d-m-Y');
        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ssss', $new_content, $alter, $author, $title);
            $execution->execute();

            $result = $execution->error;

            if ($result) {
                $conn->close();
                Response::send(200, ['message' => 'Ocorreu um erro']);
            } else {

                $conn->close();
                Response::send(200, ['message' => 'Alteração feita com sucesso']);
            }
        } catch (Exception $err) {
            echo $err;
        }
    }

    public static function delete(string $title, string $author)
    {

        $query = 'DELETE FROM articles WHERE title = ? AND author = ?;';

        try {
            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ss', $title, $author);
            $execution->execute();
            $result = $execution->error;

            if ($result) {
                $conn->close();
                Response::send(200, ['message' => 'Ocorreu um erro']);
            } else {

                $conn->close();
                Response::send(200, ['message' => 'Artigo excluído']);
            }
        } catch (Exception $err) {
            echo $err;
        }
    }
}
