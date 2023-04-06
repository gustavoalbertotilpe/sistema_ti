<?php
    include('../_funcoes/funcoes2.php');
?>
<div class='row'>
    <div class='col menuAtivos'>
        <ul>
            <li><a href="?url=computador">Voltar</a></li> 
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
                                                    <?php listarNumeroInvantario();?>
                                                    <label for='idTipoManutencao'>Tipo Manutenção: </label>
                                                    <select id='idTipoManutencao'  name='tipoM' class="form-control">
                                                        <option>---Tipo---</option>
                                                        <option  value='PREVENTIVA'>Preventiva</option>
                                                        <option value='CORRETIVA'>Corretiva</option>
                                                    </select>
                                                    <br>
                                                    <label for='idData'>Data da Manutenção: </label>
                                                    <input id='idData' name='dataM' class="form-control" type='date'>
                                                    <br>
                                                    <label for='idDescricao'>Descrição do problema</label>
                                                    <textarea id='idDescricao'  name='descricao' class="form-control" required></textarea>
                                                    <br>
                                                    <label for='idProcediemento'>Procedimento</label>
                                                    <textarea id='idProcediemento' name='procedimento'class="form-control" ></textarea>
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
                           </div></li>

        </ul>   
    </div>   
</div>
<div class='row'>  
    <div class="col">
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaManutencao.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFManutecao.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class='col'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                    <br>
                    <input type='search' name='busca' class="form-control form-control" placeholder='Buscar por Numero Inventario ' autocomplete="off" >
                    <br>
                    <label for='idTipo'>TIPO Manutenção:</label>
                    <select id='idTipo' name='tipo'>
                        <option >------</option>
                        <option value='MANUTENÇÃO PREVENTIVA'>PREVENTIVA</option>
                        <option value='MANUTENÇÃO CORRETIVA'>CORRETIVA</option>
                    </select>
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>    
    </div> 
</div> 
<div class='row'>
  <div class="col" style="padding: 0;">
    <?php
         if(isset($_POST["numeroAtivo"])){
            $numeroAtivo = $_POST["numeroAtivo"];
            $tipoM = $_POST["tipoM"];
            $dataM = $_POST["dataM"];
            $descricao = $_POST["descricao"];
            $procedimento = $_POST["procedimento"];
            echo cadastraM($numeroAtivo,$tipoM,$dataM,$descricao,$procedimento);
        }
   //Chama função para exibir a tabela de manutenção
   
        if(isset($_POST["busca"])){
            $busca = $_POST["busca"];
            $tipo = $_POST['tipo'];
            echo manutencao($busca,$tipo);
        }else{
            $busca ='default';
            $tipo ='default';
            echo manutencao($busca,$tipo);
        }

        if(isset($_POST["idmanutencao"])){
            $id = $_POST["idmanutencao"];
            $DataA = $_POST["DataA"];
            $DescricaoA = $_POST["DescricaoA"];
            $ProcedimentoA = $_POST["ProcedimentoA"];
            $ObsA = $_POST["ObsA"];
            echo atualizaM($id,$DataA,$DescricaoA,$ProcedimentoA,$ObsA);
        }   
        if(isset($_POST['idManutencaoD'])){
            $IDMANUTENCAO = $_POST["idManutencaoD"];
            echo deletaD($IDMANUTENCAO);
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