<?php
    include('../_funcoes/funcoes2.php');
    $data = date("Y-m-d");
?>
<div class='row ativos'>
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
                                            <label for='idNome'>Nome</label>
                                            <input id='idTitulo' name='nome' type='text' class="form-control" autocomplete="off">
                                            <br>
                                            <label for='idusername'>Username</label>
                                            <input id='idusername' name='username' type='text' class="form-control" autocomplete="off">
                                            <br>
                                            <label for='idemail'>E-mail</label>
                                            <input id='idemail' name='email' type='text' class="form-control" autocomplete="off">
                                            <br>
                                            <label for='idsenha'>Senha</label>
                                            <input id='idsenha' name='senha' type='text' class="form-control" autocomplete="off">
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
<div class="row">
    <div class="col-md-6"></div>
    <div class='col-md-6' style='border:solid #000 1px'>
            <form class="form-group" method='POST' action='' >
                <fieldset>
                    <legend>Filtro</legend>
                    <br>
                    <input type='text' name='busca' class="form-control form-control" placeholder='Nome' autocomplete="off" >
                    <br>
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>
    </div> 
</div>
<div class='row'>
    <div class="col" style="padding: 0;">
        <?php
            if(isset($_POST["nome"])){
                $nome = $_POST["nome"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $senha = md5($_POST["senha"]);
                echo cadastraUsuarios($nome,$username,$email,$senha);
            }
    //Chama função para exibir a tabela de manutenção
    
            if(isset($_POST["busca"])){
                $busca = $_POST["busca"];
                $ID = $IDUSUARIO;
                echo usuarios($busca,$IDUSUARIO);
            }else{
                $nome ='default';
                $ID = $IDUSUARIO;
                echo usuarios($nome,$IDUSUARIO);
            }

            if(isset($_POST["idusuario"])){
                $id = $_POST["idusuario"];
                $nome = $_POST["NomeA"];
                $username = $_POST["UsernameA"];
                $email = $_POST["EmailA"];
                $senha = md5($_POST["SenhaA"]);
                echo AtualizaUsuairo($id,$nome,$username,$email,$senha);
            }   
            if(isset($_POST['idUsuarioD'])){
                $ID = $_POST["idUsuarioD"];
                echo deletaUsuario($ID);
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