<?php

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;
require_once 'config.php';

$docentesA = Pessoa::listarDocentes();
$docentesS = Pessoa::listarDocentesAposentadosSenior();
$docentes = array_merge($docentesA,$docentesS);

// Defina o mapeamento entre codpes e nomes amigáveis
$mapping = array();
 foreach ($docentes as $docente){
    $codpes = $docente['codpes'];
    $email = $docente['codema'];
    $login = explode("@", $email);
    $mapping[$codpes] = $login[0];
}
//print_r($mapping);die();

// Se a query string contém 'codpes', redirecione para o nome amigável
if (isset($_GET['codpes'])) {
    $codpes = $_GET['codpes'];
    if (isset($mapping[$codpes])) {
        $name = $mapping[$codpes];
        header("Location: /docentes/docente/$name", true, 301);
        exit();
    }
}

// Se a URL contém o nome amigável, redirecione para o codpes correspondente
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $codpes = array_search($name, $mapping);
    if ($codpes !== false) {
        header("Location: /docentes/docente/?codpes=$codpes", true, 301);
        exit();
    }
}

// Se nenhum redirecionamento ocorrer, exiba uma mensagem de erro ou redirecione para uma página padrão
header("HTTP/1.0 404 Not Found");
echo "Página não encontrada.";
