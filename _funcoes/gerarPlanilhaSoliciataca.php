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
    
       $sql = $pdo->prepare("SELECT IDSOLICITACAO,NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO,DATAABERTURA,SOLICITACAOFECHADA FROM SOLICITACAO order by IDSOLICITACAO ASC");        
       $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=7 rowspan=2><h1>SOLICITAÇÃO</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
            <tr>
                <td><h3>STATUS</h3></td>
                <td><h3>SOLICITANTE</h3></td>
                <td><h3>COMPRADOR</h3></td>
                <td><h3>E-MAIL DO COMPRADOR</h3></td>
                <td><h3>SOLICITAÇÃO</h3></td>
                <td><h3>DATA DA SOLICITAÇÃO</h3></td>
            </tr>
        ";
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            if($row["SOLICITACAOFECHADA"] == 1)
            {
                $style="style='background-color:green;'";
            }
            else
            {
                $style="style='background-color:red;'";

            }
            $html.="
            <tr>
                <td $style></td>
                <td>".$row["NOME"]."</td>
                <td>".$row["NOMEDESTINO"]."</td>
                <td>".$row["EMAILDESTINO"]."</td>
                <td>".$row["SOLICITACAO"]."</td>  
                <td>".$row["DATAABERTURA"]."</td> 
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