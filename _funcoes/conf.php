<?php
    session_start();
    if(empty($_SESSION["NOME"])){
        header("location:../");
    }
    include('funcoes.php');
    $nome=$_SESSION["NOME"];
    $IDUSUARIO = $_SESSION["IDUSUARIO"];

    if(isset($_GET["url"])){
      $url = $_GET["url"];
      $url.=".php";
  }else{
      $url = "default.php";
  }
?>
 
