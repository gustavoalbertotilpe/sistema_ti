<?php
    function listarNumeroInvantario(){
            global $pdo;
            $sql= $pdo->prepare("SELECT NUMERO_ATIVO FROM COMPUTADOR");
            $sql->execute();
            echo"
                <label for='idnumero'>Numero do Ativo: </label>
                <select id='idnumero' name='numeroAtivo' class='form-control' required>
                <option>---Numero Iventario---</option>
            ";
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                echo"
                    <option value=".$row["NUMERO_ATIVO"].">".$row["NUMERO_ATIVO"]."</option>
                ";
            }
            echo"</select><br>";
      }

      function manutencao($busca,$tipo){
          global $pdo;
          $quantidade = 20;
          $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
          $inicio = ($quantidade * $pagina) - $quantidade;
   
          echo" <div class='paginacao'>";
   
                  $sql = $pdo->prepare("SELECT IDMANUTENCAO FROM MANUTENCAO ");
                  $sql->execute();
                  $numTotal = $sql->rowCount();
                  $totalPagina= ceil($numTotal/$quantidade);
          
                  $exibir = 15;
          
                  $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
          
                  $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                  echo "<ul class='pagination'>";
                  
                  echo '<li class="page-item"><a class="page-link" href="?url=manutencao&pagina=1">Primeira</a></li> ';
   
                  echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$anterior.'">Anterior</a></li> ';
   
                  for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                      if($i > 0)
                      echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$i.'">'.$i.'</a></li>';
                      }
                      echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
              
              for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                      if($i <= $totalPagina)
                      echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$i.'">'.$i.'</a></li>';
              }
              echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$posterior.'">Próxima</a></li> ';
              echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$totalPagina.'">Última</a></li> ';
              echo "</ul>";   
          echo"</div>";   
          if($busca !="default" || $tipo !="default" ){
               
                    $sqlM = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRICAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO WHERE NUMERO_ATIVO = '$busca' || TIPO_MANUTENCAO = '$tipo'");
                
            }else{
                $sqlM = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRICAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO order by IDMANUTENCAO ASC LIMIT $inicio , $quantidade");
            }      
       
            $sqlM->execute();
           $total = $sqlM->rowCount();
           echo "<h2>Total: ". $total ."</h2>";
           if(!$sqlM->rowCount()){
               echo"<h1>Nenhum Resultado encontrado!</h1>";
               }else{
           echo"<table class='table table-dark table-hover'>
               <thead>
               <tr>
                       <th>Numero</th>
                       <th>Tipo Manutencao</th>
                       <th>Data</th>
                       <th>Ação</th>
                </tr>   
                </thead>
                <tbody> 
           ";
               while($row = $sqlM->fetch(PDO::FETCH_ASSOC)){
                   echo"<tr>
                                   <td>".$row["IDMANUTENCAO"]."</td>
                                   <td>".$row["TIPO_MANUTENCAO"]."</td>
                                   <td>".$row["DATA_MANUTENCAO"]."</td>
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
                                                      
                                                       <div class='itensModalM'>
                                                           <ul>
                                                               <li>Numero ativo: ".$row["NUMERO_ATIVO"]."</li>
                                                               <li>Numero manutenção: ".$row["IDMANUTENCAO"]."</li>
                                                               <li>Data: ".$row["DATA_MANUTENCAO"]."</li>
                                                           </ul>  
                                                       </div>   
                                                       <div class='obsModal'>
                                                           <h4>Descrição do Defeito:</h4>
                                                               <p>".$row["DESCRICAO_DEFEITO"]."</p> 
                                                       </div>
                                                       <div class='obsModal'>
                                                           <h4>Procedimento:</h4>
                                                               <p>".$row["PROCEDIMENTO"]."</p> 
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
                                                   <input type='hidden' name='idManutencaoD' value='".$row["IDMANUTENCAO"]."' >
                                                   <input class='btn btn-danger' type='submit' value='Deletar'>
                                               </form>
                                               <h4 class='modal-title'>PC - ".$row["NUMERO_ATIVO"]."</h4>
                                               <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                               </div>
                                               <div class='modal-body colorModal'>
                                                   <div class='detalhesModal'>
                                                   
                                                       <div class='itensModalM'>
                                                       <div>
                                                       <form class='form-group' method='POST' action=''>
                                                       <label for='idNumero'>Numero ativo:</label>     
                                                       <input id='idNumero' type='text' class='form-control form-control' name='NumeroA' placeholder='Numero ' value= '".$row["NUMERO_ATIVO"]."' disabled >
                                                           <br>
                                                           <label for='idData'>Data manutenção:</label>
                                                           <input type='date' class='form-control form-control' name='DataA' placeholder='Data Manutenção' value= '".$row["DATA_MANUTENCAO"]."'>
                                                           <br>
                                                           <div class='obsModal'>
                                                               <label for='comment'>Descrição do defeito:</label>
                                                               <textarea name='DescricaoA' class='form-control' rows='5' id='comment'>".$row["DESCRICAO_DEFEITO"]."</textarea>
                                                               <br>
                                                           </div>  
                                                           <br>
                                                           <div class='obsModal'>
                                                           <label for='comment1'>Procedimento:</label>
                                                           <textarea name='ProcedimentoA' class='form-control' rows='5' id='comment1'>".$row["PROCEDIMENTO"]."</textarea>
                                                           <br>
                                                            </div>  
                                                            <br>
                                                            <div class='obsModal'>
                                                            <label for='comment2'>OBS:</label>
                                                            <textarea name='ObsA' class='form-control' rows='5' id='comment2'>".$row["OBS"]."</textarea>
                                                            <br>
                                                            <input type='hidden' name='idmanutencao' value='".$row["IDMANUTENCAO"]."'>
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
               
               echo '<li class="page-item"><a class="page-link" href="?url=manutencao&pagina=1">Primeira</a></li> ';
   
               echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$anterior.'">Anterior</a></li> ';
   
               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=manutencao&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=manutencao&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";
   
           
           }  
          /*if($busca !="default" || $tipo !="default" ){
                if($busca !="default"){
                    $sql = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRIAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO WHERE NUMERO_ATIVO = '$busca'");
                }
                if($tipo !="default"){
                    $sql = $pdo->prepare("SELECT IDMANUTENCAO,NUMERO_ATIVO,DATA_MANUTENCAO,DESCRIAO_DEFEITO,TIPO_MANUTENCAO,PROCEDIMENTO,OBS FROM MANUTENCAO WHERE TIPO_MANUTENCAO = '$tipo'");
                }
          }  
          */
      }

    function  cadastraM($numeroAtivo,$tipoM,$dataM,$descricao,$procedimento){
          global $pdo;
          $sql= $pdo->prepare("INSERT INTO MANUTENCAO(NUMERO_ATIVO,TIPO_MANUTENCAO,DATA_MANUTENCAO,DESCRICAO_DEFEITO,PROCEDIMENTO )VALUES (?,?,?,?,?)");
          if($sql->execute(array($numeroAtivo,$tipoM,$dataM,$descricao,$procedimento))){
            echo'<div class="alert alert-success alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
          }else{
            echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
          }
      }

      function atualizaM($id,$DataA,$DescricaoA,$ProcedimentoA,$ObsA){
          global $pdo;
          $sql = $pdo->prepare("UPDATE MANUTENCAO SET DATA_MANUTENCAO ='$DataA',DESCRICAO_DEFEITO ='$DescricaoA',PROCEDIMENTO='$ProcedimentoA',OBS = '$ObsA' WHERE IDMANUTENCAO = '$id'");
          if($sql->execute()){
            echo'<div class="alert alert-success alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Atualizado com Sucesso!</h1></strong></div>';
          }else{
            echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de Atualiza!</h1></strong><h3>Tente novamente!</h3></div>';
          }
          
      }
      function deletaD($id){
        global $pdo;
        $sql =$pdo->prepare("DELETE FROM MANUTENCAO WHERE IDMANUTENCAO = '$id'");
        if($sql->execute()){
            echo'<div class="alert alert-success alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Deletado com Sucesso!</h1></strong></div>';
        }
      }

      //funções contato

      //Funções da Impressora

function contatos($nome){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDCONTATO FROM CONTATO ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=contatos&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($nome !='default'){
                $sqlContato = $pdo->prepare("SELECT IDCONTATO,NOME,TELEFONE,EMAIL,OBS,FOTO FROM CONTATO WHERE NOME LIKE '%$nome%' order by NOME ASC");
       }else{
                 $sqlContato = $pdo->prepare("SELECT IDCONTATO,NOME,TELEFONE,EMAIL,OBS,FOTO FROM CONTATO order by NOME ASC LIMIT $inicio , $quantidade");
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
                    <th>Nome</th>
                    <th>Numero</th>
                    <th>E-mail</th>
                    <th>Obs</th>
                    <th>Ação</th>
             </tr>  
             </thead>
             <tbody>  
        ";
            while($row = $sqlContato->fetch(PDO::FETCH_ASSOC)){
                $img = $row["FOTO"];
                if($img == null){
                    $foto="<img src='../_img/padroes/padrao.jpg'>";
                }else{
                    $foto ="<img src='../_img/_contatos/".$img."'>";
                }
                echo"<tr>
                                <td>".$row["NOME"]."</td>
                                <td>".$row["TELEFONE"]."</td>
                                <td>".$row["EMAIL"]."</td>
                                <td>".$row["OBS"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["IDCONTATO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["IDCONTATO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>CONTATOS - ".$row["NOME"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='imgModal'>
                                                        ".$foto."
                                                    </div>  
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Nome: ".utf8_encode($row["NOME"])."</li>
                                                            <li>Telefone: ".$row["TELEFONE"]."</li>
                                                            <li>E-mail: ".$row["EMAIL"]."</li>
                                                          
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

                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["IDCONTATO"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["IDCONTATO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idcontatoD' value='".$row["IDCONTATO"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>PC - ".$row["NOME"]."</h4>
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
                                                        <input type='text' class='form-control form-control' name='NomeA' placeholder='Nome:' value= '".$row["NOME"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='TelA' placeholder='Telefone' value= '".$row["TELEFONE"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='EmailA' placeholder='E-mail' value= '".$row["EMAIL"]."'>
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
                                                            <input type='hidden' name='idcontato' value='".$row["IDCONTATO"]."'>
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

            $sql = $pdo->prepare("SELECT IDCONTATO FROM CONTATO");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=contatos&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=contatos&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=contatos&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   

function cadastracaontato($nome, $tel,$email,$obs, $img){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO CONTATO(NOME,TELEFONE,EMAIL,OBS,FOTO) VALUES(?,?,?,?,?)");
    if($sql->execute(array($nome,$tel,$email,$obs,$img))){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}
function atualizaContatos($IDContato,$nome, $tel,$email,$obs, $img){
    global $pdo;
    $id =1;

    if($img!="default"){
        $sql = $pdo->prepare("UPDATE CONTATO SET NOME ='$nome',TELEFONE ='$tel',EMAIL='$email',OBS='$obs',FOTO='$img' WHERE IDCONTATO = '$IDContato'");
      
    }else{
        $sql = $pdo->prepare("UPDATE CONTATO SET NOME ='$nome',TELEFONE ='$tel',EMAIL='$email',OBS='$obs' WHERE IDCONTATO = '$IDContato'");
     
    }
   
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Atualizado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Atualiza!</h1></strong><h3>Tente novamente!</h3></div>';
      }
    
}
function deletaContato($IDCONTATO){
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM CONTATO WHERE IDCONTATO = '$IDCONTATO'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Deleta!</h1></strong><h3>Tente novamente!</h3></div>';
      }
}

//Funçoes da página chamados

function chamado($busca,$status){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDCHAMADO FROM CHAMADO ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=chamado&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($busca !='default' || $status !='default'){
                
                if($busca !='default'){
                    $sqlChamado = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA, SOLICITANTE,PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO WHERE TITULO LIKE '%$busca%' order by IDCHAMADO DESC");

                    echo $busca;
                }else
                if($status !='default'){
                    $sqlChamado = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA, SOLICITANTE, PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO WHERE STATUS LIKE '%$status%' order by IDCHAMADO DESC");
                }else
                if($busca !='default' && $status !='default'){
                    $sqlChamado = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA, SOLICITANTE, PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO WHERE TITULO LIKE '%$busca%' && STATUS LIKE '%$status%' order by IDCHAMADO DESC");
                }

       }else{
                 $sqlChamado = $pdo->prepare("SELECT IDCHAMADO,DATA_ABERTURA,SOLICITANTE,PROBLEMA,SOLUCAO,OBS,DATA_FECHAMENTO,TITULO,STATUS,PRIORIDADE FROM CHAMADO order by IDCHAMADO DESC LIMIT $inicio , $quantidade");
        }   
        $sqlChamado->execute();
        $total = $sqlChamado->rowCount();
        echo "<h2>Total: ". $total ."</h2>";
        if(!$sqlChamado->rowCount()){
            echo"<h1>Nenhum Resultado encontrado!</h1>";
            }else{
        echo"<table class='table table-dark table-hover'>
            <thead>
            <tr>
                    <th>STATUS</th>
                    <th>DATA DA ABERTURA</th>
                    <th>SOLICITANTA</th>
                    <th>TITULO</th>
                    <th>PRIORIDADE</th>
                    <th>Ação</th>
             </tr>  
             </thead>
             <tbody>  
        ";
            while($row = $sqlChamado->fetch(PDO::FETCH_ASSOC)){
              
                echo"<tr>
                                <td>".$row["STATUS"]."</td>
                                <td>".$row["DATA_ABERTURA"]."</td>
                                <td>".$row["SOLICITANTE"]."</td>
                                <td>".$row["TITULO"]."</td>
                                <td>".$row["PRIORIDADE"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["IDCHAMADO"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["IDCHAMADO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>Chamado - ".$row["TITULO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModalM'>
                                                        <ul>
                                                            <li>Numero: ".$row["IDCHAMADO"]."</li>
                                                            <li>Data da Abertura: ".$row["DATA_ABERTURA"]."</li>
                                                            <li>Solicitante: ".$row["SOLICITANTE"]."</li>
                                                            <li>Titulo: ".$row["TITULO"]."</li>
                                                            <li>Prioridade: ".$row["PRIORIDADE"]."</li>
                                                            <li>Status: ".$row["STATUS"]."</li>
                                                            <li>Data do Fechamento: ".$row["DATA_FECHAMENTO"]."</li>
                                                        </ul>      
                                                            <br>
                                                            <div class='obsModal'>
                                                                <h4>SOLICITACAO:</h4>
                                                                <p>".$row["PROBLEMA"]."</p>
                                                                <br>
                                                             </div>  
                                                             <div class='obsModal'>
                                                              <h4>Resolução:</h4>
                                                               <p>".$row["SOLUCAO"]."</p>
                                                                <br>
                                                             </div> 
                                                             <div class='obsModal'>
                                                                <h4>Obs:</h4>
                                                                <p>".$row["OBS"]."</p>
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

                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["IDCHAMADO"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["IDCHAMADO"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idChamadoD' value='".$row["IDCHAMADO"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>CHAMADO - ".$row["TITULO"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModalM'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='NumeroA' placeholder='Numero:' value= '".$row["IDCHAMADO"]."' disabled>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='DataabertutaA' placeholder='Data da Abertura' value= '".$row["DATA_ABERTURA"]."' disabled>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='SolicitanteA' placeholder='Solicitante' value= '".$row["SOLICITANTE"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='TituloA' placeholder='Titulo' value= '".$row["TITULO"]."'>
                                                        <br>
                                                        <label for='idstatus'>STATUS</label>
                                                        <select id='idstatus' name='StatusA' class='form-control form-control'>
                                                            <option value='".$row["STATUS"]."' selected>".$row["STATUS"]."</otpion>
                                                            <option value='ABERTO'>Aberto</option>
                                                            <option value='FECHADO'>Fechado</option>
                                                        </select>
                                                        <br>
                                                        <label for='idprioridade'>PRIORIDADE</label>
                                                        <select id='idprioridade' name='PrioridadeA' class='form-control form-control'>
                                                            <option value='".$row["PRIORIDADE"]."' selected>".$row["PRIORIDADE"]."</otpion>
                                                            <option value='ALTA'>Alta</option>
                                                            <option value='MEDIA'>Media</option>
                                                            <option value='BAIXA'>Baixa</option>
                                                        </select>
                                                        <br>
                                                        <input type='date' class='form-control form-control' name='DatafechamentoA' placeholder='Data do Fechamento' value= '".$row["DATA_FECHAMENTO"]."' >
                                                        <br>
                                                        <div class='obsModal'>
                                                            <label for='comment'>Solicitação:</label>
                                                            <textarea name='SolicitacaoA' class='form-control' rows='5' id='comment'>".$row["PROBLEMA"]."</textarea>
                                                            <br>
                                                        </div>  
                                                        <div class='obsModal'>
                                                            <label for='comment'>Resolução:</label>
                                                            <textarea name='ResolucaoA' class='form-control' rows='5' id='comment'>".$row["SOLUCAO"]."</textarea>
                                                            <br>
                                                        </div> 
                                                        <div class='obsModal'>
                                                        <label for='comment'>OBS:</label>
                                                        <textarea name='OBSA' class='form-control' rows='5' id='comment'>".$row["OBS"]."</textarea>
                                                        <br>
                                                        <input type='hidden' name='idchamado' value='".$row["IDCHAMADO"]."'>
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

            $sql = $pdo->prepare("SELECT IDCHAMADO FROM CHAMADO");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=chamado&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=chamado&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=chamado&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   
function cadastraChamado($data,$titulo,$solicitante,$solicitacao,$prioridade,$status){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO CHAMADO(DATA_ABERTURA,TITULO,SOLICITANTE,PROBLEMA,PRIORIDADE,STATUS) VALUES(?,?,?,?,?,?)");
    if($sql->execute(array($data,$titulo,$solicitante,$solicitacao,$prioridade,$status))){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}
function AtualizaChamado($id,$solicitante,$titulo,$prioridade,$solicitacao,$resolucao,$obs,$dataFechamamento,$status){
    global $pdo;
$sql = $pdo->prepare("UPDATE CHAMADO SET TITULO ='$titulo',SOLICITANTE ='$solicitante',PROBLEMA ='$solicitacao',PRIORIDADE ='$prioridade',STATUS ='$status',SOLUCAO='$resolucao',OBS='$obs',DATA_FECHAMENTO='$dataFechamamento' WHERE IDCHAMADO = $id"); 
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }

}

function deletaChamado($IDCHAMADO){
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM CHAMADO WHERE IDCHAMADO = '$IDCHAMADO'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Deleta!</h1></strong><h3>Tente novamente!</h3></div>';
      }
}

function user($IDUSUARIO){
    global $pdo;
    $sql= $pdo->prepare("SELECT IDUSUARIO,NOME,USERNAME,EMAIL FROM USUARIO  WHERE IDUSUARIO = '$IDUSUARIO'");
    $sql->execute();
    while($row= $sql->fetch(PDO::FETCH_ASSOC)){
        echo"
            <form form-group action='' method='POST'>
                <label for='idNome'>Nome</label>
                <input id='idNome' type='text' name='nome' class='form-control form-control' value='".$row["NOME"]."'>
                <br>
                <label for='idUsername'>Username</label>
                <input id='idUsername' type='text' name='username'  class='form-control form-control' value='".$row["USERNAME"]."'>
                <br>
                <label for='idEmail'>E-mail</label>
                <input id='idEmail' type='text' name='email' class='form-control form-control' value='".$row["EMAIL"]."'>
                <br>
                <input type='submit' class='btn btn-success' value='Atualizar'> 
            </form>
        ";
    }
}
function atualizaDadosUser($nome,$username,$email,$IDUSUARIO){
    global $pdo;
    $sql = $pdo->prepare("UPDATE USUARIO SET NOME = '$nome', USERNAME ='$username',EMAIL = '$email' WHERE IDUSUARIO = '$IDUSUARIO'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>ATUALIZADO COM SUCESSO!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de ATUALZIAÇÃO!</h1></strong><h3>Tente novamente!</h3></div>';
      }
    
}
function atualizaSenhaUser($senha,$ID){
    global $pdo;
    $sql = $pdo->prepare("UPDATE USUARIO SET SENHA = '$senha' WHERE IDUSUARIO = '$ID'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>ATUALIZADO COM SUCESSO!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de ATUALZIAÇÃO!</h1></strong><h3>Tente novamente!</h3></div>';
      }
}

// funções pagina usuarios

function usuarios($busca,$IDUSUARIO){
    global $pdo;
      
    $quantidade = 20;
    $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
    $inicio = ($quantidade * $pagina) - $quantidade;

    echo" <div class='paginacao'>";

            $sql = $pdo->prepare("SELECT IDUSUARIO FROM USUARIO ");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);
    
            $exibir = 15;
    
            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
    
            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=usuario&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";   
    echo"</div>";   
             
     if($busca !='default'){
        $sqlUsuario = $pdo->prepare("SELECT IDUSUARIO,NOME,USERNAME,SENHA,EMAIL FROM USUARIO WHERE NOME LIKE '%$busca%' && IDUSUARIO <> '$IDUSUARIO' order by NOME ASC");

     }else{
        $sqlUsuario = $pdo->prepare("SELECT IDUSUARIO,NOME,USERNAME,SENHA,EMAIL FROM USUARIO WHERE IDUSUARIO <> '$IDUSUARIO'  order by NOME DESC LIMIT $inicio , $quantidade");
     }   
     $sqlUsuario->execute();
     $total = $sqlUsuario->rowCount();
     echo "<h2>Total: ". $total ."</h2>";
     if(!$sqlUsuario->rowCount()){
         echo"<h1>Nenhum Resultado encontrado!</h1>";
         }else{
     echo"<table class='table table-dark table-hover'>
         <thead>
         <tr>
                 <th>NOME</th>
                 <th>USERNAME</th>
                 <th>EMAIL</th>
                 <th>Ação</th>
          </tr>   
          </thead>
          <tbody> 
     ";
         while($row = $sqlUsuario->fetch(PDO::FETCH_ASSOC)){
           
             echo"<tr>
                             <td>".$row["NOME"]."</td>
                             <td>".$row["USERNAME"]."</td>
                             <td>".$row["EMAIL"]."</td>
                             <td>
                             <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["IDUSUARIO"]."'>Detalhes</button>
                             <div class= 'modal fade' id='myModal".$row["IDUSUARIO"]."'>
                                 <div class='modal-dialog modal-xl'>
                                     <div class='modal-content'>
                                         <div class='modal-header'>
                                         <h4 class='modal-title'>Chamado - ".$row["NOME"]."</h4>
                                         <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                         </div>
                                         <div class='modal-body'>
                                             <div class='detalhesModal'>
                                                 <div class='itensModalM'>
                                                     <ul>
                                                         <li>Nome: ".$row["NOME"]."</li>
                                                         <li>Username: ".$row["USERNAME"]."</li>
                                                         <li>E-mail: ".$row["EMAIL"]."</li>
                                                     </ul>      
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

                             <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["IDUSUARIO"]."'>Atualizar</button>
                             <div class= 'modal fade'  id='myModalAlterar".$row["IDUSUARIO"]."'>
                                 <div class='modal-dialog modal-xl'>
                                     <div class='modal-content'>
                                         <div class='modal-header'>
                                         <form method='POST' action=''>
                                             <input type='hidden' name='idUsuarioD' value='".$row["IDUSUARIO"]."'>
                                             <input class='btn btn-danger' type='submit' value='Deletar'>
                                         </form>
                                         <h4 class='modal-title'>USUARIO - ".$row["NOME"]."</h4>
                                         <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                         </div>
                                         <div class='modal-body colorModal'>
                                             <div class='detalhesModal'>
                                                 <div class='itensModalM'>
                                                 <div>
                                                 <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                     <input type='text' class='form-control form-control' name='NomeA' placeholder='Nome:' value= '".$row["NOME"]."' >
                                                     <br>
                                                     <input type='text' class='form-control form-control' name='UsernameA' placeholder='Username:' value= '".$row["USERNAME"]."'>
                                                     <br>
                                                     <input type='text' class='form-control form-control' name='EmailA' placeholder='E-Mail' value= '".$row["EMAIL"]."'>
                                                     <br>
                                                     <input type='password' class='form-control form-control' name='SenhaA' placeholder='Senha' value= '".$row["SENHA"]."'>
                                                     <br>
                                                    
                                                     <input type='hidden' name='idusuario' value='".$row["IDUSUARIO"]."'>
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

         $sql = $pdo->prepare("SELECT IDUSUARIO FROM USUARIO");
         $sql->execute();
         $numTotal = $sql->rowCount();
         $totalPagina= ceil($numTotal/$quantidade);

         $exibir = 15;

         $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

         $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
         echo "<ul class='pagination'>";
         
         echo '<li class="page-item"><a class="page-link" href="?url=usuario&pagina=1">Primeira</a></li> ';

         echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$anterior.'">Anterior</a></li> ';

         for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
             if($i > 0)
             echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$i.'">'.$i.'</a></li>';
             }
             echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
     
     for($i = $pagina+1; $i < $pagina+$exibir; $i++){
             if($i <= $totalPagina)
             echo'<li class="page-item"><a class="page-link" href="?url=usuario&pagina='.$i.'">'.$i.'</a></li>';
     }
     echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$posterior.'">Próxima</a></li> ';
     echo '<li class="page-item"><a class="page-link"  href="?url=usuario&pagina='.$totalPagina.'">Última</a></li> ';
     echo "</ul>";

     
     }  
}

function cadastraUsuarios($nome,$username,$email,$senha){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO USUARIO(NOME,USERNAME,EMAIL,SENHA) VALUES(?,?,?,?)");
    if($sql->execute(array($nome,$username,$email,$senha))){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}
function AtualizaUsuairo($id,$nome,$username,$email,$senha){
    global $pdo;
    $sql = $pdo->prepare("UPDATE USUARIO SET NOME ='$nome',USERNAME ='$username',EMAIL ='$email',SENHA ='$senha' WHERE IDUSUARIO = $id"); 
        if($sql->execute()){
            echo'<div class="alert alert-success alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>ATUALIZADO com Sucesso!</h1></strong></div>';
          }else{
            echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><h1>Erro na tentativa de ATUALIZAR!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
          }
}
function deletaUsuario($ID){
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM USUARIO WHERE IDUSUARIO = '$ID'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>DELETADO com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de DELETAR!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}


//Funçoes do ramal

function ramais($nome){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT IDRAMAIS FROM RAMAIS ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=ramais&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
       if($nome !='default'){
                $sqlContato = $pdo->prepare("SELECT IDRAMAIS,NOME,TELEFONE,RAMAL,EMAIL,CIDADE,ESTADO FROM RAMAIS WHERE NOME LIKE '%$nome%' order by NOME ASC");
       }else{
                 $sqlContato = $pdo->prepare("SELECT IDRAMAIS,NOME,TELEFONE,RAMAL,EMAIL,CIDADE,ESTADO FROM RAMAIS order by NOME ASC LIMIT $inicio , $quantidade");
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
                    <th>Nome</th>
                    <th>TELEFONE</th>
                    <th>Ramal</th>
                    <th>E-mail</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ação</th>
             </tr>   
             </thead>
             <tbody> 
        ";
            while($row = $sqlContato->fetch(PDO::FETCH_ASSOC)){
                echo"<tr>
                                <td>".$row["NOME"]."</td>
                                <td>".$row["TELEFONE"]."</td>
                                <td>".$row["RAMAL"]."</td>
                                <td>".$row["EMAIL"]."</td>
                                <td>".$row["CIDADE"]."</td>
                                <td>".$row["ESTADO"]."</td>
                                <td>
                                <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModal".$row["IDRAMAIS"]."'>Detalhes</button>
                                <div class= 'modal fade' id='myModal".$row["IDRAMAIS"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <h4 class='modal-title'>RAMAIS - ".$row["NOME"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModal'>
                                                        <ul>
                                                            <li>Nome: ".utf8_encode($row["NOME"])."</li>
                                                            <li>Telefone: ".$row["TELEFONE"]."</li>
                                                            <li>Ramal: ".$row["RAMAL"]."</li>
                                                            <li>E-mail: ".$row["EMAIL"]."</li>
                                                            <li>Cidade: ".$row["CIDADE"]."-".$row["ESTADO"]."</li>                                                          
                                                        </ul>  
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

                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["IDRAMAIS"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["IDRAMAIS"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idramalD' value='".$row["IDRAMAIS"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>RAMAIS - ".$row["NOME"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='NomeA' placeholder='Nome:' value= '".$row["NOME"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='TelA' placeholder='Telefone:' value= '".$row["TELEFONE"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='RamalA' placeholder='Ramal:' value= '".$row["RAMAL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='EmailA' placeholder='E-mail' value= '".$row["EMAIL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='CidadeA' placeholder='Cidade' value= '".$row["CIDADE"]."'>
                                                        <input type='text' class='form-control form-control' name='EstadoA' placeholder='Estado' value= '".$row["ESTADO"]."'>
                                                        <br>
                                                     
                                                        <div class='obsModal'>
                                                            <input type='hidden' name='idramal' value='".$row["IDRAMAIS"]."'>
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

            $sql = $pdo->prepare("SELECT IDRAMAIS FROM RAMAIS");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=ramais&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=ramais&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=ramais&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   

function cadastraramal($nome, $tel,$ramal,$email, $cidade,$estado){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO RAMAIS(NOME,TELEFONE,RAMAL,EMAIL,CIDADE,ESTADO) VALUES(?,?,?,?,?,?)");
    if($sql->execute(array($nome,$tel,$ramal,$email,$cidade,$estado))){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Cadastrado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}
function atualizaRamal($IDRamal,$nome, $tel,$ramal,$email,$cidade, $estado){
    global $pdo;
    $id =1;

        $sql = $pdo->prepare("UPDATE RAMAIS SET NOME ='$nome',TELEFONE ='$tel',EMAIL='$email',RAMAL='$ramal',CIDADE='$cidade',ESTADO ='$estado' WHERE IDRAMAIS = '$IDRamal'");
      
    
   
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Atualizado com Sucesso!</h1></strong></div>';
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Atualiza!</h1></strong><h3>Tente novamente!</h3></div>';
      }
    
}
function deletaRamal($IDRAMAL){
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM RAMAIS WHERE IDRAMAIS = '$IDRAMAL'");
    if($sql->execute()){
        echo'<div class="alert alert-success alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Deletado com Sucesso!</h1></strong></div>';
        
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Deleta!</h1></strong><h3>Tente novamente!</h3></div>';
      }
}

function cadastraSenha($seguradora,$url,$login,$senha,$obs,$tipo,$categoria){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO SENHAS_SEGURADORAS(SEGURADORA,URL,LOGIN,SENHA,OBS,TIPO,CATEGORIA) VALUES(?,?,?,?,?,?,?)");
    if($sql->execute(array($seguradora,$url,$login,$senha,$obs,$tipo,$categoria))){
      
      }else{
        echo  '<div class="alert alert-danger alert-dismissible alertAbsouto">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><h1>Erro na tentativa de Cadastro!</h1></strong><h3>Verifique os campos e tente novamente!</h3></div>';
      }
}


function senhaSeguradora($busca,$categoria){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT ID_SENHAS FROM SENHAS_SEGURADORAS ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=senhas&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
      
      $nome = $busca; 
      $categoria = $categoria;
       if($categoria == 'TI' || $categoria == 'SEGURADORA'){
       $sqlContato = $pdo->prepare("SELECT ID_SENHAS,SEGURADORA,URL,LOGIN,SENHA,OBS,TIPO,CATEGORIA FROM SENHAS_SEGURADORAS WHERE CATEGORIA = '$categoria' order by SEGURADORA ASC");
        
      }
      elseif($nome != 'default')
      {
        $sqlContato = $pdo->prepare("SELECT ID_SENHAS,SEGURADORA,URL,LOGIN,SENHA,OBS,TIPO,CATEGORIA FROM SENHAS_SEGURADORAS WHERE  SEGURADORA LIKE '%$nome%' order by SEGURADORA ASC");
      }
     
      else  
      {
          $sqlContato = $pdo->prepare("SELECT ID_SENHAS,SEGURADORA,URL,LOGIN,SENHA,OBS,TIPO,CATEGORIA FROM SENHAS_SEGURADORAS WHERE SEGURADORA  order by SEGURADORA ASC LIMIT $inicio , $quantidade");
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
                    <th>NOME</th>
                    <th>URL</th>
                    <th>LOGIN</th>
                    <th>SENHA</th>
                    <th>TIPO</th>
                    <th>CATEGORIA</th>
                    <th>Ação</th>
             </tr>  
             </thead>
             <tbody>  
        ";
            while($row = $sqlContato->fetch(PDO::FETCH_ASSOC)){
               
                echo"<tr>
                                <td>".$row["SEGURADORA"]."</td>
                                <td>".$row["URL"]."</td>
                                <td>".$row["LOGIN"]."</td>
                                <td>".$row["SENHA"]."</td>
                                <td>".$row["TIPO"]."</td>
                                <td>".$row["CATEGORIA"]."</td>
                                <td>

                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["ID_SENHAS"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["ID_SENHAS"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idD' value='".$row["ID_SENHAS"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>SENHA - ".$row["SEGURADORA"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='SeguradoraA' placeholder='NOME' value= '".$row["SEGURADORA"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='UrlA' placeholder='URL' value= '".$row["URL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='LoginA' placeholder='LOGIN' value= '".$row["LOGIN"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='SenhaA' placeholder='SENHA' value= '".$row["SENHA"]."'>
                                                        <br>
                                                        <textarea class='form-control' name='obs' value='".$row["OBS"]."'></textarea>
                                                        <input type='hidden' name='id' value='".$row["ID_SENHAS"]."'>
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

            $sql = $pdo->prepare("SELECT ID_SENHAS FROM SENHAS_SEGURADORAS");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=senhas&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=senhas&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=senhas&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   
function atualizaSenha($id,$seguradora,$url,$login,$senha,$obs){
    global $pdo;
    $sql = $pdo->prepare("UPDATE SENHAS_SEGURADORAS SET SEGURADORA =?,URL=?,LOGIN=?,SENHA=?,OBS=? WHERE ID_SENHAS = ?");
    if($sql->execute(array($seguradora,$url,$login,$senha,$obs,$id))){
        echo"<script>alert('Atualizado com sucesso!')</script>";
    }
}
















function cadastraEmail($nome,$email,$senha){
    global $pdo;
    $sql = $pdo->prepare("INSERT INTO EMAIL(NOME,EMAIL,SENHA) VALUES(?,?,?)");
    if($sql->execute(array($nome,$email,$senha))){
        echo "<script>alert('E-mail cadastrado com sucesso!');</script>";
    }
      

}


function contaEmail($busca){
    global $pdo;
      
       $quantidade = 20;
       $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
       $inicio = ($quantidade * $pagina) - $quantidade;

       echo" <div class='paginacao'>";

               $sql = $pdo->prepare("SELECT ID FROM EMAIL ");
               $sql->execute();
               $numTotal = $sql->rowCount();
               $totalPagina= ceil($numTotal/$quantidade);
       
               $exibir = 15;
       
               $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
       
               $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
               echo "<ul class='pagination'>";
               
               echo '<li class="page-item"><a class="page-link" href="?url=contas-email&pagina=1">Primeira</a></li> ';

               echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$anterior.'">Anterior</a></li> ';

               for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                   if($i > 0)
                   echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$i.'">'.$i.'</a></li>';
                   }
                   echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
           
           for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                   if($i <= $totalPagina)
                   echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$i.'">'.$i.'</a></li>';
           }
           echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$posterior.'">Próxima</a></li> ';
           echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$totalPagina.'">Última</a></li> ';
           echo "</ul>";   
       echo"</div>";   
      if($busca != 'default')
      {
        $sqlContato = $pdo->prepare("SELECT ID,NOME,EMAIL,SENHA FROM EMAIL WHERE  EMAIL LIKE '%$busca%' order by NOME ASC");
      }
      else
     {
        $sqlContato = $pdo->prepare("SELECT ID,NOME,EMAIL,SENHA FROM EMAIL order by NOME ASC  LIMIT $inicio , $quantidade");
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
                    <th>NOME</th>
                    <th>E-MAIL</th>
                    <th>SENHA</th>
                    <th>Ação</th>
             </tr>  
             </thead>
             <tbody>  
        ";
            while($row = $sqlContato->fetch(PDO::FETCH_ASSOC)){
               
                echo"<tr>
                                <td>".$row["NOME"]."</td>
                                <td>".$row["EMAIL"]."</td>
                                <td>".$row["SENHA"]."</td>
                                <td>

                                <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalAlterar".$row["ID"]."'>Atualizar</button>
                                <div class= 'modal fade'  id='myModalAlterar".$row["ID"]."'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                            <form method='POST' action=''>
                                                <input type='hidden' name='idD' value='".$row["ID"]."'>
                                                <input class='btn btn-danger' type='submit' value='Deletar'>
                                            </form>
                                            <h4 class='modal-title'>E-MAIL - ".$row["NOME"]."</h4>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>
                                            <div class='modal-body colorModal'>
                                                <div class='detalhesModal'>
                                                    <div class='itensModal'>
                                                    <div>
                                                    <form class='form-group' method='POST' action='' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control form-control' name='nomeAlterar' placeholder='NOME' value= '".$row["NOME"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='emailAlterar' placeholder='E-MAIL' value= '".$row["EMAIL"]."'>
                                                        <br>
                                                        <input type='text' class='form-control form-control' name='senhaAlterar' placeholder='SENHA' value= '".$row["SENHA"]."'>
                                    
                                                        <input type='hidden' name='id' value='".$row["ID"]."'>
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

            $sql = $pdo->prepare("SELECT ID FROM EMAIL");
            $sql->execute();
            $numTotal = $sql->rowCount();
            $totalPagina= ceil($numTotal/$quantidade);

            $exibir = 15;

            $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;

            $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
            echo "<ul class='pagination'>";
            
            echo '<li class="page-item"><a class="page-link" href="?url=contas-email&pagina=1">Primeira</a></li> ';

            echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$anterior.'">Anterior</a></li> ';

            for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                if($i > 0)
                echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$i.'">'.$i.'</a></li>';
                }
                echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$pagina.'"><strong>'.$pagina.'</strong></a></li>';
        
        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                if($i <= $totalPagina)
                echo'<li class="page-item"><a class="page-link" href="?url=contas-email&pagina='.$i.'">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$posterior.'">Próxima</a></li> ';
        echo '<li class="page-item"><a class="page-link"  href="?url=contas-email&pagina='.$totalPagina.'">Última</a></li> ';
        echo "</ul>";

        
        }  
}   


function atualizaEmail($id,$nome,$email,$senha){
    global $pdo;
    $sql = $pdo->prepare("UPDATE EMAIL SET NOME =?,EMAIL=?,SENHA=? WHERE ID = ?");
    if($sql->execute(array($nome,$email,$senha,$id))){
        echo"<script>alert('Atualizado com sucesso!')</script>";
    }
}

function deletaEmail($id){
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM EMAIL WHERE ID = '$id'");
    if($sql->execute()){
        echo"<script>alert('Deletado com sucesso!');</script>";    
    }
}
?>      