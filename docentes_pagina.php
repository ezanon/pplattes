<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Docentes do IGc</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-card {
            margin-bottom: 10px; /* Espaçamento entre os cards */
            padding: 10px; /* Preenchimento interno para o conteúdo dos cards */ 
            background-color: #f5f5f5; /* Fundo levemente cinza claro */
            margin: 2px;
        }

        .center-image {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        .custom-card a {
            color: black; /* Cor preta para os links */
            text-decoration: none; /* Remover sublinhado dos links */
            transition: color 0.3s; /* Transição suave de cor */
        }

        .custom-card a:hover {
            color: #ffA500; /* Cor laranja ao passar o mouse */
        }

        @media (min-width: 480px) {
            .center-image {
                width: 40%;
            }
            .col-sm-12 {
                width: 98%;
            }
        }

        @media (min-width: 768px) {
            .center-image {
                width: 60%;
            }
            .col-md-6 {
                width: 48%;
            }
        }
        
        @media (min-width: 992px) {
            .center-image {
                width: 60%;
            }
            .col-lg-3 {
                width: 23%;
            }
        } 
        
    </style>
</head>
<body>

<?php include "docentes_listar.php"; ?>
    
    <!--<h1 class="display-4">Corpo Docente do IGc/USP</h1>-->
   
 <div class="container">
    <div class="row">
    
<?php
    foreach ($docentes as $d){
?>       

        <div class="col-lg-3 col-md-6 col-sm-12 custom-card border-secondary">
            <a href="<?php echo $urlDocente; ?>?codpes=<?php echo $d['codpes'] . $zera; ?>">
                <img src="<?php echo $d['Foto']; ?>" class="card-img-top center-image rounded-circle">                
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $d['Nome']; ?></h5>
                    <p class="card-text">
                        <em><?php echo $d['e-mail']; ?></em><br>
                        <?php //echo $d['Telefone']; ?>
                        
                    </p>
                </div>
            </a>
        </div>


        
        
<?php
    }
?>

    </div>
</div>

<script src="path/to/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
