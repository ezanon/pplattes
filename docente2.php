<!DOCTYPE html>
<html lang="en">
    <?php include "docente_pagina.php"; ?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>IGc/USP :: <?php echo $nomePessoa; ?></title>
  <!-- Adicione os links para os arquivos CSS do Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container mt-5">
  <div class="row">
    <!-- Célula 1 -->
    <div class="col-md-4">
      <div class="card border-0">
        <div class="card-header border-0   text-center">
          <h3><?php echo $nomePessoa; ?></h3> 
        </div>
        <div class="card-body  text-center">
          <!-- Área para uma fotografia -->
          <?php echo "<img src=$foto class=img-fluid>"; ?>
        </div>
      </div>
    </div>

    <!-- Célula 2 -->
    <div class="col-md-8">
      <div class="card border-0">
        <div class="card-header border-0">
          <h5>Informações</h5>
        </div>
        <div class="card-body">
          <!-- Conteúdo da célula 2 -->
          
<?php

echo "<h5>Contato</h5>\n";
echo "<div class=mb-2><p>E-Mail: $emailPessoa<br>\n\n";
echo "Telefone: $fonePessoa</p></div>\n\n";

echo "<h5>Saiba mais nas bases de conhecimento</h5>\n";
echo "<div class=mb-2><p>"
. $linkLattesPessoa . " " .  $linkOrcidPessoa
. "</p></div>\n\n";

if ($linhasDePesquisaLattes){
    echo "<h5>Linhas de Pesquisa</h5>\n"
    . "<p class=mb-2>\n";
    foreach ($linhasDePesquisaLattes as $a){
        echo $a . "<br>";
    }
    echo "</p>";
}

echo "<h5>Nome em citações bibliográficas</h5>\n";
echo "<div class=mb-2><p>" . implode('; ',$nomesCitacoesLattes) . "</p></div>\n\n";


?>
          
        </div>
      </div>
    </div>
  </div>
    
  <!-- Célula abaixo da outra para dispositivos móveis -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card border-0">
        <div class="card-header border-0">   
          <h5>Resumo</h5>
        </div>
        <div class="card-body">

<?php

echo "<div><p>$resumoLattes</p></div>\n\n";

echo "<div><p><em>Última Atualização em $ultimaAtualizacaoLattes</em></p></div>\n\n";

?>            
            
        </div>
      </div>
    </div>
  </div>    

  <!-- Célula abaixo da outra para dispositivos móveis -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card border-0">
        <div class="card-header border-0">   
          <h5>Últimos Artigos Publicados</h5>
        </div>
        <div class="card-body">

<?php

foreach ($ultimosArtigosLattes as $a){
    echo "<p>\n";
    
    // doi
    if ($a['DADOS-BASICOS-DO-ARTIGO']['DOI']) echo "<pre><a href=#>[DOI]{$a['DADOS-BASICOS-DO-ARTIGO']['DOI']}</a></pre>";
    // co-autores do artigo
    $aux = array();    
    foreach ($a['AUTORES'] as $b){
        $aux[] = (in_array($b['NOME-PARA-CITACAO'], $nomesCitacoesLattes) ? '<strong>' . $b['NOME-PARA-CITACAO'] . '</strong>' : $b['NOME-PARA-CITACAO']);  
    }
    $coautores = implode(' ; ',$aux);
    echo $coautores;
    
    // titulo do artigo
    echo " . <em>{$a['TITULO-DO-ARTIGO']}</em>";
    
    // periódico
    echo " . {$a['TITULO-DO-PERIODICO-OU-REVISTA']}, v. {$a['VOLUME']}, p. {$a['PAGINA-INICIAL']}";
    if ($a['PAGINA-FINAL']) echo "-{$a['PAGINA-FINAL']}"; // se não tiver pagina final nem exibe o hífen
    echo ", {$a['ANO']}.";
    
    
    echo "</p>\n\n";
}

?>            
            
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Adicione o link para o arquivo JavaScript do Bootstrap (opcional, mas muitas funcionalidades dependem dele) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
