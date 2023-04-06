<?php 
    session_start();
    require("../_funcoes/autenticacao.php");
?>
<!DOCTYPE html>
    <html lang='pt-br'>
        <head>
        <head>
            <!-- Required meta tags -->
            <title>SGTI</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../_css/bootstrap-4.3.1-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../_css/estilosLogin.css">
            <link href="../_css/fontawesome-free-5.10.2-web/css/all.css" rel="stylesheet"> <!--load all styles -->

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        </head>
        <body>
        <?php 
          $etapa = "formulario.php";
         ?> 
            <div class='principal'>
                <div class='esqueceuSenha'>
                        <?php 
                        if(empty($_POST['email'])){
                            include($etapa); 
                        }else{
                            $email = $_POST['email'];
                            echo esqueceuSenha($email);  
                        }
                                              
                         ?>   
                  <br>
                  <br>
            </div>
          
        </body>
  </html>  