<?php
    include('../_funcoes/funcoes2.php');

    if(isset($_POST["seguradora"]) && empty($_POST["seguradora"])==false)
    {
        $seguradora = $_POST["seguradora"];
        $url = $_POST["url"];
        $login = $_POST["login"];
        $senha= $_POST["senha"];
        $obs = $_POST["obs"];
        $tipo = $_POST["tipo"];
        $categoria = $_POST["categoria"];

        echo cadastraSenha($seguradora,$url,$login,$senha,$obs,$tipo,$categoria);
        
    }
    if(isset($_POST["SeguradoraA"])&&empty($_POST["SeguradoraA"])==FALSE)
    {
        echo atualizaSenha($_POST["id"],$_POST["SeguradoraA"],$_POST["UrlA"],$_POST["LoginA"],$_POST["SenhaA"],$_POST["obs"]);
    }
    if(isset($_POST["idD"]) && empty($_POST["idD"])==false)
    {
        $sql = $pdo->prepare("DELETE FROM SENHAS_SEGURADORAS WHERE ID_SENHAS =?");
        if($sql->execute(array($_POST["idD"])))
        {
            echo"<script>alert('Senha deletada com sucesso!')</script>";
        }
    }
    if(isset($_POST["categoriapdf"]) && empty($_POST["categoriapdf"]) == false)
    {
        echo "<script>window.open('../_funcoes/gerarPDFSenhaSeguradora.php?categoria=".$_POST["categoriapdf"]."', '_blank');</script>";
    }
    if(isset($_POST["categoriaXLS"]) && empty($_POST["categoriaXLS"]) == false)
    {
        echo "<script>window.open('../_funcoes/gerarPlanilhaSenhaSeguradora.php?categoria=".$_POST["categoriaXLS"]."', '_blank');</script>";
    }
?>
<div class='row'>
    <div class='col menuAtivos'>
        <ul>
            <li><a href="?url=default">Voltar</a></li>    
            <li>
            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalCadastrar'>+ SENHA</button>
                            <div class= 'modal fade' id='myModalCadastrar'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                        <h4 class='modal-title'>CADASTRAR NOVA SENHA</h4>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <div>
                                                <form class="form-group" action='' method='POST'>
                                                    <input type='text' name='seguradora' class='form-control' placeholder="NOME">
                                                    <br>
                                                    <input type='text' name='url' class='form-control' placeholder="URL">
                                                    <br>
                                                    <input type='text' name='login' class='form-control' placeholder="LOGIN">
                                                    <br>
                                                    <input type='text' name='senha' class='form-control' placeholder="SENHA">
                                                    <br>
                                                    <label>TIPO DE ACESSO:
                                                        <br>
                                                        <br>
                                                        <select name='tipo' class='form-control'>
                                                            <option value="ADM">ADM</option>
                                                            <option value="COMUM">COMUM</option>
                                                        </select>
                                                    </label>    
                                                    <br>
                                                    <br>
                                                    <label>CATEGORIA:
                                                        <br>
                                                        <br>
                                                        <select name='categoria' class='form-control'>
                                                            <option value="TI">TI</option>
                                                            <option value="SEGURADORA">SEGURADORA</option>
                                                        </select>
                                                    </label>    
                                                    <br>
                                                    <br>
                                                    <textarea name='obs' class='form-control' placeholder="OBS"></textarea>
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
    <div class="col">
    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalPDFSenha'>Gerar PDF</button>
        <div class= 'modal fade' id='myModalPDFSenha'>
            <div class='modal-dialog modal-xl'>
                <div class='modal-content'>
                    <div class='modal-header'>
                    <h4 class='modal-title'>Gerar PDF</h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>
                        <div>
                            <form class="form-group" action='' method='POST'>
                                <label>CATEGORIA:
                                    <br>
                                    <br>
                                    <select name='categoriapdf' class='form-control'>
                                        <option value="TI">TI</option>
                                        <option value="SEGURADORA">SEGURADORA</option>
                                    </select>
                                </label>    
                                <br/>
                                <br/>
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

        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalXLSSenha'>Gerar XLS</button>
        <div class= 'modal fade' id='myModalXLSSenha'>
            <div class='modal-dialog modal-xl'>
                <div class='modal-content'>
                    <div class='modal-header'>
                    <h4 class='modal-title'>Gerar XLS</h4>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>
                        <div>
                            <form class="form-group" action='' method='POST'>
                                <label>CATEGORIA:
                                    <br>
                                    <br>
                                    <select name='categoriaXLS' class='form-control'>
                                        <option value="TI">TI</option>
                                        <option value="SEGURADORA">SEGURADORA</option>
                                    </select>
                                </label>    
                                <br/>
                                <br/>
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
    </div>
    <div class='col'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                        <input type='search' name='busca' class='form-control' placeholder="Buscar...">
                    <br>
                    <br>
                    Categoria
                    <br>
                    <label>TI <input type='radio' name='categoriaB' value='TI'></label>
                    <label>SEGURADORA <input type='radio' name='categoriaB' value = 'SEGURADORA'></label>
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>    
    </div> 
</div>  
<div class="row">
   <div class="col" style="padding: 0;">
    <?php
           
        if(isset($_POST["busca"]) && empty($_POST["busca"])==false || isset($_POST["categoriaB"]) && empty($_POST["categoriaB"])==false){
            $busca= $_POST["busca"];
            if(empty($_POST["categoriaB"])==false)
            {
               $categoria = $_POST["categoriaB"];
             
            }
            else{
               $categoria = '';
            }
           
            echo senhaSeguradora($busca,$categoria);
        }else{
            $busca ='';
            $categoria= '';
            echo senhaSeguradora($busca,$categoria);
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
 