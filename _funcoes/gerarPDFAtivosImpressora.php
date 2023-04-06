<?php
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');
    include('funcoes.php');
    $impressoraQuantidade = QuantidadeImpressora();
    $impressoraQuantidadeAtivo = QuantidadeImpressoraAtivo();
    $impressoraQuantidadeParado = QuantidadeImpressoraParado();
    $impressoraQuantidadeEstragado = QuantidadeImpressoraEstragado();
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
    <div class='resumo'>
        <div class='esquerda'>
            <h3>Total de Impressora: ".$impressoraQuantidade." </h3>
            <h3>Total de Impressora Em Uso: ".$impressoraQuantidadeAtivo."</h3>
            <h3>Total de Impressora Aguardando Uso: ".$impressoraQuantidadeParado." </h3>
            <h3>Total de Impressora Estragado: ".$impressoraQuantidadeEstragado." </h3>
        </div>
    </div> 
    <h4>Data: ".$data."</h4>   
    <table>
    <tr>
        <td><h4>NUMERO INVENTARIO</h4></td>
        <td><h4>MODELO</h4></td>
        <td><h4>MARCA</h4></td>
        <td><h4>TONER</h4></td>
        <td><h4>CIDADE</h4></td>
        <td><h4>SITUAÇÃO</h4></td>
        <td><h4>DATA DA COMPRA</h4></td>
        <td><h4>OBSERVAÇÃO</h4></td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDIMPRESSORA,NUMERO_ATIVO,CIDADE,MODELO,MARCA,TONER,SITUACAO,OBS,DATA_COMPRA FROM IMPRESSORA order by NUMERO_ATIVO ASC");               
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["NUMERO_ATIVO"]."</td>
    <td>".$row["MODELO"]."</td>
    <td>".$row["MARCA"]."</td>
    <td>".$row["TONER"]."</td>  
    <td>".$row["CIDADE"]."</td>
    <td>".$row["SITUACAO"]."</li>
    <td>".$row["DATA_COMPRA"]."</td>
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
 