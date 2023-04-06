<?php 
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include('funcoes.php');
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d/m/Y  H:i:s");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatorio XLS</title>
</head>
<body>
    <?php 
       $sql = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA,SOLICITANTE,PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO order by IDCHAMADO ASC ");        
       $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=4 rowspan=2><h1>CHAMADO</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
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
        ";
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");

        echo $html;
        exit;
    ?>
</body>
</html>