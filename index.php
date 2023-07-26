<?php
/*
    ESTE É O 'ENTRY POINT' DA API, TODAAS AS REQUISIÇÕES FEITAS SÃO PROCESSADAS AQUI ANTES DE SEREM
    ENVIADAS PARA OS CASOS DE USO DEFINIDOS NOS MODELS.

    AS DEFINIÇÕES DE PADRÕES QUE PRECISAM SER SEGUIDOS EM TODOS OS PONTOS DA API SERÃO EXPRESSOS AQUI.

    FAZER AS VALIDAÇÕES DE SEGURANÇA AQUI.
    
    Copyright 2023 - Victor Gomes
*/

//###################################### DEFINIÇÕES DE PADRÕES ############################################

spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php'); // sem precisar de vários 'includes'
});
date_default_timezone_set('America/Sao_Paulo');// Define o fuso-horário usado no sistema
//#########################################################################################################

$new_user = new User('Victor Gomes', 19, 'victorgomesnog123@gmail.com', '12345', true, 'R Dino de Sousa, 576', '34997948928');
Login::create($new_user);