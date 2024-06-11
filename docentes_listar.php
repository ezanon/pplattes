<?php 

include_once 'config.php';
require_once 'functions.php';
require_once './foto.php';

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;

$docentesA = Pessoa::listarDocentes();
$docentesS = Pessoa::listarDocentesAposentadosSenior();
$docs = array_merge($docentesA,$docentesS);

// separa os docentes por departamento
foreach ($docs as $docente){
    $nomdepto = $docente['nomabvset'];
    $codpes = $docente['codpes'];
    $docentes[$codpes]['codpes'] = $docente['codpes'];
    $docentes[$codpes]['Departamento'] = $docente['nomabvset'];
    $docentes[$codpes]['Nome'] = $docente['nompes'] . " <a target=_blank href=" . $linkLattes . Lattes::id($codpes) . "><img width=16px src=$iconLattes /></a>";
    $docentes[$codpes]['e-mail'] = $docente['codema']; 
    $docentes[$codpes]['Telefone'] = '';
    //tratando o ramal
    $telefone = $docente['numtelfmt'];
    $telefone = explode(' - ', $telefone);
    $telefone = explode(')', $telefone[0]);//echo "{$docente['nompes']}  "; print_pre($telefone);
    $docentes[$codpes]['Telefone'] = $telefone[1] ? $telefone[1] : '';
    $caminhoArquivo = __DIR__ . '/fotos/';
    // se foto existe
    if (verificarFotoExiste("{$codpes}.jpg", $caminhoArquivo) == 0){
        salvarFoto($codpes);

    }
    $docentes[$codpes]['Foto'] = $homeCode . "/fotos/" . $codpes . ".jpg";
}

array_multisort (array_column($docentes, 'Nome'), SORT_ASC, $docentes);
