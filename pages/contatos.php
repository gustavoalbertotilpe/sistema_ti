<?php
    $filial =  exibirFilialAtivos();
    include('../_funcoes/funcoes2.php');
?>    
<div class='row'>
    <div class='col menuAtivos' >
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
                                        <input type='text' name='tel' class="form-control form-control" placeholder="Telefone" autocomplete="off">
                                        <br>
                                        <input type='text' name='email' class="form-control form-control" placeholder="E-mail"  autocomplete="off" >
                                        <br>
                                        <label for="comment">OBS:</label>
                                        <textarea name='obs' class="form-control" rows="5" id="comment"></textarea>
                                        <br>
                                        <p>Foto</p>
                                        <div class="custom-file mb-3">
                                            <input name='foto' type="file" class="custom-file-input" id="customFile" name="filename">
                                            <label class="custom-file-label" for="customFile">Selecione o Arquivo</label>
                                        </div>
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
    <div class='col-md-6'>
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaContatos.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFContatos.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class='col-md-6' style='border:solid #000 1px'>
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
     <div class="col"  style="padding: 0;">
        <?php 
            if(isset($_POST["buscaNome"])){
                $nome = $_POST['buscaNome'];
                contatos($nome);
            }else{
                $nome = "default";
                contatos($nome);
            }
        ?>
      </div>
</div> 
    
<?php 
//Captura os dados para realizar cadastro
    if(isset($_POST['nome'])){
        $nome = $_POST["nome"];
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $obs = $_POST["obs"];
       if($_FILES['foto']['size'] != 0){
            $target_dir = "../_img/_contatos/";
            $target_file = $target_dir . basename($_FILES["foto"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
                    $check = getimagesize($_FILES["foto"]["tmp_name"]);
                    if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                    } else {
                            echo "Não é uma foto.";
                            $uploadOk = 0;
                    }
        
            // Check if file already exists
            if (file_exists($target_file)) {
                   
                    $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                    echo "Não é dos formatdos JPG, JPEG, PNG & GIF. Tente de novo";
                    $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                 
            // if everything is ok, try to upload file
            } else {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                            
                    } else {
                            
                    }
            }
                $foto = $_FILES["foto"];
                //Captura o nome da foto;
                $img = $foto["name"];
                echo cadastracaontato($nome, $tel,$email,$obs, $img);
        }else{    
                $img = "padrao.jpg";     
                echo cadastracaontato($nome, $tel,$email,$obs, $img);
        }
    }

   
?>     
<?php
//Captura os dados para atualizar o Ativo      
    if(isset($_POST['idcontato'])){
            $IDContato = $_POST["idcontato"];
            $nome = $_POST["NomeA"];
            $tel = $_POST["TelA"];
            $email = $_POST["EmailA"];
            $obs = $_POST["obsA"];
            /*echo  $IDCOMPUTADOR." ".$numero." ".$filial." ".$memoria." ".$processador." ".$modelo." ".$marca." ".$status." ".$responsavel."  ".$obs." ".$data." ".$dominio." ".$usuario." ".$nome_pc." ".$SO." ". $tipo." ".$licencaWin;*/

         if($_FILES['FotoA']['size'] != 0){
                $target_dir = "../_img/_contatos/";
                $target_file = $target_dir . basename($_FILES["FotoA"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                
                        $check = getimagesize($_FILES["FotoA"]["tmp_name"]);
                        if($check !== false) {
                                
                                $uploadOk = 1;
                        } else {
                                echo "Não é uma foto.";
                                $uploadOk = 0;
                        }
            
                // Check if file already exists
                if (file_exists($target_file)) {
                        
                        $uploadOk = 0;
                }
                
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                        echo "Não é dos formatdos JPG, JPEG, PNG & GIF. Tente de novo";
                        $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                       
                // if everything is ok, try to upload file
                } else {
                        if (move_uploaded_file($_FILES["FotoA"]["tmp_name"], $target_file)) {
                              
                        } else {
                             
                        }
                }
                $IDContato = $_POST["idcontato"];
                $foto = $_FILES["FotoA"];
                $img = $foto["name"];
                echo atualizaContatos($IDContato,$nome, $tel,$email,$obs, $img);
            }else{
                $img = "default";
                echo atualizaContatos($IDContato,$nome, $tel,$email,$obs, $img);
            }  
           
        }
//Deleta  o Ativo 
        if(isset($_POST['idcontatoD'])){
            $IDCONTATO= $_POST["idcontatoD"];
            echo deletaContato($IDCONTATO);
        }
?>        
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>