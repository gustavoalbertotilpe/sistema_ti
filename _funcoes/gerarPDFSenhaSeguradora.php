<?php
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');
    if(isset($_GET["categoria"]) && empty($_GET["categoria"]) == false)
    {
        $categoria = $_GET["categoria"];
    }
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/Y  H:i:s");
$ano = date("Y");
$html.="
<!DOCTYPE html>
<html lang='pt-BR'>
    <head>
        <meta charset='utf-8'>
        <title>Senhas</title>
        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                background-image:url('../_img/padroes/fundo.jpg');
                background-size:cover;
                }
            table{
                border: solid 1px #000;
            }
            td{
                border: solid 1px #000;
            }
            .resumo{
                width:100%;
                border: solid 1px #000;
            }
            .esquerda{
                float:left;
                width:48%;     
            }
            .direita{
                float:right;
                width:48%;
            }
            .footer{
                width:100%;
                height: 100px;
                background-color:#03a5fc;
                color:#fff;
                margin-top:30px;
            }
            .footer h3{
                text-align:center;
                padding-top:20px;
            }
        </style>
    </head>
    <body>
    <div style='background-color:#03a5fc;height:40px; color:#fff;margin:0;padding-top:11px;padding-left:30px'>
         <h1 style='width:200px;margin-left:35%'>SENHAS</h1>
    </div>
    <h4>Data: ".$data."</h4> 
    <div >  
    <table style='background-color:#fff; width:100%;'>
    <tr>
    <td><h3>NOME</h3></td>
    <td><h3>URL</h3></td>
    <td><h3>LOGIN</h3></td>
    <td><h3>SENHA</h3></td>
    <td><h3>TIPO ACESSO</h3></td>
    <td><h3>OBS</h3></td>
    <td><h3>CATEGORIA</h3></td>
    </tr>
";
$sql = $pdo->prepare("SELECT ID_SENHAS,SEGURADORA,URL,LOGIN,SENHA,TIPO,OBS,CATEGORIA FROM SENHAS_SEGURADORAS WHERE CATEGORIA = '$categoria' order by ID_SENHAS ASC");                               
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["SEGURADORA"]."</td>
    <td>".$row["URL"]."</td>
    <td>".$row["LOGIN"]."</td>
    <td>".$row["SENHA"]."</td>
    <td>".$row["TIPO"]."</td>
    <td>".$row["OBS"]."</td>
    <td>".$row["CATEGORIA"]."</td>
    </tr>     
    ";
}
$html.="
        </table>
    </div>    
            <div class='footer'>
                <h3>&copy; SGTI ".$ano."</h3>
            </div>    
        ";

    $mpdf=new mPDF(); 
    $mpdf->AddPage('L');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);  
    $mpdf->Output();
?>
 