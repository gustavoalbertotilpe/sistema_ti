<?php
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');
    include('funcoes.php');
    $deskAtivoQuantidade = QuantidadeDeskAtivo2();
    $deskQuantidade = QuantidadeDesk2();
    $deskParado = QuantidadeDeskParado2();
    $deskEstragodo = QuantidadeDeskEstragado2();
    
    $sql = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidadeLicenca = $consulta["QTD"];
       $quantidadePCLicencaAtiva ="
       <h3>Computadores com licença Windows Ativa: ".$quantidadeLicenca."</h3>
       ";

       $sqlPCSemLicenca = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS =''");
       $sqlPCSemLicenca->execute();
       $consultaPCSemLicenca = $sqlPCSemLicenca->fetch(PDO::FETCH_ASSOC);
       $quantidadePCSemLicenca = $consultaPCSemLicenca["QTD"];
       
       $quantidadePCSemLicenca ="
       <h3>Computadores sem  licença Windows: ".$quantidadePCSemLicenca."</h3>
       ";
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
    <h1>RELATORIO - ATIVOS COMPUTADOR</h1>
    <div class='resumo'>
        <div class='esquerda'>
            <h3>Total de Computadores: ".$deskQuantidade." </h3>
            <h3>Total de Computadores Em Uso: ".$deskAtivoQuantidade."</h3>
            <h3>Total de Computadores Aguardando Uso: ".$deskParado." </h3>
            <h3>Total de Computadores Estragado: ".$deskEstragodo." </h3>
        </div>
        <div class='direita'>    
            ".$quantidadePCLicencaAtiva."
            ".$quantidadePCSemLicenca."
        </div>    
    </div> 
    <h4>Data: ".$data."</h4>   
    <table>
    <tr>
        <td>NUMERO INVENTARIO</td>
        <td>TIPO</td>
        <td>PROCESSADOR</td>
        <td>MEMORIA RAM</td>
        <td>MODELO</td>
        <td>MARCA</td>
        <td>SISTEMA OPERACIONAL</td>
        <td>LICENÇA WINDOWS</td>
        <td>DOMINIO</td>
        <td>USUARIO</td>
        <td>NOME DO PC</td>
        <td>CIDADE</td>
        <td>RESPONSAVEL</td>
        <td>SITUAÇÃO</td>
        <td>DATA DA COMPRA</td>
        <td>OBSERVAÇÃO</td>
    </tr>
";
$sql = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR order by NUMERO_ATIVO ASC");        
$sql->execute();
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
    <td>".$row["NUMERO_ATIVO"]."</td>
    <td>".$row["TIPO"]."</td>
    <td>".$row["PROCESSADOR"]."</td>
    <td>".$row["MEMORIA_RAM"]."</td>
    <td>".$row["MODELO"]."</td>
    <td>".$row["MARCA"]."</td>
    <td>".$row["SISTEMA_OPERACIONAL"]."</td>
    <td>".$row["LICENCA_WINDOWS"]."</td>
    <td>".$row["DOMINIO"]."</td>
    <td>".$row["USUARIO"]."</td>
    <td>".$row["NOME_PC"]."</td>
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
 