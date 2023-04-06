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
       $sql = $pdo->prepare("SELECT IDRAMAIS,NOME,TELEFONE,EMAIL,RAMAL,CIDADE,ESTADO FROM RAMAIS order by IDRAMAIS ASC");        
       $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=4 rowspan=2><h1>RAMAIS</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
            <tr>
                <td><h3>NOME</h3></td>
                <td><h3>TELEFONE</h3></td>
                <td><h3>RAMAL</h3></td>
                <td><h3>E-MAIL</h3></td>
                <td><h3>CIDADE</h3></td>
                <td><h3>ESTADO</h3></td>
            </tr>
        ";
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $html.="
            <tr>
                <td>".$row["NOME"]."</td>
                <td>".$row["TELEFONE"]."</td>
                <td>".$row["RAMAL"]."</td>
                <td>".$row["EMAIL"]."</td>  
                <td>".$row["CIDADE"]."</td> 
                <td>".$row["ESTADO"]."</td> 
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