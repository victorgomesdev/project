<?php
/*
    ESTE É O 'ENTRY POINT' DA API, TODAS AS REQUISIÇÕES FEITAS SÃO PROCESSADAS AQUI ANTES DE SEREM
    ENVIADAS PARA OS CASOS DE USO DEFINIDOS NOS MODELS.

    AS DEFINIÇÕES DE PADRÕES QUE PRECISAM SER SEGUIDOS EM TODOS OS PONTOS DA API SERÃO EXPRESSOS AQUI.

    FAZER AS VALIDAÇÕES DE SEGURANÇA AQUI.
    
    Copyright 2023 - Victor Gomes
*/

//###################################### DEFINIÇÕES DE PADRÕES ############################################

spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php'); // sem precisar de vários 'includes'
});
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso-horário usado no sistema
//#########################################################################################################
if(isset($_POST['name'])){
    $user = new User($_POST['name'], $_POST['age'], $_POST['email'], $_POST['password'], true, $_POST['address'], $_POST['phone']);
    Login::create($user);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <form action="#" method="post">
        <label for="name"></label>
        <input type="text" name="name" id="">
        <label for="age"></label>
        <input type="number" name="age" id="">
        <label for="email"></label>
        <input type="email" name="email" id="">
        <label for="password"></label>
        <input type="password" name="password" id="">
        <label for="address"></label>
        <input type="text" name="address" id="">
        <label for="phone"></label>
        <input type="tel" name="phone" id="">
        <input type="submit" value="Enviar">
    </form>
</body>

</html>