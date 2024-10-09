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
                
function gerarIconesODS($ods)
{
    // Declara $folderODS como global
    global $folderODS;
    
    // Explode o ODS separado por vírgulas
    $odsArray = explode(',', $ods);
    
    // Ordena em ordem crescente
    sort($odsArray, SORT_NUMERIC);

    // Define as descrições para cada ODS
    $descriptions = [
        1 => "Erradicação da Pobreza",
        2 => "Fome Zero e Agricultura Sustentável",
        3 => "Saúde e Bem-estar",
        4 => "Educação de Qualidade",
        5 => "Igualdade de Gênero",
        6 => "Água Potável e Saneamento",
        7 => "Energia Acessível e Limpa",
        8 => "Trabalho Decente e Crescimento Econômico",
        9 => "Indústria, Inovação e Infraestrutura",
        10 => "Redução das Desigualdades",
        11 => "Cidades e Comunidades Sustentáveis",
        12 => "Consumo e Produção Responsáveis",
        13 => "Ação Contra a Mudança Global do Clima",
        14 => "Vida na Água",
        15 => "Vida Terrestre",
        16 => "Paz, Justiça e Instituições Eficazes",
        17 => "Parcerias e Meios de Implementação"
    ];

    // Gera as imagens e a área de descrição fixa
    $output = '<div style="text-align:left;">';

    // Loop pelos ODS para gerar os ícones
    foreach ($odsArray as $num) {
        $numPadded = str_pad($num, 2, '0', STR_PAD_LEFT);
        $description = isset($descriptions[$num]) ? $descriptions[$num] : 'ODS ' . $num;

        // Exibe a imagem e define evento de hover para atualizar a descrição
        $output .= '<div style="display:inline-block; margin: 5px; position:relative;">
                        <a href=https://brasil.un.org/pt-br/sdgs/' . $num . '>
                            <img src="' . $folderODS . '/SDG-' . $numPadded . '.jpg" alt="ODS ' . $num . '" style="width:60px; height:60px;" 
                            onmouseover="document.getElementById(\'ods-description\').innerText=\'' . $description . '\';" 
                            onmouseout="document.getElementById(\'ods-description\').innerText=\'\';"/>
                        </a>
                    </div>';
        
    }

    // Cria a linha fixa onde as descrições serão exibidas
    $output .= '</div><div style="text-align:left; margin-top:10px;">
                    <span id="ods-description" style="font-size:14px; min-height:20px; display:block;"></span>
                </div>';

    return $output;
}
