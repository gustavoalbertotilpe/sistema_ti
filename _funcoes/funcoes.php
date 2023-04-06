<?php
    require("banco.php");   
    date_default_timezone_set('America/Sao_Paulo');
    $horaLocal =date('H:i:s');

    function saudacao(){
        global $horaLocal;
        if($horaLocal <= "13:00:00"){
            $saudacao = "Bom Dia ";
        }else if($horaLocal >= "13:00:00"){
            $saudacao = "Boa Tarde ";
        }else if($horaLocal >= "19:00"){
            $saudacao="Boa Noite ";
        }
        return $saudacao;
    }
    function tableaAtivos($responsavel){
        global $pdo;
        $nome=$responsavel;
        if($responsavel !='default'){
           $sql = $pdo->prepare("SELECT NUMERO_ATIVO, RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM COMPUTADOR WHERE RESPONSAVEL LIKE  '%{$nome}%'  UNION SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM MONITOR WHERE RESPONSAVEL LIKE  '%{$nome}%'  ");
           $sql->execute();
               if(!$sql->rowCount()){
                   echo"
                   <h1>Não existe resultado para  \"".$responsavel."\"</h1>";
               }else{   
                   echo"<table class='table table-dark table-hover'>
                       <thead>
                        <tr>
                            <th>Status</th>
                            <th>Numero Iventario</th>
                            <th>Responsavel</th>
                            <th>Tipo</th>
                            <th>Filial</th>
                        </tr>
                        </thead>
                        <tbody>
                   ";
                   while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                       if($row["SITUACAO"] == "AGUARDANDO USO"){
                           $STATUS = "<div class='statusParado'></div>";
                       }else if($row["SITUACAO"] == "EM USO"){
                           $STATUS = "<div class='statusAtivo'>";
                       }else{
                           $STATUS = "<div class='statusEstragado'></div>";
                       }
                       echo"
                       <tr>
                           <td>".$STATUS."</td>
                           <td>".$row["NUMERO_ATIVO"]."</td>
                           <td>".$row["RESPONSAVEL"]."</td>
                           <td>".$row["TIPO"]."</td>
                           <td>".$row["CIDADE"]."</td>   
                       </tr>     
                       ";
                   }
                   echo"
                   </tbody>
                   </table>
                   ";
               } 

        }else{
            
           $quantidade = 20;
           $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
           $inicio = ($quantidade * $pagina) - $quantidade;

                   $sql = $pdo->prepare("SELECT NUMERO_ATIVO FROM COMPUTADOR UNION SELECT NUMERO_ATIVO FROM MONITOR");
                   $sql->execute();
                   $numTotal = $sql->rowCount();
                   $totalPagina= ceil($numTotal/$quantidade);
           
                   $exibir = 15;
           
                   $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
           
                   $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                   echo "<ul class='pagination'>";
                   
                   echo '<li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li> ';

                   echo '<li class="page-item"><a class="page-link"  href="?pagina='.$anterior.'">Anterior</a></li> ';

                   for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                       if($i > 0)
                       echo'<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
                       }
                       echo'<li class="page-item"><a class="page-link" href="?pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
               
               for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                       if($i <= $totalPagina)
                       echo'<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
               }
               echo '<li class="page-item"><a class="page-link"  href="?pagina='.$posterior.'">Próxima</a></li> ';
               echo '<li class="page-item"><a class="page-link"  href="?pagina='.$totalPagina.'">Última</a></li> ';
               echo "</ul>";   
  
           $sql = $pdo->prepare("SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM COMPUTADOR UNION SELECT NUMERO_ATIVO,RESPONSAVEL,CIDADE,SITUACAO,TIPO FROM MONITOR order by RESPONSAVEL ASC LIMIT $inicio , $quantidade");
           $sql->execute();
           
           echo"<table class='table table-dark table-hover'>
            <thead>
             <tr>
                <th>Status</th>
                <th>Numero Iventario</th>
                <th>Responsavel</th>
                <th>Tipo</th>
                <th>Filial</th>
             </tr>
             </thead>
             <tbody>
           ";
           while($row = $sql->fetch(PDO::FETCH_ASSOC)){
               if($row["SITUACAO"] == "AGUARDANDO USO"){
                   $STATUS = "<div class='statusParado'></div>";
               }else if($row["SITUACAO"] == "EM USO"){
                   $STATUS = "<div class='statusAtivo'></div>";
               }else{
                   $STATUS = "<div class='statusEstragado'>";
               }
               echo"
               <tr>
                   <td>".$STATUS."</td>
                   <td>".$row["NUMERO_ATIVO"]."</td>
                   <td>".$row["RESPONSAVEL"]."</td>
                   <td>".$row["TIPO"]."</td>
                   <td>".$row["CIDADE"]."</td>   
               </tr>     
               ";
           }
           echo"
           </tbody>
           </table>
           ";

           $sql = $pdo->prepare("SELECT NUMERO_ATIVO FROM COMPUTADOR UNION SELECT NUMERO_ATIVO FROM MONITOR");
           $sql->execute();
           $numTotal = $sql->rowCount();
           $totalPagina= ceil($numTotal/$quantidade);
   
           $exibir = 15;
   
           $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
   
           $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
           echo "<ul class='pagination'>";
           
           echo '<li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li> ';

           echo '<li class="page-item"><a class="page-link"  href="?pagina='.$anterior.'">Anterior</a></li> ';

           for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
               if($i > 0)
               echo'<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
               }
               echo'<li class="page-item"><a class="page-link" href="?pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
       
       for($i = $pagina+1; $i < $pagina+$exibir; $i++){
               if($i <= $totalPagina)
               echo'<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
       }
       echo '<li class="page-item"><a class="page-link"  href="?pagina='.$posterior.'">Próxima</a></li> ';
       echo '<li class="page-item"><a class="page-link"  href="?pagina='.$totalPagina.'">Última</a></li> ';
       echo "</ul>";
    }  
   }

   
   function QuantidadeDesk(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeDeskAtivo(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='EM USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeDeskParado(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='AGUARDANDO USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }    
   function QuantidadeDeskEstragado(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='ESTRAGADO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }  
   function QuantidadeMonitor(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR ");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }    
   function QuantidadeMonitorAtivo(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO ='EM USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeMonitorParado(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO ='AGUARDANDO USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeMonitorEstradago(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO ='ESTRAGADO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeImpressora(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeImpressoraAtivo(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA WHERE SITUACAO = 'EM USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeImpressoraParado(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA WHERE SITUACAO = 'AGUARDANDO USO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function QuantidadeImpressoraEstragado(){
       global $pdo;
       $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA WHERE SITUACAO = 'ESTRAGADO'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidade = $consulta["QTD"];
       return $quantidade;
   }
   function exibirFilial(){
           $city= "
               <form action ='' method='GET'>
                   <select name='cidade' id='cidadeID' class='form-control'>
                           <option value='BALNEARIO CAMBURI-SC'>BALNEARIO CAMBURI-SC</option>
                           <option value='BLUMENAU-SC'>BLUMENAU-SC</option>
                           <option value='BRUSQUE-SC'>BRUSQUE-SC</option>
                           <option value='CASTRO-PR'>CASTRO-PR</option>
                           <option value='CARAMBEÍ-PR'>CARAMBEÍ-PR</option>
                           <option value='CURITIBA-PR'>CURITIBA-PR</option>
                           <option value='CURITIBANO-SC'>CURITIBANO-SC</option>
                           <option value='IRATI-PR'>IRATI-PR</option>
                           <option value='IBAITI-PR'>IBAITI-PR</option>
                           <option value='ORTIGUEIRA-PR'>ORTIGUEIRA-PR</option>
                           <option value='OURINHOS-SP'>OURINHOS-SP</option>
                           <option value='GURAPUAVA-PR'>GUARAPUAVA-PR</option>
                           <option value='LONDRINA-PR'>LONDRINA-PR</option>
                           <option value='MARINGA-PR'>MARINGA-PR</option>
                           <option value='SÃO JOSÉ DOS PINHAIS-PR'>SÃO JOSÉ DOS PINHAIS-PR</option>
                           <option value='PONTA-GROSSA-PR'>PONTA-GROSSA-PR</option>
                           <option value='FILIAL NOVA ANDRADINA-MG'>FILIAL NOVA ANDRADINA-MG</option>
                           <option value='CASCAVEL-PR'>CASCAVEL-PR</option>
                           <option value='GOIAS-MT'>GOIAS-MT</option>
			   <option value='CUIABA-MT'>CUIABA-MT</option>
                       </select>
                       <br>
                       <input type='submit' value='Buscar' class='btn btn-info'> 
                       <br>   
               </form>        
                       ";
            return $city;       
   }
   function QuantidadeAtivoFilial($city){
       global $pdo;
       $filial = $city;
       $sqlDeskAtivo = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO = 'EM USO' && CIDADE = ?");
       $sqlDeskAtivo->execute(array($filial));
       $consultaDeskAtivo = $sqlDeskAtivo->fetch(PDO::FETCH_ASSOC);
       $quantidadeDeskAtivo = $consultaDeskAtivo["QTD"];
       
       $sqlDeskParado = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO = 'AGUARDANDO USO' && CIDADE = ?");
       $sqlDeskParado->execute(array($filial));
       $consultaDeskParado = $sqlDeskParado->fetch(PDO::FETCH_ASSOC);
       $quantidadeDeskParado = $consultaDeskParado["QTD"];

       $sqlMonitorAtivo = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO = 'EM USO' && CIDADE = ?");
       $sqlMonitorAtivo->execute(array($filial));
       $consultaMonitorAtivo = $sqlMonitorAtivo->fetch(PDO::FETCH_ASSOC);
       $quantidadeMonitorAtivo = $consultaMonitorAtivo["QTD"];

       $sqlMonitorParado = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO = 'AGUARDANDO USO' && CIDADE = ?");
       $sqlMonitorParado->execute(array($filial));
       $consultaMonitorParado = $sqlMonitorParado->fetch(PDO::FETCH_ASSOC);
       $quantidadeMonitorParado = $consultaMonitorParado["QTD"];

       $sqlMonitorParado = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM MONITOR WHERE SITUACAO = 'AGUARDANDO USO' && CIDADE = ?");
       $sqlMonitorParado->execute(array($filial));
       $consultaMonitorParado = $sqlMonitorParado->fetch(PDO::FETCH_ASSOC);
       $quantidadeMonitorParado = $consultaMonitorParado["QTD"];

       $sqlImpressoraAtivo = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA WHERE SITUACAO = 'EM USO' && CIDADE = ?");
       $sqlImpressoraAtivo->execute(array($filial));
       $consultaImpressoraAtivo = $sqlImpressoraAtivo->fetch(PDO::FETCH_ASSOC);
       $quantidadeImpressoraAtivo = $consultaImpressoraAtivo["QTD"];

       $sqlImpressoraParado = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM IMPRESSORA WHERE SITUACAO = 'AGUARDANDO USO' && CIDADE = ?");
       $sqlImpressoraParado->execute(array($filial));
       $consultaImpressoraParado = $sqlImpressoraParado->fetch(PDO::FETCH_ASSOC);
       $quantidadeImpressoraParado = $consultaImpressoraParado["QTD"];

       if($quantidadeDeskAtivo == 0){
           $deskAtivo="";
       }else{
           $deskAtivo ="<h3 class='green'>Total de Computadores Ativo: ".$quantidadeDeskAtivo."</h3>";
       }
       if($quantidadeDeskParado == 0){
           $deskParado='';
       }else{
           $deskParado =  "<h3 class='yellow'>Total de Computadores Parado: ".$quantidadeDeskParado."</h3>";
       }

       if($quantidadeMonitorAtivo == 0){
           $monitorAtivo="";
       }else{
           $monitorAtivo ="<h3 class='green'>Total de Monitores Ativo: ".$quantidadeMonitorAtivo."</h3>";
       }
       if($quantidadeMonitorParado == 0){
           $monitorParado='';
       }else{
           $monitorParado =  "<h3 class='yellow'>Total de Monitores Parado: ".$quantidadeMonitorParado."</h3>";
       }


       if($quantidadeImpressoraAtivo == 0){
           $impressoraQuantidadeAtiva='';
       }else{
           $impressoraQuantidadeAtiva =  "<h3 class='green'>Total de Impressoras Ativo: ".$quantidadeImpressoraAtivo."</h3>";
       }
       if($quantidadeImpressoraParado == 0){
           $impressoraQuantidadeParada=" ";
       }else{
           $impressoraQuantidadeParada =  " <h3 class='yellow'>Total de Impressoras Parado: ".$quantidadeImpressoraParado."</h3>";
       }

       echo"   
       <h2>".$filial."</h2>
       ".$deskAtivo."
       ".$deskParado."
       ".$monitorAtivo."        
       ".$monitorParado."
       ".$impressoraQuantidadeAtiva."
       ".$impressoraQuantidadeParada
       ; 
   }
   function quantidadeLicencaWin(){
       global $pdo;
  
       $sql = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM' || LICENCA_WINDOWS = '3W2VF-B3VKQ-7VDPF-GYJ69-KVMRK'");
       $sql->execute();
       $consulta = $sql->fetch(PDO::FETCH_ASSOC);
       $quantidadeLicenca = $consulta["QTD"];
       $quantidadePCLicencaAtiva ="
       <h3 class='green'>Computadores com licença Windows Ativa: ".$quantidadeLicenca."</h3>
       ";

       $sqlPCSemLicenca = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS =''");
       $sqlPCSemLicenca->execute();
       $consultaPCSemLicenca = $sqlPCSemLicenca->fetch(PDO::FETCH_ASSOC);
       $quantidadePCSemLicenca = $consultaPCSemLicenca["QTD"];
       
       $quantidadePCSemLicenca ="
       <h3 class='red'>Computadores sem  licença Windows: ".$quantidadePCSemLicenca."</h3>
       ";

       echo $quantidadePCLicencaAtiva." ".$quantidadePCSemLicenca;
   }

   
  
   function exibirFilialAtivos(){
    $city= "
            <select name='cidade' id='cidadeID' class='form-control'>
                    <option value='default' selected>Todas Filiais</option>
                    <option value='BALNEARIO CAMBURI-SC'>BALNEARIO CAMBURI-SC</option>
                    <option value='BLUMENAU-SC'>BLUMENAU-SC</option>
                    <option value='BRUSQUE-SC'>BRUSQUE-SC</option>
                    <option value='CASTRO-PR'>CASTRO-PR</option>
                    <option value='CARAMBEÍ-PR'>CARAMBEÍ-PR</option>
                    <option value='CURITIBA-PR'>CURITIBA-PR</option>
                    <option value='CURITIBANO-SC'>CURITIBANO-SC</option>
                    <option value='IRATI-PR'>IRATI-PR</option>
                    <option value='IBAITI-PR'>IBAITI-PR</option>
                    <option value='ORTIGUEIRA-PR'>ORTIGUEIRA-PR</option>
                    <option value='OURINHOS-SP'>OURINHOS-SP</option>
                    <option value='GURAPUAVA-PR'>GUARAPUAVA-PR</option>
                    <option value='LONDRINA-PR'>LONDRINA-PR</option>
                    <option value='MARINGA-PR'>MARINGA-PR</option>
                    <option value='SÃO JOSÉ DOS PINHAIS-PR'>SÃO JOSÉ DOS PINHAIS-PR</option>
                    <option value='PONTA-GROSSA-PR'>PONTA-GROSSA-PR</option>
                    <option value='FILIAL NOVA ANDRADINA-MG'>FILIAL NOVA ANDRADINA-MG</option>
                    <option value='CASCAVEL-PR'>CASCAVEL-PR</option>
                    <option value='GOIAS-MT'>GOIAS-MT</option>
 		    <option value='CUIABA-MT'>CUIABA-MT</option>
                </select>
     
                ";
     return $city;       
}
function QuantidadeDesk2(){
    global $pdo;
    $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR");
    $sql->execute();
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;
}
function QuantidadeDeskAtivo2(){
    global $pdo;
    $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='EM USO'");
    $sql->execute();
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;
}
function QuantidadeDeskParado2(){
    global $pdo;
    $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='AGUARDANDO USO'");
    $sql->execute();
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;
}    
function QuantidadeDeskEstragado2(){
    global $pdo;
    $sql = $pdo->prepare("SELECT COUNT(NUMERO_ATIVO) as QTD FROM COMPUTADOR WHERE SITUACAO ='ESTRAGADO'");
    $sql->execute();
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;
}  
function quantidadeLicencaWin2(){
    global $pdo;

    $sql = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'");
    $sql->execute();
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidadeLicenca = $consulta["QTD"];
    $quantidadePCLicencaAtiva ="
    <h3 class='green'>Computadores com licença Windows Ativa: ".$quantidadeLicenca."</h3>
    ";

    $sqlPCSemLicenca = $pdo->prepare("SELECT COUNT('NUMERO_ATIVO') as QTD FROM COMPUTADOR WHERE LICENCA_WINDOWS =''");
    $sqlPCSemLicenca->execute();
    $consultaPCSemLicenca = $sqlPCSemLicenca->fetch(PDO::FETCH_ASSOC);
    $quantidadePCSemLicenca = $consultaPCSemLicenca["QTD"];
    
    $quantidadePCSemLicenca ="
    <h3 class='red'>Computadores sem  licença Windows: ".$quantidadePCSemLicenca."</h3>
    ";

    echo $quantidadePCLicencaAtiva." ".$quantidadePCSemLicenca;
}

function AtivosComputador($responsavel,$filial,$status,$licencaWin){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDCOMPUTADOR FROM COMPUTADOR ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=computador&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($responsavel !='default' || $filial !='default' || $status !='default' || $licencaWin  !='default'){
            if($responsavel !='default'){
              $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE RESPONSAVEL LIKE '%$responsavel%' order by NUMERO_ATIVO ASC");
            }    
            if($filial !='default'){
                $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE CIDADE LIKE '%$filial%' order by NUMERO_ATIVO ASC");
            }
            if($filial !='default' && $responsavel !='default'){
                $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE RESPONSAVEL LIKE '%$responsavel%' && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
            }

            if($status !='default'){
                $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE SITUACAO = '$status' order by NUMERO_ATIVO ASC");
            }
            if($status !='default' && $filial !='default' ){
                $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE SITUACAO = '$status' && CIDADE = '$filial' order by NUMERO_ATIVO ASC");
            }

           
            if($licencaWin !='default' ){
                if($licencaWin =="SEMLICENCA"){
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE LICENCA_WINDOWS ='' order by NUMERO_ATIVO ASC");
                }else{
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE  LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'  order by NUMERO_ATIVO ASC");
            
                }
            } 

            if($licencaWin !='default' && $status !='default' ){
                if($licencaWin =="SEMLICENCA"){
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE LICENCA_WINDOWS ='' && SITUACAO ='$status' order by NUMERO_ATIVO ASC");
                }else{
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE  LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'   && SITUACAO ='$status' order by NUMERO_ATIVO ASC");
            
                }
            } 

            if($licencaWin !='default' && $status !='default' && $filial !='default' ){
                if($licencaWin =="SEMLICENCA"){
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE LICENCA_WINDOWS ='' && SITUACAO ='$status'  && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
                }else{
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE  LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'   && SITUACAO ='$status' && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
            
                }
            } 

            if($licencaWin !='default' && $filial !='default' ){
                if($licencaWin =="SEMLICENCA"){
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE LICENCA_WINDOWS =''  && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
                }else{
                    $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR WHERE  LICENCA_WINDOWS ='4CWNC-GRCH6-D3RK3-9RRG2-XTPKM'    && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
            
                }
            } 

        }
       else{
            $sqlComputador = $pdo->prepare("SELECT IDCOMPUTADOR,NUMERO_ATIVO,CIDADE,MEMORIA_RAM,PROCESSADOR,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,DOMINIO,USUARIO,NOME_PC,SISTEMA_OPERACIONAL,TIPO,LICENCA_WINDOWS FROM COMPUTADOR order by NUMERO_ATIVO ASC LIMIT $inicio , $quantidade");
        }   
        $sqlComputador->execute();
        $total = $sqlComputador->rowCount();
        echo "<h2>Total: ". $total ."</h2>";
        if(!$sqlComputador->rowCount()){
            echo"<h1>Nenhum Resultado encontrado!</h1>";
            }else{
        echo"<table class='table table-dark table-hover'>
            <thead>
            <tr>
                    <th>Status</th>
                    <th>Numero Inventario</th>
                    <th>Responsavel</th>
                    <th>Tipo</th>
                    <th>Sistema Operacional</th>
                    <th>Filial</th>
                    <th>Ação</th>
             </tr>  
             </thead>
             <tbody>  
        ";
            while($row = $sqlComputador->fetch(PDO::FETCH_ASSOC)){
                $img = $row["FOTO"];
                if($row["SITUACAO"] == "AGUARDANDO USO"){
                    $STATUS = "<div class='statusParado'>";
                }else if($row["SITUACAO"] == "EM USO"){
                    $STATUS = "<div class='statusAtivo'>";
                }else{
                    $STATUS = "<div class='statusEstragado'>";
                }
                if($img == null){
                    $foto="<img src='../_img/padroes/padrao.jpg'>";
                }else{
                    $foto ="<img src='../_img/_computadores/".$img."'>";
                }
                if($row["SITUACAO"] == "EM USO"){
                        $status ="Ativo";
                }else if($row["SITUACAO"] == "AGUARDANDO USO"){
                        $status  ="Parado";
                }else{   
                        $status ="Estragado";
                }
                echo"<tr>
                                <td>".$STATUS."</div></td>
                                <td>".$row["NUMERO_ATIVO"]."</td>
                                <td>".$row["RESPONSAVEL"]."</td>
                                <td>".$row["TIPO"]."</td>
                                <td>".$row["SISTEMA_OPERACIONAL"]."</td>
                                <td>".$row["CIDADE"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["NUMERO_ATIVO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                        ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Numero: ".$row["NUMERO_ATIVO"]."</li>
                                                            <li>Tipo: ".$row["TIPO"]."</li>
                                                            <li>Processador: ".$row["PROCESSADOR"]."</li>
                                                            <li>Memoria: ".$row["MEMORIA_RAM"]."</li>
                                                            <li>Modelo: ".$row["MODELO"]."</li>
                                                            <li>Marca: ".$row["MARCA"]."</li>
                                                            <li>Sistema: ".$row["SISTEMA_OPERACIONAL"]."</li>
                                                            <li>Licença Windows: ".$row["LICENCA_WINDOWS"]."</li>
                                                            <li>Dominio: ".$row["DOMINIO"]."</li>
                                                            <li>Usuario: ".$row["USUARIO"]."</li>
                                                            <li>Nome do PC: ".$row["NOME_PC"]."</li>
                                                            <li>Filial: ".$row["CIDADE"]."</li>
                                                            <li>Responsavel: ".$row["RESPONSAVEL"]."</li>
                                                            <li>Situção: ".$row["SITUACAO"]."</li>
                                                            <li>Data Compra: ".$row["DATA_COMPRA"]."</li>
                                                        </ul>  
                                                    </div>    
                                                    <div class='obsModal'>
                                                        <h4>Obs:</h4>
                                                        
                                                            <p>".$row["OBS"]."</p>
                                                       
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            
                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["NUMERO_ATIVO"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idComputadorD' value='".$row["IDCOMPUTADOR"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                    ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='NumeroAtivoA' placeholder='Numero Ativo' value= '".$row["NUMERO_ATIVO"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='ResponsavelA' placeholder='Responsavel' value= '".$row["RESPONSAVEL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='TipoA' placeholder='Tipo' value= '".$row["TIPO"]."'>

                                                        <br> 
                                                        <input type='text' class='form-control form-control' name='ProcessadorA'  placeholder='Processador' value= '".$row["PROCESSADOR"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='MemoriaA' placeholder='Memoria' value= '".$row["MEMORIA_RAM"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='ModeloA' placeholder='Modelo' value= '".$row["MODELO"]."'>

                                                        <br>
                                                        <input type='text' class='form-control form-control' name='MarcaA' placeholder='Marca' value= '".$row["MARCA"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='SOA' placeholder='Sistema Operacional' value= '".$row["SISTEMA_OPERACIONAL"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='LicençaWindowsA' placeholder='Licença Windows' value= '".$row["LICENCA_WINDOWS"]."' >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='DominioA' placeholder='Dominio' value= '".$row["DOMINIO"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='UsuarioA' placeholder='Usuario' value= '".$row["USUARIO"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='NomePCA' placeholder='Nome do PC' value= '".$row["NOME_PC"]."' > 
                                                        <br>
                                                        <select name='StatusA' id='cidadeID' class='form-control' >
                                                            <option  value= '".$row["SITUACAO"]."' selected >".$status."</option>
                                                            <option  value= 'EM USO' >ATIVO</option>
                                                            <option  value= 'AGUARDANDO USO'>PARADO</option>
                                                            <option  value= 'ESTRAGADO' >ESTRAGADO</option>
                                                        </select>
                                                        <br>
                                                        <p>Data da Compra:</p>
                                                        <input type='date' class='form-control form-control' name='DataA' value= '".$row["DATA_COMPRA"]."' >
                                                        <br>
                                                        <p>Filial:</p>
                                                        <select name='CidadeA' id='cidadeID' class='form-control' >
                                                                <option value= '".$row["CIDADE"]."' selected >".$row["CIDADE"]."</option>
                                                                <option value='BALNEARIO CAMBURI-SC'>BALNEARIO CAMBURI-SC</option>
                                                                <option value='BLUMENAU-SC'>BLUMENAU-SC</option>
                                                                <option value='BRUSQUE-SC'>BRUSQUE-SC</option>
                                                                <option value='CASTRO-PR'>CASTRO-PR</option>
                                                                <option value='CARAMBEÍ-PR'>CARAMBEÍ-PR</option>
                                                                <option value='CURITIBA-PR'>CURITIBA-PR</option>
                                                                <option value='CURITIBANO-SC'>CURITIBANO-SC</option>
                                                                <option value='IRATI-PR'>IRATI-PR</option>
                                                                <option value='IBAITI-PR'>IBAITI-PR</option>
                                                                <option value='ORTIGUEIRA-PR'>ORTIGUEIRA-PR</option>
                                                                <option value='OURINHOS-SP'>OURINHOS-SP</option>
                                                                <option value='GURAPUAVA-PR'>GUARAPUAVA-PR</option>
                                                                <option value='LONDRINA-PR'>LONDRINA-PR</option>
                                                                <option value='MARINGA-PR'>MARINGA-PR</option>
                                                                <option value='SÃO JOSÉ DOS PINHAIS-PR'>SÃO JOSÉ DOS PINHAIS-PR</option>
                                                                <option value='PONTA-GROSSA-PR'>PONTA-GROSSA-PR</option>
                                                                <option value='FILIAL NOVA ANDRADINA-MG'>FILIAL NOVA ANDRADINA-MG</option>
                                                                <option value='CASCAVEL-PR'>CASCAVEL-PR</option>
                                                                <option value='GOIAS-MT'>GOIAS-MT</option>
                                                            </select>
                                                        <br>
                                                        <br>
                                                        <p>Foto</p>
                                                        <div class='custom-file mb-3'>
                                                            <input type='file' class='custom-file-input' id='customFile' name='FotoA'>
                                                            <label class='custom-file-label' for='customFile'>Selecione o Arquivo</label>
                                                        </div>
                                                        <div class='obsModal'>
                                                            <label for='comment'>OBS:</label>
                                                            <textarea name='obsA' class='form-control' rows='5' id='comment'>".$row["OBS"]."</textarea>
                                                            <br>
                                                            <input type='hidden' name='idComputador' value='".$row["IDCOMPUTADOR"]."'>
                                                        </div>  
                                                        <br>
                                                        <br>
                                                        <button type='submit' class='btn btn-success'>Gravar</button>  
                                                    </form>
                                                    </div>    
                                                
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            </td>                           
                            </tr>
                        ";        
                
            }
            echo"
            </tbody>
            </table>
            ";

            $sql = $pdo->prepare("SELECT IDCOMPUTADOR FROM COMPUTADOR");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=computador&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=computador&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=computador&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  

        function cadastraComputador($numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin){
            global $pdo;
                $sql= $pdo->prepare("INSERT INTO COMPUTADOR(
                            NUMERO_ATIVO, CIDADE, MEMORIA_RAM, PROCESSADOR, MODELO, MARCA, SITUACAO, RESPONSAVEL, FOTO, OBS, DATA_COMPRA, DOMINIO, USUARIO, NOME_PC, SISTEMA_OPERACIONAL, TIPO,LICENCA_WINDOWS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                    if ($sql->execute(array($numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin))) {
                        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';;
                } else {
                    echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
                }
    }    
}

function atulizaDadosComputador($IDCOMPUTADOR,$numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin){
    global $pdo;
    if($img!=" "){
        $sql = $pdo->prepare("UPDATE COMPUTADOR SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MEMORIA_RAM='$memoria', PROCESSADOR='$processador', MODELO='$modelo', MARCA='$marca', SITUACAO='$status', RESPONSAVEL='$responsavel', OBS='$obs',DATA_COMPRA ='$data', NOME_PC='$nome_pc', SISTEMA_OPERACIONAL='$SO',TIPO='$tipo', LICENCA_WINDOWS='$licencaWin', DOMINIO='$dominio',USUARIO='$usuario' ,FOTO='$img' WHERE IDCOMPUTADOR = '$IDCOMPUTADOR' ");
    }else{
         $sql = $pdo->prepare("UPDATE COMPUTADOR SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MEMORIA_RAM='$memoria', PROCESSADOR='$processador', MODELO='$modelo', MARCA='$marca', SITUACAO='$status', RESPONSAVEL='$responsavel', OBS='$obs',DATA_COMPRA ='$data', NOME_PC='$nome_pc', SISTEMA_OPERACIONAL='$SO',TIPO='$tipo', LICENCA_WINDOWS='$licencaWin', DOMINIO='$dominio',USUARIO='$usuario' WHERE IDCOMPUTADOR = '$IDCOMPUTADOR' ");
    }
    if($sql->execute()){
        echo'
        <div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Atualizado com Sucesso!</h1></div>';
    }else{
        echo'
            <div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Atualização!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
    }
}
     
function deletaComputador($id){
    global $pdo;
    $sql =$pdo->prepare("DELETE FROM COMPUTADOR WHERE IDCOMPUTADOR = '$id'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
    }
}    

//Funções do Ativo Monitor

function AtivosMonitor($responsavel,$filial,$status){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDMONITOR FROM MONITOR ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=monitor&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($responsavel !='default' || $filial !='default' || $status !='default'){
            if($responsavel !='default'){
                $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR WHERE RESPONSAVEL LIKE '%$responsavel%' order by NUMERO_ATIVO ASC");
            }    
            if($filial !='default'){
                $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR WHERE CIDADE LIKE '%$filial%' order by NUMERO_ATIVO ASC");
            }
            if($filial !='default' && $responsavel !='default'){
                $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR WHERE RESPONSAVEL LIKE '%$responsavel%' && CIDADE ='$filial' order by NUMERO_ATIVO ASC");
            }

            if($status !='default'){
                $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR WHERE SITUACAO = '$status' order by NUMERO_ATIVO ASC");
            }
            if($status !='default' && $filial !='default' ){
                $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR WHERE SITUACAO = '$status' && CIDADE = '$filial' order by NUMERO_ATIVO ASC");
            }
        }     
       else{
            $sqlMonitor = $pdo->prepare("SELECT IDMONITOR,NUMERO_ATIVO,CIDADE,MODELO,MARCA,SITUACAO,RESPONSAVEL,FOTO,OBS,DATA_COMPRA,POLEGADA FROM MONITOR order by NUMERO_ATIVO ASC LIMIT $inicio , $quantidade");
        }   
        $sqlMonitor->execute();
        $total = $sqlMonitor->rowCount();
        echo "<h2>Total: ". $total ."</h2>";
        if(!$sqlMonitor->rowCount()){
            echo"<h1>Nenhum Resultado encontrado!</h1>";
            }else{
        echo"<table class='table table-dark table-hover'>
            <thead>
            <tr>
                    <th>Status</th>
                    <th>Numero Inventario</th>
                    <th>Responsavel</th>
                    <th>Filial</th>
                    <th>Ação</th>
             </tr> 
             </thead>
             <tbody>   
        ";
            while($row = $sqlMonitor->fetch(PDO::FETCH_ASSOC)){
                $img = $row["FOTO"];
                if($row["SITUACAO"] == "AGUARDANDO USO"){
                    $STATUS = "<div class='statusParado'>";
                }else if($row["SITUACAO"] == "EM USO"){
                    $STATUS = "<div class='statusAtivo'>";
                }else{
                    $STATUS = "<div class='statusEstragado'>";
                }
                if($img == null){
                    $foto="<img src='../_img/padroes/padrao.jpg'>";
                }else{
                    $foto ="<img src='../_img/_monitores/".$img."'>";
                }
                if($row["SITUACAO"] == "EM USO"){
                        $status ="Ativo";
                }else if($row["SITUACAO"] == "AGUARDANDO USO"){
                        $status  ="Parado";
                }else{   
                        $status ="Estragado";
                }
                echo"<tr>
                                <td>".$STATUS."</div></td>
                                <td>".$row["NUMERO_ATIVO"]."</td>
                                <td>".$row["RESPONSAVEL"]."</td>
                                <td>".$row["CIDADE"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["NUMERO_ATIVO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                        ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Numero: ".$row["NUMERO_ATIVO"]."</li>
                                                            <li>Modelo: ".$row["MODELO"]."</li>
                                                            <li>Marca: ".$row["MARCA"]."</li>
                                                            <li>Polegada: ".$row["POLEGADA"]."</li>
                                                            <li>Filial: ".$row["CIDADE"]."</li>
                                                            <li>Responsavel: ".$row["RESPONSAVEL"]."</li>
                                                            <li>Situção: ".$row["SITUACAO"]."</li>
                                                            <li>Data Compra: ".$row["DATA_COMPRA"]."</li>
                                                        </ul>  
                                                    </div>    
                                                    <div class='obsModal'>
                                                        <h4>Obs:</h4>
                                                        
                                                            <p>".$row["OBS"]."</p>
                                                       
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            
                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["NUMERO_ATIVO"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idMonitorD' value='".$row["IDMONITOR"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                    ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='NumeroAtivoA' placeholder='Numero Ativo' value= '".$row["NUMERO_ATIVO"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='ResponsavelA' placeholder='Responsavel' value= '".$row["RESPONSAVEL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='ModeloA' placeholder='Modelo' value= '".$row["MODELO"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='MarcaA' placeholder='Marca' value= '".$row["MARCA"]."'
                                                        >
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='PolegadaA' placeholder='Polegada' value= '".$row["POLEGADA"]."'>
                                                        <br>
                                                        <select name='StatusA' id='statusID' class='form-control' >
                                                            <option  value= '".$row["SITUACAO"]."' selected >".$status."</option>
                                                            <option  value= 'EM USO' >ATIVO</option>
                                                            <option  value= 'AGUARDANDO USO'>PARADO</option>
                                                            <option  value= 'ESTRAGADO' >ESTRAGADO</option>
                                                        </select>
                                                        <br>
                                                        <p>Data da Compra:</p>
                                                        <input type='date' class='form-control form-control' name='DataA' value= '".$row["DATA_COMPRA"]."' >
                                                        <br>
                                                        <p>Filial:</p>
                                                        <select name='CidadeA' id='cidadeID' class='form-control' >
                                                                <option value= '".$row["CIDADE"]."' selected >".$row["CIDADE"]."</option>
                                                                <option value='BALNEARIO CAMBURI-SC'>BALNEARIO CAMBURI-SC</option>
                                                                <option value='BLUMENAU-SC'>BLUMENAU-SC</option>
                                                                <option value='BRUSQUE-SC'>BRUSQUE-SC</option>
                                                                <option value='CASTRO-PR'>CASTRO-PR</option>
                                                                <option value='CARAMBEÍ-PR'>CARAMBEÍ-PR</option>
                                                                <option value='CURITIBA-PR'>CURITIBA-PR</option>
                                                                <option value='CURITIBANO-SC'>CURITIBANO-SC</option>
                                                                <option value='IRATI-PR'>IRATI-PR</option>
                                                                <option value='IBAITI-PR'>IBAITI-PR</option>
                                                                <option value='ORTIGUEIRA-PR'>ORTIGUEIRA-PR</option>
                                                                <option value='OURINHOS-SP'>OURINHOS-SP</option>
                                                                <option value='GURAPUAVA-PR'>GUARAPUAVA-PR</option>
                                                                <option value='LONDRINA-PR'>LONDRINA-PR</option>
                                                                <option value='MARINGA-PR'>MARINGA-PR</option>
                                                                <option value='SÃO JOSÉ DOS PINHAIS-PR'>SÃO JOSÉ DOS PINHAIS-PR</option>
                                                                <option value='PONTA-GROSSA-PR'>PONTA-GROSSA-PR</option>
                                                                <option value='FILIAL NOVA ANDRADINA-MG'>FILIAL NOVA ANDRADINA-MG</option>
                                                                <option value='CASCAVEL-PR'>CASCAVEL-PR</option>
                                                                <option value='GOIAS-MT'>GOIAS-MT</option>
                                                            </select>
                                                        <br>
                                                        <br>
                                                        <p>Foto</p>
                                                        <div class='custom-file mb-3'>
                                                            <input type='file' class='custom-file-input' id='customFile' name='FotoA'>
                                                            <label class='custom-file-label' for='customFile'>Selecione o Arquivo</label>
                                                        </div>
                                                        <div class='obsModal'>
                                                            <label for='comment'>OBS:</label>
                                                            <textarea name='obsA' class='form-control' rows='5' id='comment'>".$row["OBS"]."</textarea>
                                                            <br>
                                                            <input type='hidden' name='idmonitor' value='".$row["IDMONITOR"]."'>
                                                        </div>  
                                                        <br>
                                                        <br>
                                                        <button type='submit' class='btn btn-success'>Gravar</button>  
                                                    </form>
                                                    </div>    
                                                
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            </td>                           
                            </tr>
                        ";        
                
            }
            echo"
            </tbody>
            </table>
            ";

            $sql = $pdo->prepare("SELECT IDMONITOR FROM MONITOR");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=monitor&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=monitor&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=monitor&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}    

function atulizaDadosMonitor($IDMonitor,$numero, $filial,$modelo,$marca,$polegada, $status, $responsavel, $img, $obs, $data){
    global $pdo;
    if($img!=" "){
        $sql = $pdo->prepare("UPDATE MONITOR SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MODELO='$modelo', MARCA='$marca',POLEGADA = '$polegada' , SITUACAO='$status', OBS='$obs',DATA_COMPRA ='$data',FOTO='$img',RESPONSAVEL = '$responsavel' WHERE IDMONITOR= '$IDMonitor' ");
    }else{
         $sql = $pdo->prepare("UPDATE MONITOR SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MODELO='$modelo', MARCA='$marca',POLEGADA = '$polegada' , SITUACAO='$status', OBS='$obs',DATA_COMPRA ='$data' ,RESPONSAVEL = '$responsavel' WHERE IDMONITOR= '$IDMonitor' ");
    }
    if($sql->execute()){
        echo'
        <div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Atualizado com Sucesso!</h1></div>';
    }else{
        echo'
            <div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Atualização!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
    }
}

function deletaMonitor($id){
    global $pdo;
    $sql =$pdo->prepare("DELETE FROM MONITOR WHERE IDMONITOR = '$id'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
    }
}    

function cadastraMonitor($numero, $filial,$modelo,$marca,$polegada,$status, $responsavel, $img, $obs, $data){
    global $pdo;
        $sql= $pdo->prepare("INSERT INTO MONITOR(
                    NUMERO_ATIVO, CIDADE, MODELO, MARCA,POLEGADA, SITUACAO, RESPONSAVEL, FOTO, OBS, DATA_COMPRA) VALUES (?,?,?,?,?,?,?,?,?,?)");

            if ($sql->execute(array($numero, $filial,$modelo,$marca,$polegada,$status, $responsavel, $img, $obs, $data))) {
                echo'<div class="alert alert-success alert-dismissible alertAbsouto">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
        } else {
            echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
        }
}    
//Funções da Impressora

function AtivosImpressora($filial,$status){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDIMPRESSORA FROM IMPRESSORA ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=impressora&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($filial !='default' || $status !='default'){
         
            if($filial !='default'){
                $sqlImpressora = $pdo->prepare("SELECT IDIMPRESSORA,NUMERO_ATIVO,CIDADE,MODELO,MARCA,TONER,SITUACAO,FOTO,OBS,DATA_COMPRA FROM IMPRESSORA WHERE CIDADE LIKE '%$filial%' order by NUMERO_ATIVO ASC");
            }

            if($status !='default'){
                $sqlImpressora = $pdo->prepare("SELECT IDIMPRESSORA,NUMERO_ATIVO,CIDADE,MODELO,MARCA,TONER,SITUACAO,FOTO,OBS,DATA_COMPRA FROM IMPRESSORA WHERE SITUACAO = '$status' order by NUMERO_ATIVO ASC");
            }
            if($status !='default' && $filial !='default' ){
                $sqlImpressora = $pdo->prepare("SELECT IDIMPRESSORA,NUMERO_ATIVO,CIDADE,MODELO,MARCA,TONER,SITUACAO,FOTO,OBS,DATA_COMPRA FROM IMPRESSORA WHERE SITUACAO = '$status' && CIDADE = '$filial' order by NUMERO_ATIVO ASC");
            }
        }     
       else{
            $sqlImpressora = $pdo->prepare("SELECT IDIMPRESSORA,NUMERO_ATIVO,CIDADE,MODELO,MARCA,TONER,SITUACAO,FOTO,OBS,DATA_COMPRA FROM IMPRESSORA order by NUMERO_ATIVO ASC LIMIT $inicio , $quantidade");
        }   
        $sqlImpressora->execute();
        $total = $sqlImpressora->rowCount();
        echo "<h2>Total: ". $total ."</h2>";
        if(!$sqlImpressora->rowCount()){
            echo"<h1>Nenhum Resultado encontrado!</h1>";
            }else{
        echo"<table class='table table-dark table-hover'>
            <thead>
            <tr>
                    <th>Status</th>
                    <th>Numero Inventario</th>
                    <th>Marca</th>
                    <th>Toner</th>
                    <th>Filial</th>
                    <th>Ação</th>
             </tr>
             </thead>
             <tbody>    
        ";
            while($row = $sqlImpressora->fetch(PDO::FETCH_ASSOC)){
                $img = $row["FOTO"];
                if($row["SITUACAO"] == "AGUARDANDO USO"){
                    $STATUS = "<div class='statusParado'>";
                }else if($row["SITUACAO"] == "EM USO"){
                    $STATUS = "<div class='statusAtivo'>";
                }else{
                    $STATUS = "<div class='statusEstragado'>";
                }
                if($img == null){
                    $foto="<img src='../_img/padroes/padrao.jpg'>";
                }else{
                    $foto ="<img src='../_img/_impressora/".$img."'>";
                }
                if($row["SITUACAO"] == "EM USO"){
                        $status ="Ativo";
                }else if($row["SITUACAO"] == "AGUARDANDO USO"){
                        $status  ="Parado";
                }else{   
                        $status ="Estragado";
                }
                echo"<tr>
                                <td>".$STATUS."</div></td>
                                <td>".$row["NUMERO_ATIVO"]."</td>
                                <td>".$row["MARCA"]."</td>
                                <td>".$row["TONER"]."</td>
                                <td>".$row["CIDADE"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["NUMERO_ATIVO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                        ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Numero: ".$row["NUMERO_ATIVO"]."</li>
                                                            <li>Modelo: ".$row["MODELO"]."</li>
                                                            <li>Marca: ".$row["MARCA"]."</li>
                                                            <li>Toner: ".$row["TONER"]."</li>
                                                            <li>Filial: ".$row["CIDADE"]."</li>
                                                            <li>Situção: ".$row["SITUACAO"]."</li>
                                                            <li>Data Compra: ".$row["DATA_COMPRA"]."</li>
                                                        </ul>  
                                                    </div>    
                                                    <div class='obsModal'>
                                                        <h4>Obs:</h4>
                                                        
                                                            <p>".$row["OBS"]."</p>
                                                       
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            
                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["NUMERO_ATIVO"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["NUMERO_ATIVO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idImpressoraD' value='".$row["IDIMPRESSORA"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                    ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='NumeroAtivoA' placeholder='Numero Ativo' value= '".$row["NUMERO_ATIVO"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='ModeloA' placeholder='Modelo' value= '".$row["MODELO"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='TonerA' placeholder='TONER' value= '".$row["TONER"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='MarcaA' placeholder='Marca' value= '".$row["MARCA"]."'
                                                        >
                                                        <br>
                                                        <select name='StatusA' id='statusID' class='form-control' >
                                                            <option  value= '".$row["SITUACAO"]."' selected >".$status."</option>
                                                            <option  value= 'EM USO' >ATIVO</option>
                                                            <option  value= 'AGUARDANDO USO'>PARADO</option>
                                                            <option  value= 'ESTRAGADO' >ESTRAGADO</option>
                                                        </select>
                                                        <br>
                                                        <p>Data da Compra:</p>
                                                        <input type='date' class='form-control form-control' name='DataA' value= '".$row["DATA_COMPRA"]."' >
                                                        <br>
                                                        <p>Filial:</p>
                                                        <select name='CidadeA' id='cidadeID' class='form-control' >
                                                                <option value= '".$row["CIDADE"]."' selected >".$row["CIDADE"]."</option>
                                                                <option value='BALNEARIO CAMBURI-SC'>BALNEARIO CAMBURI-SC</option>
                                                                <option value='BLUMENAU-SC'>BLUMENAU-SC</option>
                                                                <option value='BRUSQUE-SC'>BRUSQUE-SC</option>
                                                                <option value='CASTRO-PR'>CASTRO-PR</option>
                                                                <option value='CARAMBEÍ-PR'>CARAMBEÍ-PR</option>
                                                                <option value='CURITIBA-PR'>CURITIBA-PR</option>
                                                                <option value='CURITIBANO-SC'>CURITIBANO-SC</option>
                                                                <option value='IRATI-PR'>IRATI-PR</option>
                                                                <option value='IBAITI-PR'>IBAITI-PR</option>
                                                                <option value='ORTIGUEIRA-PR'>ORTIGUEIRA-PR</option>
                                                                <option value='OURINHOS-SP'>OURINHOS-SP</option>
                                                                <option value='GURAPUAVA-PR'>GUARAPUAVA-PR</option>
                                                                <option value='LONDRINA-PR'>LONDRINA-PR</option>
                                                                <option value='MARINGA-PR'>MARINGA-PR</option>
                                                                <option value='SÃO JOSÉ DOS PINHAIS-PR'>SÃO JOSÉ DOS PINHAIS-PR</option>
                                                                <option value='PONTA-GROSSA-PR'>PONTA-GROSSA-PR</option>
                                                                <option value='FILIAL NOVA ANDRADINA-MG'>FILIAL NOVA ANDRADINA-MG</option>
                                                                <option value='CASCAVEL-PR'>CASCAVEL-PR</option>
                                                                <option value='GOIAS-MT'>GOIAS-MT</option>
                                                            </select>
                                                        <br>
                                                        <br>
                                                        <p>Foto</p>
                                                        <div class='custom-file mb-3'>
                                                            <input type='file' class='custom-file-input' id='customFile' name='FotoA'>
                                                            <label class='custom-file-label' for='customFile'>Selecione o Arquivo</label>
                                                        </div>
                                                        <div class='obsModal'>
                                                            <label for='comment'>OBS:</label>
                                                            <textarea name='obsA' class='form-control' rows='5' id='comment'>".$row["OBS"]."</textarea>
                                                            <br>
                                                            <input type='hidden' name='idimpressora' value='".$row["IDIMPRESSORA"]."'>
                                                        </div>  
                                                        <br>
                                                        <br>
                                                        <button type='submit' class='btn btn-success'>Gravar</button>  
                                                    </form>
                                                    </div>    
                                                
                                                    </div>
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            </td>                           
                            </tr>
                        ";        
                
            }
            echo"
            </tbody>
            </table>
            ";

            $sql = $pdo->prepare("SELECT IDIMPRESSORA FROM IMPRESSORA");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=impressora&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=impressora&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=impressora&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}    
function cadastraImpressora($numero, $filial,$modelo,$marca,$status, $toner, $img, $obs, $data){
    global $pdo;
        $sql= $pdo->prepare("INSERT INTO IMPRESSORA(NUMERO_ATIVO, CIDADE, MODELO, MARCA,SITUACAO, TONER, FOTO, OBS, DATA_COMPRA) VALUES (?,?,?,?,?,?,?,?,?)");

            if ($sql->execute(array($numero, $filial,$modelo,$marca,$status, $toner, $img, $obs, $data))) {
                echo'<div class="alert alert-success alert-dismissible alertAbsouto">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
        } else {
            echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
        }
}  

function atulizaDadosImpressora($IDImpressora,$numero, $filial,$modelo,$marca, $status, $toner, $img, $obs, $data){
    global $pdo;
    if($img!=" "){
        $sql = $pdo->prepare("UPDATE IMPRESSORA SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MODELO='$modelo', MARCA='$marca', SITUACAO='$status', OBS='$obs',DATA_COMPRA ='$data',FOTO='$img',TONER = '$toner' WHERE IDIMPRESSORA= '$IDImpressora' ");
    }else{
         $sql = $pdo->prepare("UPDATE IMPRESSORA SET NUMERO_ATIVO= '$numero', CIDADE= '$filial', MODELO='$modelo', MARCA='$marca', SITUACAO='$status', OBS='$obs',DATA_COMPRA ='$data',TONER = '$toner' WHERE IDIMPRESSORA= '$IDImpressora' ");
    }
    if($sql->execute()){
        echo'
        <div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Atualizado com Sucesso!</h1></div>';
    }else{
        echo'
            <div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Atualização!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
    }
}
function deletaImpressora($id){
    global $pdo;
    $sql =$pdo->prepare("DELETE FROM IMPRESSORA WHERE IDIMPRESSORA = '$id'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
    }
}    
function solicitacao($nome,$emaildestino,$nomedestino,$solicitacao){
    global $pdo;
           // Inclui o arquivo class.phpmailer.php localizado na mesma pasta do arquivo php 
           include "../_bibliotecas/phpmailer/PHPMailerAutoload.php"; 
        
           // Inicia a classe PHPMailer 
           $mail = new PHPMailer(); 
           
           // Método de envio 
           $mail->IsSMTP(); 
           
           // Enviar por SMTP 
           $mail->Host = "cmail.madalozzocorretora.com.br"; 
           
           // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
           $mail->Port = 587; 
           
           
           // Usar autenticação SMTP (obrigatório) 
           $mail->SMTPAuth = true; 
           
           // Usuário do servidor SMTP (endereço de email) 
           // obs: Use a mesma senha da sua conta de email 
           $mail->Username = 'sgti@madalozzocorretora.com.br'; 
           $mail->Password = 'Brasil2019*'; 
           
           // Configurações de compatibilidade para autenticação em TLS 
           $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
           
           // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
           // $mail->SMTPDebug = 2; 
           
           // Define o remetente 
           // Seu e-mail 
           $mail->From = "sgti@madalozzocorretora.com.br"; 
           
           // Seu nome 
           $mail->FromName = "Sistema SGTI"; 
            
           
            // Define o(s) destinatário(s) 
            $mail->AddAddress($emaildestino, "FELIPE"); 

            $msg ="Ola, ".$nomedestino."<br><br>";
            $msg .="Você tem uma nova solicitação de compra do departamento TI Madalozzo <br>";
            $msg.=$solicitacao;

            // Opcional: mais de um destinatário
            // $mail->AddAddress('fernando@email.com'); 

            // Opcionais: CC e BCC
            // $mail->AddCC('joana@provedor.com', 'Joana'); 
            // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 

            // Definir se o e-mail é em formato HTML ou texto plano 
            // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
            $mail->IsHTML(true); 

            // Charset (opcional) 
            $mail->CharSet = 'UTF-8'; 

            // Assunto da mensagem 
            $mail->Subject = "Nova Solicitação de Compra TI"; 

            // Corpo do email 
            $mail->Body = $msg; 

            // Opcional: Anexos 
            // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 

            // Envia o e-mail 
            $enviado = $mail->Send(); 

            // Exibe uma mensagem de resultado 
            if ($enviado) 
            { 
                $sql = $pdo->prepare("INSERT INTO SOLICITACAO(NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO)VALUES(?,?,?,?)");
                $sql->execute(array($nome,$nomedestino,$emaildestino,$solicitacao));
                echo"<script>alert('Solcilitação aberta com sucesso!')</script>";
            } else { 
                    $mensagem = "Codigo enviado no E-mail cadastrado!"; "Houve um erro enviando o email: ".$mail->ErrorInfo; 
            } 

    /*$sql = $pdo->prepare("INSERT INTO SOLICITACAO(NOME,SOLICITACAO)VALUES(?,?)");
    $sql->execute(array($nome,$solicitacao));
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;*/
}


function mostrarSolicitacao($status){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDSOLICITACAO FROM SOLICITACAO ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($status !='default'){
                $sqlContato = $pdo->prepare("SELECT IDSOLICITACAO,NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO,DATAABERTURA,SOLICITACAOFECHADA FROM SOLICITACAO WHERE SOLICITACAOFECHADA = $status order by DATAABERTURA DESC");
       }else{
                 $sqlContato = $pdo->prepare("SELECT IDSOLICITACAO,NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO,DATAABERTURA,SOLICITACAOFECHADA FROM SOLICITACAO order by DATAABERTURA DESC LIMIT $inicio , $quantidade");
        }   
        $sqlContato->execute();
        $total = $sqlContato->rowCount();
        echo "<h2>Total: ". $total ."</h2>";
        if(!$sqlContato->rowCount()){
            echo"<h1>Nenhum Resultado encontrado!</h1>";
            }else{
        echo"<table class='table table-dark table-hover'>
            <thead>
            <tr>    
                    <th>Status</th>
                    <th>Nome Solicitante</th>
                    <th>Nome Destino</th>
                    <th>E-mail Destino</th>
                    <th>Data</th>
                    <th>Ação</th>
             </tr>  
             </thead>  
             <tbody>
        ";
            while($row = $sqlContato->fetch(PDO::FETCH_ASSOC)){
                if($row["SOLICITACAOFECHADA"]=1)
                {
                    $status ="RECEBIDO";
                }
                else
                {
                    $status ="NÃO RECEBIDO";
                }
                echo"<tr>
                                <td>".$status."</td>
                                <td>".$row["NOME"]."</td>
                                <td>".$row["NOMEDESTINO"]."</td>
                                <td>".$row["EMAILDESTINO"]."</td>
                                <td>".$row["DATAABERTURA"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["IDSOLICITACAO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["IDSOLICITACAO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>SOLICITAÇÃO - ".$row["NOME"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Nome: ".utf8_encode($row["NOME"])."</li>
                                                            <li>Nome Destino: ".$row["NOMEDESTINO"]."</li>
                                                            <li>E-mail Destino: ".$row["EMAILDESTINO"]."</li>
                                                            <li>Data: ".$row["DATAABERTURA"]."</li>                  
                                                        </ul> 
                                                        <div class='obsModal'>
                                                            <h4>SOLICITACAO:</h4>
                                                            <p>".$row["SOLICITACAO"]."</p>
                                                            <br>
                                                         </div>   
                                                    </div>    
                                                   
                                                </div>                                    
                                            </div>
                                            <!-- Modal footer -->
                                            <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                                        </div>   
                                    </div>
                                </div>
                            </div>    
                            </td>  
                            <td>
                                <form action='' method='POST'>
                                    <input type='hidden' name='idSolicitacaoFecha' value='".$row["IDSOLICITACAO"]."'>
                                    <button type='submit' class='btn btn-success'>Recebeu</button>
                                </form> 
                            </td>              
                            </tr>
                        ";        
                
            }
            echo"
            </tbody>
            </table>
            ";

            $sql = $pdo->prepare("SELECT IDSOLICITACAO FROM SOLICITACAO");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=solicitacao&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=solicitacao&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   

function fechaSolicitacao($ID){
    global $pdo;
    $sql = $pdo->prepare("UPDATE SOLICITACAO SET SOLICITACAOFECHADA = 1 WHERE IDSOLICITACAO = $ID");
    $sql->execute();
}
function solicitacao2($nome,$emaildestino,$nomedestino,$solicitacao){

    global $pdo;
           // Inclui o arquivo class.phpmailer.php localizado na mesma pasta do arquivo php 
           include "../_bibliotecas/phpmailer/PHPMailerAutoload.php"; 
        
           // Inicia a classe PHPMailer 
           $mail = new PHPMailer(); 
           
           // Método de envio 
           $mail->IsSMTP(); 
           
           // Enviar por SMTP 
           $mail->Host = "cmail.madalozzocorretora.com.br"; 
           
           // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
           $mail->Port = 587; 
           
           
           // Usar autenticação SMTP (obrigatório) 
           $mail->SMTPAuth = true; 
           
           // Usuário do servidor SMTP (endereço de email) 
           // obs: Use a mesma senha da sua conta de email 
           $mail->Username = 'sgti@madalozzocorretora.com.br'; 
           $mail->Password = 'Brasil2019*'; 
           
           // Configurações de compatibilidade para autenticação em TLS 
           $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
           
           // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
           // $mail->SMTPDebug = 2; 
           
           // Define o remetente 
           // Seu e-mail 
           $mail->From = "sgti@madalozzocorretora.com.br"; 
           
           // Seu nome 
           $mail->FromName = "Sistema SGTI"; 
            
           
            // Define o(s) destinatário(s) 
            $mail->AddAddress($emaildestino, "FELIPE"); 

            $msg ="Ola, ".$nomedestino."<br><br>";
            $msg .="Preciso de alguns toners: <br>";
            $msg.=$solicitacao;

            // Opcional: mais de um destinatário
            // $mail->AddAddress('fernando@email.com'); 

            // Opcionais: CC e BCC
            // $mail->AddCC('joana@provedor.com', 'Joana'); 
            // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 

            // Definir se o e-mail é em formato HTML ou texto plano 
            // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
            $mail->IsHTML(true); 

            // Charset (opcional) 
            $mail->CharSet = 'UTF-8'; 

            // Assunto da mensagem 
            $mail->Subject = "Solicitação Toner:"; 

            // Corpo do email 
            $mail->Body = $msg; 

            // Opcional: Anexos 
            // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 

            // Envia o e-mail 
            $enviado = $mail->Send(); 

            // Exibe uma mensagem de resultado 
            if ($enviado) 
            { 
                $sql = $pdo->prepare("INSERT INTO SOLICITACAO(NOME,NOMEDESTINO,EMAILDESTINO,SOLICITACAO)VALUES(?,?,?,?)");
                $sql->execute(array($nome,$nomedestino,$emaildestino,$solicitacao));
                echo"<script>alert('Solcilitação aberta com sucesso!')</script>";
            } else { 
                    $mensagem = "Codigo enviado no E-mail cadastrado!"; "Houve um erro enviando o email: ".$mail->ErrorInfo; 
            } 

    /*$sql = $pdo->prepare("INSERT INTO SOLICITACAO(NOME,SOLICITACAO)VALUES(?,?)");
    $sql->execute(array($nome,$solicitacao));
    $consulta = $sql->fetch(PDO::FETCH_ASSOC);
    $quantidade = $consulta["QTD"];
    return $quantidade;*/

}

function lembrete($id){
  global $pdo; 
  $data = date("d/m/Y");
  $sql = $pdo->prepare("SELECT * FROM LEMBRETE WHERE DATA_LEMBRADA = '$data' && ID_USUARIO = '$id'");
  $sql->execute();
  $qtd = $sql->rowCount();
  if($qtd == 0){
    echo"Você não tem lembrete hoje";
  }else{
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
      echo"<div class='lembrete-texto'>";
      echo $row["LEMBRETE"];
      echo"</div>";
    }
  }  
}

function salvarLembrete($data,$lembrete,$id){
  global $pdo;
  $data = date("d/m/Y",strtotime($data));
  $sql=$pdo->prepare("INSERT INTO LEMBRETE(DATA_LEMBRADA,LEMBRETE,ID_USUARIO) VALUES(?,?,?)");
  if($sql->execute(array($data,$lembrete,$id))){
      echo "<script>alert('Lembrete Salvo');</script>";
  }
}
function exibirLembretes($id){
  global $pdo; 
  $sql = $pdo->prepare("SELECT * FROM LEMBRETE WHERE ID_USUARIO = '$id'");
  $sql->execute();
  $qtd = $sql->rowCount();
  if($qtd == 0){
    echo"Você não possui lembretes";
  }else{
    echo"<table class='table'><thead>";
    echo"<tr>";
    echo"<th>LEMBRETE</th>";
    echo"<th>DATA</th>";
    echo"<th>AÇÃO</th>";
    echo"</tr></thead><tbody>";
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      echo"<tr>";
      echo"<td>".$row["LEMBRETE"]."</td>";
      echo"<td>".$row["DATA_LEMBRADA"]."</td>";
      echo"<td><a href='lembrete.php?id=".$row["IDLEMBRETE"]."'>EXCLUIR</a></td>";
      echo"</tr>";
    }
    echo"</tbody></table>";
  }
}
function deletaLembrete($idL){
  global $pdo;
  $sql = $pdo->prepare("DELETE FROM LEMBRETE WHERE IDLEMBRETE = $idL");
  if($sql->execute()){
    echo "<script>alert('Deletado');</script>";
    header("location:lembrete.php");
  }
}
?>