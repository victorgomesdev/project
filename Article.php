<?php

class Article
{ // Fazer o tratamento dos possíveis erros que podem ocorrer nas queries

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
        $this->created_at = date(DATE_RFC822);
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

            $conn->close();
            Response::send(200, ['message' => 'Artigo publicado com sucesso.']);
        } catch (Exception $err) {
            $conn->close();
            Response::send(200, ['message' => 'O titulo já está em uso.']);
        }
    }

    public static function alter(string $title, string $author, string $body, string $refer)
    {
        $query = "UPDATE articles SET title = ?, author = ?, body = ?, refer = ?, alter_at = ? WHERE title = ? AND author = ?;";
        $alter = date(DATE_RFC822);
        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('sssssss', $title, $author, $body, $refer, $alter, $title, $author);
            $execution->execute();

            if ($execution->affected_rows > 0) {
                $conn->close();
                Response::send(200, ['message' => 'Alteração feita com sucesso.']);
            } else {
                $conn->close();
                Response::send(200, ['message' => 'Nenhum artigo encontrado, verifique os dados informados.']);
            }
        } catch (Exception $err) {
            $conn->close();
            Response::send(200, ['message' => 'Ocorreu um erro, verifique os dados informados.']);
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

            if ($execution->affected_rows > 0) {
                $conn->close();
                Response::send(200, ['message' => 'Artigo excluído']);
            } else {
                $conn->close();
                Response::send(200, ['message' => 'Nenhum artigo encontrado, verifique os dados informados.']);
            }
        } catch (Exception $err) {
            $conn->close();
            Response::send(200, ['message' => 'Ocorreu um erro, verifique os dados informados.']);
        }
    }
}
