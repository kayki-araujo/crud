<?php
session_start();

include "config.php";
include DIR_TEMPLATE . "/header.php";

/**
 * Função para realizar o carregamento automatico das classes
 */
spl_autoload_register(function ($classe) {
    include "./classes/" . $classe . ".php";
});

if (isset($_GET["path"])) {
    #Remove a '/' da direita
    $path = rtrim($_GET["path"], "/");
    #Separação da string
    $path = explode("/", $path);

    #Definir pagina a ser carregada
    $pagina = $path[0];
    $url_pagina = URL_HOME . "/" . $pagina;

    #Verificar se uma ação está sendo indicada
    if (isset($path[1])) {
        $acao = $path[1];
    } else {
        $acao = null;
    }

    #Verificar se um codigo esta sendo passado
    if (isset($path[2])) {
        $codigo = $path[2];
    } else {
        $codigo = null;
    }

    #Verificar se o arquivo da pagina existe
    if (in_array($pagina, array("professores", "turmas", "alunos"))) {
        #Sim: carregar página
        include DIR_HOME . "/paginas/" . $pagina . ".php";
    } else {
        #Não: carregar página de erro
        include "notfound.php";
    }
} else {
    print "<h1>Clique em uma das opçoes</h1>";
}

include DIR_TEMPLATE . "/footer.php";
