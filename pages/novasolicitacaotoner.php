<?php
    session_start();
    if(empty($_SESSION["NOME"])){
        header("location:../");
    }
  
    include('../_funcoes/funcoes.php');
    include('../_funcoes/class.php');
    $nome=$_SESSION["NOME"];
    $IDUSUARIO = $_SESSION["IDUSUARIO"];

    $compradorToner = [
        "nome" => "Cleia / Emerson",
        "email" => "suprimax.cartuchos2015@gmail.com"
    ];

    if(isset($_POST["solicitacao"]) && empty($_POST["solicitacao"])==false)
    {
        $nomedestino = $_POST["nomedestino"];
        $emaildestino = $_POST["emaildestino"];
        $solicitacao = $_POST["solicitacao"];

        solicitacao2($nome,$emaildestino,$nomedestino,$solicitacao);
        
    }
 
?>
<!DOCTYPE html>
<html lang="en">
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
        .topo-solicitacao{
            display: block;
            width: 100%;
            height: 80px;
            background-color: #000;
            padding: 20px 12px;
        }
        .topo-solicitacao a {
            color:#fff;
        }
        .corpo-solicitacao{
            display: block;
            width: 100%;
        }
        .formulario{
            display: block;
            width: 50%;
            margin: 60px auto;
        }
    </style>
</head>
<body>
    <div class="topo-solicitacao">
        <a href="index.php?url=solicitacao"><h3>Voltar</h3></a>
    </div>
    <div class="corpo-solicitacao">
        <div class="formulario">
            <form action='' method='POST'>
                <h3>SOLICITAÇÃO</h3>
                <br>
                <div class="form-group">
                    <input type='text' class="form-control" name="nomedestino" placeholder="Nome do detinatario da Solicitação"   value= "<?php echo $compradorToner["nome"];?>" >
                </div>
                <div class="form-group">
                    <input type='text' class="form-control" name="emaildestino" placeholder="E-mail do detinatario da Solicitação"  value= "<?php echo $compradorToner["email"];?>" >
                </div>
                <br>
                <div class="form-group">
                    <textarea  id='idSolicitacao'class="form-control" name='solicitacao' required  >
                      <ul>
                        <li>03 - 283A</li>
                        <li>02 - 2340 (Brother)</li>
                        <li>01 - Cartucho 670xl preto</li>
                      </ul>
                        Obrigado!!
                      <br/>
                      <img src='../_img/gustavo.jpg'>
                    </textarea>
                    <br>
                    <input type='submit' value="ABRIR" class='btn btn-success'>
                </div>
            </form>
        </div>
        
    </div>          
</body>
</html>