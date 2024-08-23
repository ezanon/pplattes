<?php

# Este script cria um arquivo com codpes, nome e login dos docentes
# Os valores são separados por pipe |
# São usados para criação automática de páginas no wordpress, com o slug igual ao login

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;
require_once 'config.php';

$docentesA = Pessoa::listarDocentes();
$docentesS = Pessoa::listarDocentesAposentadosSenior();
$docentes = array_merge($docentesA,$docentesS);

// Defina o mapeamento entre codpes e nomes amigáveis
$mapping = array();
$i = 0;
foreach ($docentes as $docente){
    $codpes = $docente['codpes'];
    $email = $docente['codema'];
    $login = explode("@", $email); 
    
    $mapping[$i]['slug'] = $login[0];
    $mapping[$i]['codpes'] = $codpes;
    
    $i++;
    
}

// Abre o arquivo CSV para escrita
$txtFile = 'redirects.map';
$handle = fopen($txtFile, 'w');

// Verifica se o arquivo foi aberto com sucesso
if ($handle === false) {
    die('Não foi possível abrir o arquivo para escrita.');
}

// Define o cabeçalho do CSV
$header = ['slug','codpes'];
fwrite($handle, implode(' ', $header) . PHP_EOL);

// Adiciona os dados ao arquivo CSV
foreach ($mapping as $row) {
    $line = implode(' /docente/?codpes=', $row);
    fwrite($handle, $line . PHP_EOL);
}

// Fecha o arquivo
fclose($handle);
