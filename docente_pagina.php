<?php

require_once 'config.php';

$codpes = $senior = filter_input(INPUT_GET, 'codpes');

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;
use Uspdev\Wsfoto;
use Ezanon\CoisasLocais\CoisasLocais;

require_once './functions.php';
require_once './foto.php';

$nomePessoa = Pessoa::obterNome($codpes);
$emailPessoa = Pessoa::email($codpes);
$telefone = Pessoa::obterRamalUsp($codpes);
$telefone = explode(' - ', $telefone);
$telefone = explode(')', $telefone[0]);
$fonePessoa = '(11)' . $telefone[1];
$fonePessoa = Pessoa::obterRamalUsp($codpes);

$ods = CoisasLocais::obterODS($codpes);

//dupla vinculação
$dv = false;
if (CoisasLocais::ehDuplaVinculacao($codpes)){
    $infosdv = CoisasLocais::obterInfoDuplaVinculacao($codpes);
    $dvi = 'Docente com Dupla Vinculação (' . $infosdv['duplavinculacao_unidade'] . ')';
    $dv = true;
}

$caminhoArquivo = __DIR__ . '/fotos/';
// se foto existe
if (verificarFotoExiste("{$codpes}.jpg", $caminhoArquivo) == 0){
    salvarFoto($codpes);

}

$foto = $urlFotos . $codpes . ".jpg";

$idLattes = Lattes::id($codpes);
$arrayLattes = Lattes::obterArray($codpes);

$resumoLattes = Lattes::retornarResumoCV($codpes);
$ultimaAtualizacaoLattes = Lattes::retornarDataUltimaAtualizacao($codpes);
$linhasDePesquisaLattes = Lattes::listarLinhasPesquisa($codpes);
$ultimosArtigosLattes = Lattes::listarArtigos($codpes,$arrayLattes,'registros',10);
$formacaoAcademica = Lattes::retornarFormacaoAcademica($codpes);
$nomeCitacoesLattes = $arrayLattes['DADOS-GERAIS']['@attributes']['NOME-EM-CITACOES-BIBLIOGRAFICAS'];
$nomesCitacoesLattes = explode(';', $nomeCitacoesLattes);
$linkLattesPessoa = get_lattes($codpes); 
$linkOrcidPessoa = get_orcid($codpes);

if (!$dv) $depto = Pessoa::obterSiglasSetoresAtivos($codpes);
else $depto[0] = $infosdv['depto'];
$departamento = $depto[0]=='GSA' ? 'GSA: Geologia Sedimentar e Ambiental' : 'GMG: Mineralogia e Geotectônica';
