<?php

/*
 * Retorna em arquivo array com os orientadores, cursos e áreas
 * inclusive em inglês se houver
 * 
 * Para os orientadores, adicionar suas descrições diretamente no arquivo texto de saída
 * Estas informaçõe não serão sobrescritas
 * 
 */

// código dos cursos de pós
$codcurs = array(44004, 44005, 44002);

// arquivo texto de saída
$outFile = 'arrayOrientadores.txt';

include 'config.php';

$desc = array();
$desc = include $outFile;

if ($desc == 1)
    $desc = array();

foreach ($codcurs as $codcur) {

// obtém dados do programa
    $endpoint = DOMINIO . '/posgraduacao/programas/' . $codcur;
    $json = file_get_contents($endpoint);
    $programa = json_decode($json, true);

    $endpoint = DOMINIO . '/posgraduacao/areasProgramas/' . $codcur;
    $json = file_get_contents($endpoint);
    $areas = json_decode($json, true);

    $desc[$codcur]['nomcur']['br'] = $programa[0]['nomcur'];
    //$desc[$codcur]['nomcur']['en'] = '';
    //$desc[$codcur]['nomcur']['es'] = '';

    foreach ($areas[$codcur] as $area) {

        $codare = $area['codare'];
        $nomare = $area['nomare'];

        $desc[$codcur][$codare]['nomare']['br'] = $nomare;
        //$desc[$codcur][$codare]['nomare']['en'] = '';
        //$desc[$codcur][$codare]['nomare']['es'] = '';

        $endpoint = DOMINIO . '/posgraduacao/orientadores/' . $codare;

        $json = file_get_contents($endpoint);
        $resource = json_decode($json, true);

        foreach ($resource as $row) {

            // get idLattes
            $endpoint = DOMINIO . '/lattes/idLattes/' . $row['codpes'];
            $json = file_get_contents($endpoint);
            $resLattes = json_decode($json, true);
            $linkCur = $linkLattes . $resLattes['idLattes'];

            $desc[$codcur][$codare][$row['codpes']]['nome'] = $row['nompes'];
            //$desc[$codcur][$codare][$row['codpes']]['desc_br'] = '';
            //$desc[$codcur][$codare][$row['codpes']]['desc_en'] = '';
            //$desc[$codcur][$codare][$row['codpes']]['desc_es'] = '';
            $desc[$codcur][$codare][$row['codpes']]['linkLattes'] = $linkCur;
            $desc[$codcur][$codare][$row['codpes']]['nivel'] = $row['nivare'];
            $desc[$codcur][$codare][$row['codpes']]['validade'] = date('d/m/Y', strtotime($row['dtavalfim']));
        }
    }
}

file_put_contents($outFile, '<?php return ' . var_export($desc, true) . ';');
