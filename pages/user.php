<?php
    include('../_funcoes/funcoes2.php');
?>
<div class='row'>
    <div class ='col'>
      <h1>Atualizar Dados</h1>
        <?php
          user($IDUSUARIO);
        ?> 
     </div> 
     <div class='col'>
      <h1>Atualizar Senha</h1>
        <form form-group action='' method='POST'>
                    <label for='idsenha'>Nova Senha</label>
                    <input id='idsenha' type='password' name='senha' class='form-control form-control' required>
                    <br>
                    <label for='idConfirme'>Confirma Senha</label>
                    <input id='idConfirme' type='password' name='confirmeSenha'  class='form-control form-control'>
                    <br>
                    <input type='submit' class='btn btn-success' value='Atualizar'> 
          </form>
     </div> 
</div>     
     <?php
    if(isset($_POST['nome'])){
      $nome = $_POST["nome"];
      $username = $_POST["username"];
      $email = $_POST["email"];
      $ID = $IDUSUARIO;
      echo atualizaDadosUser($nome,$username,$email,$ID);
    }
    if(isset($_POST["senha"])){
        $senha = md5($_POST["senha"]);
        $confirm =md5($_POST["confirmeSenha"]);
        $ID = $IDUSUARIO;
        if($senha ==  $confirm ){
          
          echo atualizaSenhaUser($senha,$ID);
        }else{
          echo"Senhas não combinam tente novamente!";
        }
    }
 ?>       
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>