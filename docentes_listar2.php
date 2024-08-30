<?php

require_once __DIR__ . '/vendor/autoload.php';
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Lattes;

require_once 'config.php';
require_once './foto.php';
require_once './functions.php';

//$siglasdeptoss[] = 'GMG,GGG';
//$siglasdeptoss[] = 'GSA,GMP,GPE';
$siglasdeptoss[] = 'GMG,GGG,GSA,GMP,GPE';

foreach ($siglasdeptoss as $siglasdeptos){
    
    //echo "<h2>$siglasdeptos</h2>";

        $docentesA = Pessoa::listarDocentes();
        $docentesS = Pessoa::listarDocentesAposentadosSenior();
        $docentes = array_merge($docentesA,$docentesS);

        // cria array para cada departamento
        foreach ($depto as $coddepto=>$nomdepto){
            $$nomdepto = array();
        }

        // separa os docentes por departamento
        foreach ($docentes as $docente){
            $nomdepto = $docente['nomabvset'];
            $codpes = $docente['codpes'];
            
            $caminhoArquivo = __DIR__ . '/fotos/';
            // se foto existe
            if (verificarFotoExiste("{$codpes}.jpg", $caminhoArquivo) == 0){
                salvarFoto($codpes);

            }
            $foto = $homeCode . "/fotos/" . $codpes . ".jpg";
            $$nomdepto[$codpes]['foto'] = "<img src=$foto />";
            
            $$nomdepto[$codpes]['codpes'] = $codpes;
            $$nomdepto[$codpes]['nome'] = $docente['nompes'];
            $$nomdepto[$codpes]['linkLattes'] = "<a target=_blank href=" . $linkLattes . Lattes::id($codpes) . "><img width=16px src=$iconLattes /></a>";
            $$nomdepto[$codpes]['email'] = $docente['codema']; 
            $login = explode("@", $docente['codema']);
            $$nomdepto[$codpes]['login'] = $login[0];
            
            $$nomdepto[$codpes]['departamento'] = $nomdepto == 'GSA' ? 'GSA: Geologia Sedimentar e Ambiental' : 'GMG: Mineralogia e Geotectônica';

            $telefone = $docente['numtelfmt'];
//            $telefone = explode(' - ', $telefone);
//            $telefone = explode(')', $telefone[0]);
//            $$nomdepto[$codpes]['telefone'] = '(11) ' . $telefone[1];
            $$nomdepto[$codpes]['telefone'] = $telefone = $docente['numtelfmt'];
        }

        // podem ser mais de um departamento enviados separados por vírgula
        $siglasdeptos = explode(',',$siglasdeptos);
        $docentestabelar = array();
        foreach ($siglasdeptos as $sigladepto){
            $docentestabelar = array_merge($docentestabelar,$$sigladepto);
        }
       

        // Extrai a coluna 'nome' para um array separado para usar na ordenação
        foreach ($docentestabelar as $key => $row) {
            $nomes[$key] = $row['nome'];
        }
        // Ordena o array de acordo com a coluna 'nome'
        array_multisort($nomes, SORT_ASC, $docentestabelar);

        // devolve a solicitação tabelada
        echo imprime_tabela($docentestabelar);

}

// coloca os docentes enviados em tabela
function imprime_tabela($docs){

    $i = 0;
    $tabela = "<figure class='wp-block-table is-style-stripes'>\n";
    $tabela .= "
    <style>
        .docentes table {
            width: 100%;
            border-collapse: collapse;
        }

        .docentes th, .docentes td {
            padding: 8px;
        }

        .docentes th {
            background-color: #f2f2f2;
        }

        .docentes td:first-child img {
            max-height: 150px; /* Ajusta a altura máxima para 150px */
            object-fit: cover;
        }

        .docentes tr {
            padding: 10px;
        }

        /* Estilo para links dentro da tabela */
        .docentes table a {
            color: inherit; /* Herdar a cor do elemento pai */
            text-decoration: none; /* Remover sublinhado */
        }
    </style>";
    $tabela.= "<table class='wp-block docentes'>";
    foreach ($docs as $doc){
        
        $tabela.= "               
                <tr>
                    <td><a href=/docente?codpes={$doc['codpes']} >{$doc['foto']}</a></td>\n
                    <td>
                            <h3><a href=/docente?codpes={$doc['codpes']} >{$doc['nome']}</a> {$doc['linkLattes']}</h3>
                            {$doc['departamento']}
                            <br>{$doc['email']}
                            <br>{$doc['telefone']}
                    </td>
                </tr>\n\n";
        
    }
    $tabela.= "</table>\n</figure>\n";
    return $tabela;
}

function imprime_tabela2($docs){
    $i = 0;
    $tabela = "<figure class='wp-block-table is-style-stripes'>\n";
    $tabela.= "<table class=wp-block>";
    
    foreach ($docs as $doc){

        $tabela.= "<tr>\n";
        
        $tabela.= td($doc['foto']);
        
        $info = ""
                . $doc['nome'] . "<br>\n"
                . $doc['email'] . "<br>\n"
                . $doc['telefone'] . "<br>\n"
                . $doc['departamento'] . "<br>\n"
                . $doc['linklattes'] . "\n";
        $info = td($info);
        
//        foreach($doc as $key=>$val){
//            if ($key=='Telefone') $class = "class=has-text-align-right";
//            else $class = "";
//            $tabela.= "<td $class>$val</td>\n";
//        }
        
        $tabela.= "</tr>\n";
        
    }    
    
    $tabela.= "</table>\n</figure>\n";
    return $tabela;    
}


function td($val){
    return "<td>" . $val . "</td>";
}
