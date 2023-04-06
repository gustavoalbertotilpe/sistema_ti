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
                background-color:#000;
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
    <h1>Chamado</h1>
   
    <h4>Data: ".$data."</h4>   
    <table>
    <tr>
    <td><h3>STATUS</h3></td>
    <td><h3>NUMERO CHAMADO</h3></td>
    <td><h3>DATA ABERTURA</h3></td>
    <td><h3>TITULO</h3></td>
    <td><h3>SOLICITANTE</h3></td>
    <td><h3>SOLICITAÇÃO</h3></td>
    <td><h3>PRIORIDADE</h3></td>
    <td><h3>RESOLUÇÃO</h3></td>
    <td><h3>OBS</h3></td>
    <td><h3>DATA FECHAMENTO</h3></td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA,SOLICITANTE,PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO order by IDCHAMADO ASC ");                             
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["STATUS"]."</td>
    <td>".$row["IDCHAMADO"]."</td>
    <td>".$row["DATA_ABERTURA"]."</td>
    <td>".$row["TITULO"]."</td>  
    <td>".$row["SOLICITANTE"]."</td>
    <td>".$row["PROBLEMA"]."</td>
    <td>".$row["PRIORIDADE"]."</td>  
    <td>".$row["SOLUCAO"]."</td>
    <td>".$row["OBS"]."</td>  
    <td>".$row["DATA_FECHAMENTO"]."</td>
    </tr>     
    ";
}
$html.="
        </table>
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
 