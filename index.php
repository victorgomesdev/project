<?php

spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php');// sem precisar de vários 'includes'
});

$article = new Article('Meu Outro Artigo', 'Victor Gomes Nogueira', 'Publicando mais um texto', date('d-m-Y'), 'NOGUEIRA, Victor Gomes');

$article->publish();