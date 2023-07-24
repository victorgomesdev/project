<?php
spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php');// sem precisar usar a fução include() várias vezes
});

class Request {// Classe usada para representar todas as requisições feitas à API

    private string $action;// String que representa qual ação será realizada pela API
    private array $data;// Objeto (array) que contém os dados da requisição

    public function __construct(string $action, array $data)
    {
        $this->action = $action;
        $this->data = $data;
    }

    public function execute(){
        switch($this->action){// Verifica qual ação é requisitada e chama o Model apropriado
            case 'AUTH': {// Aqui está autenticando um usuário através da classe Login e seu método auth()
                Login::auth($this->data['token']);// Usa o token fornecido pelo usuário
            }
            
            case 'CREATE_USER': {// Criando um novo usuário
                $user = new User($this->data['name'], $this->data['age'], $this->data['email'], $this->data['password'], $this->data['admin'], $this->data['address'], $this->data['phone']);

                Login::create($user);
            }

            case 'SIGN':{// Aqui realiza o login de um usuário, retornando um token para identificá-lo

                Login::sign($this->data['email'], $this->data['password']);
            }
        }
    }
}
