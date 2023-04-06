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
        <title>ATIVOS COMPUTADOR</title>
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
    <h1>RELATORIO - ATIVOS IMPRESSORA</h1>
   
    <h4>Data: ".$data."</h4>   
    <table>
    <tr>
    <td><h3>Nª.M</h3></td>
    <td><h3>Nª.A</h3></td>
    <td><h3>DATA.M</h3></td>
    <td><h3>TIPO.M</h3></td>
    <td><h3>DESCRICAO_DEFEITO</h3></td>
    <td><h3>PROCEDIMENTO</h3></td>
    <td><h3>OBS</h3></td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRICAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO order by IDMANUTENCAO ASC");               
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["IDMANUTENCAO"]."</td>
    <td>".$row["NUMERO_ATIVO"]."</td>
    <td>".$row["DATA_MANUTENCAO"]."</td>
    <td>".$row["TIPO_MANUTENCAO"]."</td>  
    <td>".$row["DESCRICAO_DEFEITO"]."</td>
    <td>".$row["PROCEDIMENTO"]."</li>
    <td>".$row["OBS"]."</td>
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
 