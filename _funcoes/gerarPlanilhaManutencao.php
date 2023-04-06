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
       $sql = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRICAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO order by IDMANUTENCAO ASC");        
       $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=8 rowspan=2><h1>RELATORIO - Manutenção</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
            <tr>
                <td><h3>NUMERO MANUTENÇÃO</h3></td>
                <td><h3>NUMERO_ATIVO</h3></td>
                <td><h3>DATA_MANUTENCAO</h3></td>
                <td><h3>TIPO_MANUTENCAO</h3></td>
                <td><h3>DESCRICAO_DEFEITO</h3></td>
                <td><h3>PROCEDIMENTO</h3></td>
                <td><h3>OBS</h3></td>
            </tr>
        ";
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