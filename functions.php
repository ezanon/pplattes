<?php

require_once 'config.php';

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;
use Uspdev\Wsfoto;

// retorna com a tag <pre> para exibição de arrays
function print_pre($a){
    echo "<pre>";
    print_r($a);
    echo "</pre>";
    return true;
}

function get_lattes($codpes){
    global $linkLattes, $iconLattes;
    $lattes = Lattes::id($codpes);
    if ($lattes){
            $link = $linkLattes . $lattes;
            $lattes = "<a target=_blank href=$link><img width=20px src={$iconLattes} /></a>";
    }
    else $lattes = '';
    return $lattes;
}

function get_orcid($codpes){
    global $iconOrcid;
    $orcid = Lattes::retornarOrcidID($codpes);
    if ($orcid) {
        $orcid =  " <a target=_blank href=$orcid><img width=24px src=$iconOrcid /></a> ";
    }
    else $orcid = '';
    return $orcid;
}

function verificarFotoExiste($arquivo, $diretorio) {
    $caminhoArquivo = $diretorio . '/' . $arquivo; 
    //echo $caminhoArquivo . " " . file_exists($caminhoArquivo) .  "<br>";
    if (file_exists($caminhoArquivo) == 1) return 1;
    else return 0;
}
                