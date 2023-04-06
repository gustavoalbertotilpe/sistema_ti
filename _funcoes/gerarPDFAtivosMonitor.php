<?php
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');
    include('funcoes.php');
    $monitorAtivoQuantidade = QuantidadeMonitor();
    $monitorQuantidade = QuantidadeMonitorAtivo();
    $monitorParado = QuantidadeMonitorParado();
    $monitorEstragodo = QuantidadeMonitorEstradago();
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
    <h1>RELATORIO - ATIVOS MONITOR</h1>
    <div class='resumo'>
        <div class='esquerda'>
            <h3>Total de Monitores: ".$monitorAtivoQuantidade." </h3>
            <h3>Total de Monitores Em Uso: ".$monitorQuantidade."</h3>
            <h3>Total de Monitores Aguardando Uso: ".$monitorParado." </h3>
            <h3>Total de Monitores Estragado: ".$monitorEstragodo." </h3>
        </div>
    </div> 
    <h4>Data: ".$data."</h4>   
    <table>
    <tr>
        <td><h4>NUMERO INVENTARIO</h4></td>
        <td><h4>MODELO</h4></td>
        <td><h4>MARCA</h4></td>
        <td><h4>POLEGADA</h4></td>
        <td><h4>CIDADE</h4></td>
        <td><h4>RESPONSAVEL</h4></td>
        <td><h4>SITUAÇÃO</h4></td>
        <td><h4>DATA DA COMPRA</h4></td>
        <td><h4>OBSERVAÇÃO</h4></td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,POLEGADA,SITUACAO,RESPONSAVEL,OBS,DATA_COMPRA FROM MONITOR order by NUMERO_ATIVO ASC");        
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["NUMERO_ATIVO"]."</td>
    <td>".$row["MODELO"]."</td>
    <td>".$row["MARCA"]."</td>
    <td>".$row["POLEGADA"]."</td>  
    <td>".$row["CIDADE"]."</td>
    <td>".$row["RESPONSAVEL"]."</td>
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
 