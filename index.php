<?php 
    session_start();
    require("_funcoes/autenticacao.php");
?>
<!DOCTYPE html>
    <html lang='pt-br'>
        <head>
        <head>
            <!-- Required meta tags -->
            <title>SGTI</title>
            <meta charset="utf-8">
	    <link rel="shortcut icon" type="image/x-icon" href="_img/fivecom.png">	
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="_css/bootstrap-4.3.1-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="_css/estilosLogin.css">
            <link href="_css/fontawesome-free-5.10.2-web/css/all.css" rel="stylesheet"> <!--load all styles -->

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        </head>
        <body>
            <div class='principal'>
                <h1>SGTI</h1>
                <div class='login'>
                    <form action='index.php' method='POST'>
                        <input type='text' name='usuario' placeholder='Usuario' size=40 autocomplete='off' autofocus>
                        <br>
                        <br>
                        <input type='password'  name='senha' placeholder='Senha' size=40>
                        <br>
                        <br>
                        <input class="btn btn-success" type='submit' value='logar'>
                    </form>
                    <br>
                    <center><a href='esqueceusenha/'>Esqueceu a senha?</a></center>
                </div>
            </div>
            <?php
                if(isset($_POST['usuario'])){
                    $usuario = $_POST['usuario'];
                    $senha = md5($_POST['senha']);
                    echo autenticacao($usuario,$senha);
                }
            ?>
        </body>
  </html>  