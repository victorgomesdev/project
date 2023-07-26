<?php

class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $address;
    private string $phone;
    private int $age;
    private bool $admin;
    private string $crated_at;

    public function __construct(string $name, int $age, string $email, string $password, bool $admin, string $address, string $phone)
    {
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->address = $address;
        $this->phone = $phone;
        $this->id = hash('sha1', $this->name);
        $this->crated_at = date(DATE_RFC822);
    }

    public function get_data(): array
    {
        $data = [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email,
            'password' => $this->password,
            'admin' => $this->admin,
            'address' => $this->address,
            'phone' => $this->phone,
            'created_at' => $this->crated_at,
            'id'=> $this->id
        ];

        return $data;
    }

    public static function update_data(string $email, string $field, string $new_content){

        $query = "UPDATE users SET $field = ? WHERE email = ?;";

        try{

            $conn = new mysqli(Connection::$host, Connection::$user, Connection::$password, Connection::$database);
            $execution = $conn->prepare($query);
            $execution->bind_param('ss', $new_content, $email);
            $execution->execute();

            if($execution->affected_rows > 0){

                $conn->close();
                Response::send(200, ['message' => 'Dados do perfil atualizados.']);
            }else{

                $conn->close();
                Response::send(200, ['message' => 'Não foi encontrado nenhum usuário, verifique os dados informados.']);
            }
        }catch(Exception $err){

            $conn->close();
            Response::send(200, ['Ocorreu um erro inesperado.']);
        }
    }
}
