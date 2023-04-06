<?php
    include('../_funcoes/funcoes2.php');
    $data = date("Y-m-d");
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
                                    <form class="form-group" action='' method='POST'>
                                        <label for='idData'>Data da Abertura</label>
                                        <input class="form-control" type='date' id='idData' name='data' value='<?php echo $data;?>'>
                                        <br>
                                        <label for='idSolicitante'>Solicitante</label>
                                        <input id='idSolicitante' name='solicitante' type='text' class="form-control">
                                        <br>
                                        <label for='idTitulo'>Titulo</label>
                                        <input id='idTitulo' name='titulo' type='text' class="form-control">
                                        <br>
                                        <label for='idSolicitacao'>Solicitação</label>
                                        <textarea id='idSolicitacao' name='solicitacao' class="form-control"></textarea>
                                        <br>
                                        <label for='idPrioridade'>Prioridade</label>
                                        <select id='idPrioridade' name='prioridade' class="form-control">
                                            <option>-------</option>
                                            <option value='ALTA'>Alta</option>
                                            <option value='MEDIA'>Media</option>
                                            <option value='BAIXA'>Baixa</option>
                                        </select>    
                                        <label for='idStatus'>Status</label>
                                        <select id='idStatus' name='status' class="form-control">
                                            <option value='ABERTO'>Aberto</option>
                                        </select>    
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
<div class='ROW'>  
    <div class="col">
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaChamado.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFChamado.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class='col' style='border:solid #000 1px'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                    <br>
                    <input type='search' name='busca' class="form-control form-control" placeholder='Titulo do Chamado' autocomplete="off" >
                    <br>
                    <br>
                    <label for='idStatus'>Status:</label>
                    <select id='idStatus' name='status'>
                        <option >------</option>
                        <option value='ABERTO'>Aberto</option>
                        <option value='FECHADO'>Fechado</option>
                    </select>
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form> 
    </div> 
</div>
<div class='row'>
    <div class="col"  style="padding: 0;">
    <?php
         if(isset($_POST["data"])){
            $data = $_POST["data"];
            $titulo = $_POST["titulo"];
            $solicitante = $_POST["solicitante"];
            $solicitacao = $_POST["solicitacao"];
            $prioridade = $_POST["prioridade"];
            $status =$_POST["status"];
            echo cadastraChamado($data,$titulo,$solicitante,$solicitacao,$prioridade,$status);
        }
   //Chama função para exibir a tabela de manutenção
   
        if(isset($_POST["busca"])){
            $busca = $_POST["busca"];
            $status = $_POST['status'];
            echo chamado($busca,$status);
        }else{
            $busca ='default';
            $status ='default';
            echo chamado($busca,$status);
        }

        if(isset($_POST["idchamado"])){
            $id = $_POST["idchamado"];
            $solicitante = $_POST["SolicitanteA"];
            $titulo = $_POST["TituloA"];
            $prioridade = $_POST["PrioridadeA"];
            $status = $_POST["StatusA"];
            $solicitacao = $_POST["SolicitacaoA"];
            $resolucao = $_POST['ResolucaoA'];
            $obs = $_POST['OBSA'];
            $dataFechamamento = $_POST['DatafechamentoA'];
            echo AtualizaChamado($id,$solicitante,$titulo,$prioridade,$solicitacao,$resolucao,$obs,$dataFechamamento,$status);
        }   
        if(isset($_POST['idChamadoD'])){
            $IDCHAMADO = $_POST["idChamadoD"];
            echo deletaChamado($IDCHAMADO);
        }
        ?>
    </div>  
</div>
 
       
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>