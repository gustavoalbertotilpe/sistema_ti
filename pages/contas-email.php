<?php
    include('../_funcoes/funcoes2.php');

    if(isset($_POST["nome"]) && empty($_POST["nome"])==false)
    {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        echo cadastraEmail($nome,$email,$senha);
        
    }
    if(isset($_POST["nomeAlterar"])&&empty($_POST["nomeAlterar"])==FALSE)
    {
        echo atualizaEmail($_POST["id"],$_POST["nomeAlterar"],$_POST["emailAlterar"],$_POST["senhaAlterar"]);
    }
    if(isset($_POST["idD"]) && empty($_POST["idD"])==false)
    {
        deletaEmail($_POST["idD"]);
    }
    if(isset($_POST["pdf"]) && empty($_POST["pdf"]) == false)
    {
        echo "<script>window.open('../_funcoes/gerarPDFEmail.php? '_blank');</script>";
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
            <button type='button' class='btn btn-success' data-toggle='modal' data-target='#myModalCadastrar'>+ EMAIL</button>
                            <div class= 'modal fade' id='myModalCadastrar'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                        <h4 class='modal-title'>CADASTRAR NOVO E-MAIL</h4>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        </div>
                                        <div class='modal-body'>
                                            <div>
                                                <form class="form-group" action='' method='POST'>
                                                    <input type='text' name='nome' class='form-control' placeholder="NOME">
                                                    <br>
                                                    <input type='text' name='email' class='form-control' placeholder="E-MAIL">
                                                    <br>
                                                    <input type='text' name='senha' class='form-control' placeholder="SENHA">
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

       <a href='../_funcoes/pdf-email.php' class="btn btn-primary" download>GERAR PDF</a>
       <a href='../_funcoes/planilha-email.php' class="btn btn-primary" download>GERAR PLANILHA</a>

    </div>  

    <div class='col'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                        <input type='search' name='busca' class='form-control' placeholder="Buscar...">
                    <br>
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
            echo contaEmail($busca,);
        }else{
            $busca ='default';
            echo contaEmail($busca);
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
 