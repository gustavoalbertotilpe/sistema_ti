<?php 
 session_start();
 if(empty($_SESSION["NOME"])){
     header("location:../");
 }
    include('funcoes.php');
    $deskAtivoQuantidade = QuantidadeDeskAtivo2();
    $deskQuantidade = QuantidadeDesk2();
    $deskParado = QuantidadeDeskParado2();
    $deskEstragodo = QuantidadeDeskEstragado2();
    date_default_timezone_set('America/Sao_Paulo');
    $data = date("d/m/Y  H:i:s");
?>
<?php    
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
        $sql = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR order by NUMERO_ATIVO ASC");        
        $sql->execute();
        $arquivo="Relatorio.xls";
        $html ="<table border=2>
            <tr>
                <td colspan=20 rowspan=2><h1>RELATORIO - ATIVOS COMPUTADOR</h1></td>
            </tr>
            <tr>
                <td></td>
            </tr>    
            <tr>
                 <td>Total de Computadores: </td>
                 <td>".$deskQuantidade." </td>
            </tr>
            <tr>     
                <td>Total de Computadores Em Uso: </td> 
                <td>".$deskAtivoQuantidade."</td>
            </tr>
            <tr>    
                <td>Total de Computadores Aguardando Uso: </td>
                <td> ".$deskParado." </td>
            </tr>
            <tr>        
                <td>Total de Computadores Estragado: </td>
                <td>".$deskEstragodo." </td>
            </tr>    
            <tr>   
                <td>".$quantidadePCLicencaAtiva."</td>
                <td>".$quantidadePCSemLicenca."</td>
            </tr>
            <tr>       
               <td>Data: ".$data."</td>   
            </tr>
            <tr>
                <td><h2>NUMERO INVENTARIO</h2></td>
                <td><h2>TIPO</h2></td>
                <td><h2>PROCESSADOR</h2></td>
                <td><h2>MEMORIA RAM</h2></td>
                <td><h2>MODELO</h2></td>
                <td><h2>MARCA</h2></td>
                <td><h2>SISTEMA OPERACIONAL</h2></td>
                <td><h2>LICENÇA WINDOWS</h2></td>
                <td><h2>DOMINIO</h2></td>
                <td><h2>USUARIO</h2></td>
                <td><h2>NOME DO PC</h2></td>
                <td><h2>CIDADE</h2></td>
                <td><h2>RESPONSAVEL</h2></td>
                <td><h2>SITUAÇÃO</h2></td>
                <td><h2>DATA DA COMPRA</h2></td>
                <td><h2>OBSERVAÇÃO</h2></td>
            </tr>
        ";
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