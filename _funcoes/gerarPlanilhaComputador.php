<?php 
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    require("banco.php");   
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php 
        $sql = $pdo->prepare("SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM COMPUTADOR UNION SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM MONITOR order by RESPONSAVEL");
        $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td><h2>Situação</h2></td>
                <td><h2>Numero Inventario</h2></td>
                <td><h2>Responsavel</h2></td>
                <td><h2>Tipo</h2></td>
                <td><h2>Filial</h2></td>
            </tr>
        ";
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