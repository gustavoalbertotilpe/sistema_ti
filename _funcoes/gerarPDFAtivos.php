<?php
  session_start();
  if(empty($_SESSION["NOME"])){
      header("location:../");
  }
    include("../_bibliotecas/mpdf/mpdf.php");
    include('banco.php');   
  
?>
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/Y  H:i:s");
$ano = date("Y");
$sql = $pdo->prepare("SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO  FROM COMPUTADOR  UNION SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM MONITOR order by RESPONSAVEL ASC ");
$sql->execute();
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
    <h1>RELATORIO - ATIVOS</h1>
    <h4>Data: ".$data."</h4>   
    <table border=2>
    <tr>
        <td><h2>Situação</h2></td>
        <td><h2>Numero Inventario</h2></td>
        <td><h2>Responsavel</h2></td>
        <td><h2>Tipo</h2></td>
        <td><h2>Filial</h2></td>
    </tr>
";
$sql = $pdo->prepare("SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM COMPUTADOR UNION SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM MONITOR order by RESPONSAVEL");        
$sql->execute();

while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $html.="
    <tr>
        <td>".$row["SITUACAO"]."</td>
        <td>".$row["NUMERO_ATIVO"]."</td>
        <td>".$row["RESPONSAVEL"]."</td>
        <td>".$row["TIPO"]."</td>
        <td>".$row["CIDADE"]."</td>   
    </tr>     
    ";
}
$html.="
</table>
";
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
 