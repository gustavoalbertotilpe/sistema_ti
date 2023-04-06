<?php 
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include('funcoes.php');
    $monitorAtivoQuantidade = QuantidadeMonitor();
    $monitorQuantidade = QuantidadeMonitorAtivo();
    $monitorParado = QuantidadeMonitorParado();
    $monitorEstragodo = QuantidadeMonitorEstradago();
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
       $sql = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,POLEGADA,SITUACAO,RESPONSAVEL,OBS,DATA_COMPRA FROM MONITOR order by NUMERO_ATIVO ASC");        
       $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=8 rowspan=2><h1>RELATORIO - ATIVOS MONITOR</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>
                 <td><h2>Total de Monitores:</h2> </td>
                 <td>".$monitorAtivoQuantidade." </td>
            </tr>
            <tr>     
                <td><h2>Total de Monitores Em Uso:</h2>  </td> 
                <td>".$monitorQuantidade."</td>
            </tr>
            <tr>    
                <td><h2>Total de Monitores Aguardando Uso:</h2>  </td>
                <td> ".$monitorParado." </td>
            </tr>
            <tr>        
                <td><h2>Total de Monitores Estragado: </h2> </td>
                <td>".$monitorEstragodo." </td>
            </tr>    
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
            <tr>
                <td><h3>NUMERO INVENTARIO</h3></td>
                <td><h3>MODELO</h3></td>
                <td><h3>MARCA</h3></td>
                <td><h3>POLEGADA</h3></td>
                <td><h3>CIDADE</h3></td>
                <td><h3>RESPONSAVEL</h3></td>
                <td><h3>SITUAÇÃO</h3></td>
                <td><h3>DATA DA COMPRA</h3></td>
                <td><h3>OBSERVAÇÃO</h3></td>
            </tr>
        ";
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