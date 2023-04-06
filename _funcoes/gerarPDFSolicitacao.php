<?php
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');
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
        <title>Contatos</title>
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
         <h1 style='width:200px;margin-left:35%'>SOLICITAÇÃO</h1>
    </div>
    <h4>Data: ".$data."</h4> 
    <div >  
    <table style='background-color:#fff; width:100%;'>
    <tr>
    <td><h3>STATUS</h3></td>
    <td><h3>NOME SOLICITANTE</h3></td>
    <td><h3>NOME COMPRADOR</h3></td>
    <td><h3>E-MAIL COMPRADOR</h3></td>
    <td><h3>SOLICITACAO</h3></td>
    <td><h3>DATA ABERTURA</h3></td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDSOLICITACAO,NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO,DATAABERTURA,SOLICITACAOFECHADA FROM SOLICITACAO order by IDSOLICITACAO ASC");                         
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["SOLICITACAOFECHADA"]."</td>
    <td>".$row["NOME"]."</td>
    <td>".$row["NOMEDESTINO"]."</td>
    <td>".$row["EMAILDESTINO"]."</td>
    <td>".$row["SOLICITACAO"]."</td>
    <td>".$row["DATAABERTURA"]."</td>
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
 