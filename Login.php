<?php

spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php'); // sem precisar de vários 'includes'
});

class Login
{

    public static function auth(string $token)
    {
        if ($token != 'Victor Gomes') {
            Response::send(403, ['message' => 'Not allowed']);
        }

        Response::send(200, ['message' => 'Access allowed']);
    }

    public static function create(User $user) // Recebe um objeto do tipo User e insere seus dados no Banco de Dados
    {
        $query = "INSERT INTO users(id,name,email,password,address, phone,age,admin, created_at) VALUES(?,?,?,?,?,?,?,?,?);";
        $hashed_password = password_hash($user->get_data()['password'], PASSWORD_DEFAULT); // Criptografa a senha

        try { // Tenta conectar ao Banco de Dados

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('sssssssss', $user->get_data()['id'], $user->get_data()['name'], $user->get_data()['email'], $hashed_password, $user->get_data()['address'], $user->get_data()['phone'], $user->get_data()['age'], $user->get_data()['admin'], $user->get_data()['created_at']);
            $execution->execute(); // Se a conexão for estabelecida, executa a query

            $conn->close();
            Response::send(200, ['message' => 'Usuário adicionado.']); // Envia a resposta ao cliente através da
            // classe Response e seu método send()
        } catch (Exception $err) {
            $conn->close();
            Response::send(200, ['message' => $err->getMessage()]);
        }
    }

    public static function sign(string $email, string $password)
    { // Verifica se os dados fornecidos são de um usuário existente

        $query = "SELECT email, password FROM users WHERE email = ?;";

        try {

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database); // Estabelece a conexão

            $execution = $conn->prepare($query);
            $execution->bind_param('s', $email);
            $execution->execute();
            $result = $execution->get_result();
            $found_user = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                if (password_verify($password, $found_user['password'])) {

                    $conn->close();
                    Response::send(200, ['message' => 'Usuário logado.']);
                } else {

                    $conn->close();
                    Response::send(200, ['message' => 'Senha incorreta.']);
                }
            } else {

                $conn->close();
                Response::send(200, ['message' => 'Usuário não encontrado.']);
            }
        } catch (Exception $err) {

            $conn->close();
            Response::send(200, ['message' => 'Algo deu errado</br>']);
        }
    }
}
