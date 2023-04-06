<?php
    $filial =  exibirFilialAtivos();
    include('../_funcoes/funcoes2.php');
?>    
<div class='row'>
    <div class='col menuAtivos'>
        <ul>
            <li><a href="?url=default">Voltar</a></li> 
            <li><button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalCadastrar'>Cadastrar</button>
                <div class= 'modal fade' id='myModalCadastrar'>
                    <div class='modal-dialog modal-xl'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                            <h4 class='modal-title'>Cadastro</h4>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                            </div>
                            <div class='modal-body'>
                                <div>
                                    <form class="form-group" action='' method='POST' enctype="multipart/form-data">
                                        <input type='text' name='nome' class="form-control form-control" placeholder="Nome" autocomplete="off" required >
                                        <br>
                                        <input type='text' name='ramal' class="form-control form-control" placeholder="Ramal" autocomplete="off">
                                        <br>
                                        <input type='text' name='tel' class="form-control form-control" placeholder="Telefone" autocomplete="off">
                                        <br>
                                        <input type='text' name='email' class="form-control form-control" placeholder="E-MAIL" autocomplete="off">
                                        <br>
                                        <input type='text' name='cidade' class="form-control form-control" placeholder="Cidade" autocomplete="off">
                                        <br>
                                        <input type='text' name='estado' class="form-control form-control" placeholder="Estado" autocomplete="off">
                                        <br>
                                        <input type='submit' class='btn btn-success'>
                                    </form>
                                    
                                </div>                                  
                            </div>
                            <!-- Modal footer -->
                            <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                        </div>   
                    </div>
                    </div>
                </div>
            </li>          
        </ul>   
    </div>
</div>   
<div class='row'>  
        <div class="col-md-6">
            <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaRamais.php" >Gerar XLS</a> 
            <a  class="btn btn-info" href="../_funcoes/gerarPDFRamais.php" target='_blank'>Gerar PDF</a>
        </div> 
    <div class='col' style='border:solid #000 1px'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                    <input type='search' name='buscaNome' class="form-control form-control" placeholder="Nome" autocomplete="off" required >
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>
    </div>    
</div>
<div class='row'>
    <div class="col" style="padding: 0;">
        <?php 
            if(isset($_POST["buscaNome"])){
                $nome = $_POST['buscaNome'];
                ramais($nome);
            }else{
                $nome = "default";
                ramais($nome);
            }
        ?>
    </div> 
</div>
<?php 
//Captura os dados para realizar cadastro
    if(isset($_POST['nome'])){
        $nome = $_POST["nome"];
        $tel = $_POST["tel"];
        $ramal = $_POST["ramal"];
        $email = $_POST["email"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        
        echo cadastraRamal($nome, $tel,$ramal,$email, $cidade,$estado);
        
    }

   
?>     
<?php
//Captura os dados para atualizar o Ativo      
    if(isset($_POST['idramal'])){
            $IDRamal = $_POST["idramal"];
            $nome = $_POST["NomeA"];
            $tel = $_POST["TelA"];
            $ramal = $_POST["RamalA"];
            $email = $_POST["EmailA"];
            $cidade = $_POST["CidadeA"];
            $estado = $_POST["EstadoA"];
            /*echo  $IDCOMPUTADOR." ".$numero." ".$filial." ".$memoria." ".$processador." ".$modelo." ".$marca." ".$status." ".$responsavel."  ".$obs." ".$data." ".$dominio." ".$usuario." ".$nome_pc." ".$SO." ". $tipo." ".$licencaWin;*/
                echo atualizaRamal($IDRamal,$nome, $tel,$ramal,$email,$cidade, $estado);
        }
//Deleta  o Ativo 
        if(isset($_POST['idramalD'])){
            $IDRAMAL= $_POST["idramalD"];
            echo deletaRamal($IDRAMAL);
            
        }
?>        
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>