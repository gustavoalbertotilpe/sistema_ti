<?php
    session_start();
    if(empty($_SESSION["NOME"])){
        header("location:../");
    }
    $IDUSUARIO = $_SESSION["IDUSUARIO"];
    include('../_funcoes/funcoes.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SGTI</title>
    <link rel="stylesheet" href="../_css/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="../_bibliotecas/tinymce/tinymce.min.js"></script>
    <script>
      tinymce.init({
        selector: 'textarea',
        images_upload_url: 'postAcceptor.php',
        images_upload_base_path: '/some/basepath',
        images_upload_credentials: true,
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table directionality emoticons template paste'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
     });
     
    </script>
    <style>
        .topo-lembrete{
            display: block;
            width: 100%;
            height: 80px;
            background-color: #000;
            padding: 20px 12px;
        }
        .topo-lembrete a {
            color:#fff;
        }
        .corpo-lembrete{
            display: block;
            width: 100%;
        }
        .formulario{
            display: block;
            width: 40%;
            float: left;
            padding: 12px;
            border-right:  1px solid #e0e0e0;
        }
        .lembretes{
            display: block;
            width: 60%;
            height: 600px;
            float: left;
            word-wrap: break-word;
            overflow-y: auto;
        }
         td{
       word-wrap:break-word;
    }
    </style>
</head>
 <?php
        if(isset($_POST["data"]) && empty($_POST["data"]) == false)
        {
          salvarLembrete($_POST["data"],$_POST["lembrete"],$IDUSUARIO);
          header("Refresh:0");
        }
    ?>    
<body>
    <div class="topo-lembrete">
        <a href="index.php?url=default"><h3>Voltar</h3></a>
    </div>
    <div class="corpo-lembrete">
        <div class="formulario">
            <form action='' method='POST'>
                <h3>LEMBRETE</h3>
                <br>
                <div class="form-group">
                    <input type='date' class="form-control" name="data">
                </div>
                <br>
                <div class="form-group">
                    <textarea  id='idSolicitacao'class="form-control" name='lembrete' ></textarea>
                    <br>
                    <button class="btn btn-primary" type="submit">SALVAR</button>
                </div>
            </form>
        </div>
        <div class='lembretes'>
            <?php 
                 exibirLembretes($IDUSUARIO);
            ?>     
        </div>
    </div>   
    <?php
        if(isset($_GET["id"]) && empty($_GET["id"]) == false){
            deletaLembrete($_GET["id"]);
        }
    ?>    
</body>
</html>