<?php
    include('../_funcoes/funcoes2.php');
    include('../_funcoes/class.php');
    $consulta = new ConsultaComprador();

    if(isset($_POST["nomeComprador"]) && empty($_POST["nomeComprador"])==false)
    {
        $nomeComprador = $_POST["nomeComprador"];
        $idComprador = $_POST["idComprador"];
        $emailComprador = $_POST["emailComprador"];
        $consulta->setComprador($idComprador,$nomeComprador,$emailComprador);
    }
?>
<div class='ativos'>
    <div class='menuAtivos'>
        <ul>
        
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    COMPRAS
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="novasolicitacao.php">SOLICITAÇÃO COMPRAS MADALOZZO</a>
                    <a class="dropdown-item" href="novasolicitacaotoner.php">SOLICITAÇÃO COMPRAS TONER</a>
                </div>
            </li>   



         <li>
            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalCadastrar'>ALTERAR COMPRADOR</button>
                            <div class= 'modal fade' id='myModalCadastrar'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                        <h4 class='modal-title'>COMPRADOR ALTERAÇÃO</h4>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <div>
                                                <form class="form-group" action='' method='POST'>
                                                    <input id='idComprador' name='idComprador' class="form-control" type='hidden' value="<?php echo $consulta->getIDCompras();?>">
                                                    <br>
                                                    <input class="form-control" name='nomeComprador' value="<?php echo $consulta->getNomeComprador();?>">
                                                    <br>
                                                    <input class="form-control" name='emailComprador' value="<?php echo $consulta->getEmailComprador();?>">
                                                    <br>
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
            <li><a href="?url=default">Voltar</a></li>              
        </ul>   
    </div>   
    <div class='AtivosRelatorio'>  
        <div class="d-flex ">
            <div class="p-1 flex-fill">
                <div class='white' style='border:solid 1px #000; width:500px'>
                    <p>Solicitação de compra de equipamentos de informatica</p>
                </div>    
        </div>
    </div> 
    <div class='filtroAtivos' style='border:solid #000 1px'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                   
                    <label for='idTipo'>Status:</label>
                    <select id='idTipo' name='busca'>
                        <option >------</option>
                        <option value='0'>NÃO RECEBIDO</option>
                        <option value='1'>RECEBIDO</option>
                    </select>
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>
           
    </div> 
    
    <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaSoliciataca.php" >Gerar XLS</a> 
    <a  class="btn btn-info" href="../_funcoes/gerarPDFSolicitacao.php" target='_blank'>Gerar PDF</a>
    <div class='mainAtivo'>
    <?php
         
   //Chama função para exibir a tabela de manutenção
   
        if(isset($_POST["busca"])){
            $status= $_POST["busca"];
            echo mostrarSolicitacao($status);
        }else{
            $status ='default';
            echo mostrarSolicitacao($status);
        }

    
     

        if(isset($_POST['idSolicitacaoFecha'])){
            $ID = $_POST["idSolicitacaoFecha"];
            echo fechaSolicitacao($ID);
        }
        ?>
    </div> 
   
    <?php 
        include("rodape.php");
    ?>    
</div>
 
       
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>
 