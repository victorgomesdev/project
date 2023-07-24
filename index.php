<?php

spl_autoload_register(function ($class) { // Função que carrega automaticamente qualquer classe instanciada
    include($class . '.php');// sem precisar de vários 'includes'
});


Article::delete('Artigo Editado', 'Victor Gomes Nogueira');