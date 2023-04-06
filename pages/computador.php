<?php
    
    $deskAtivoQuantidade = QuantidadeDeskAtivo2();
    $deskQuantidade = QuantidadeDesk2();
    $deskParado = QuantidadeDeskParado2();
    $deskEstragodo = QuantidadeDeskEstragado2();
    $filial =  exibirFilialAtivos();
?>    
<div class='row'>
    <div class='col menuAtivos'>
        <ul>
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
                                                    <input type='text' name='numeroAtivo' class="form-control form-control" placeholder="Numero Ativo" autocomplete="off" required >
                                                    <br>
                                                    <input type='text' name='responsavel' class="form-control form-control" placeholder="Responsavel" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='tipo' class="form-control form-control" placeholder="Tipo" autocomplete="off" required>
                                                    <br> 
                                                    <input type='text' name='processador' class="form-control form-control" placeholder="Processador" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='memoria' class="form-control form-control" placeholder="Memoria"  autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='modelo' class="form-control form-control" placeholder="Modelo"  autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='marca' class="form-control form-control" placeholder="Marca" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='SO' class="form-control form-control" placeholder="Sistema Operacional" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='licencaWindows' class="form-control form-control" placeholder="Licença Windows" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='dominio' class="form-control form-control" placeholder="Dominio"  autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='nomePC' class="form-control form-control" placeholder="Nome do PC" autocomplete="off" required>
                                                    <br>
                                                    <input type='text' name='usuario' class="form-control form-control" placeholder="Usuario" autocomplete="off" required>
                                                    <br>
                                                    <select name='status' id='cidadeID' class='form-control' >
                                                            <option >---Status---</option>
                                                            <option  value= 'EM USO' >ATIVO</option>
                                                            <option  value= 'AGUARDANDO USO'>PARADO</option>
                                                            <option  value= 'ESTRAGADO' >ESTRAGADO</option>
                                                    </select>
                                                    <br>
                                                    <p>Data da Compra:</p>
                                                    <input type='date' name='data' class="form-control form-control">
                                                    <br>
                                                        <p>Filial:</p>
                                                        <?php echo $filial;?>
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
                            </div></li>
                    <li><a href='https://www.microsoft.com/Licensing/servicecenter/default.aspx' target='_blank' >Licença Windows</a></li>
                    <li><a href='?url=manutencao'>Manutenção</a></li>
                    <li><a href="?url=default">Voltar</a></li> 
        </ul>   
    </div>  
</div>     
<div class='row'>  
    <div class="col">
        <h1>Quantidade de Ativos</h1>
        <h2>Total de Computadores: <?php echo $deskQuantidade;?></h2>
        <h3 class='green'>Computadores Ativo: <?php echo $deskAtivoQuantidade;?></h3>
        <h3 class='yellow'>Computadores Parado: <?php echo $deskParado;?></h3>
        <h3 class='red'>Computadores Estragado: <?php echo $deskEstragodo;?></h3>  
    </div>
    <div class="col">
        <h1>Quantidade de Ativos com Licença Microsoft</h1>
            <?php
                quantidadeLicencaWin();
            ?>
    </div>    
</div> 
<div style="height: 80px;"></div>
<div class='row'>
    <div  class='col-sm-12 col-md-6'>
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaAtivosComputador.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFAtivosComputador.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class='col-sm-12 col-md-6' style="border: 1px solid #000;">
        <form class="form-group" method='POST' action='' >
            <fieldset>
                <legend>Filtro</legend>
                <br>
                <input type='search' name='buscaResponsavel' class="form-control form-control" placeholder='Buscar por Responsavel' autocomplete="off" >
                <br>
                <p>Filial:</p>
                <?php echo $filial;?>
                <br>
                <label for='idStatus'>Status:</label>
                <select id='idStatus' name='status'>
                    <option value='default'>----</option>
                    <option value='EM USO'>Ativo</option>
                    <option value='AGUARDANDO USO'>Parado</option>
                    <option value='ESTRAGADO'>Estragado</option>
                </select>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                <label for='idLWindows'>Licença Windows: </label>
                <select id='idLWindows' name='LWindows'>
                    <option value='default'>----</option>
                    <option value='SEMLICENCA'>Sem a Licença</option>
                    <option value='COMLICENCA'>Com a Licença</option>
                </select>
                <br>
                <br>
                <button type='submit' class='btn btn-success'>Buscar</button>
            </fieldset>
        </form>
    </div>
</div>  
<div class="row">
    <div class="col"  style="padding: 0;">  
        <?php 
            if(isset($_POST["buscaResponsavel"])){
                $res = $_POST["buscaResponsavel"];
                $filial = $_POST['cidade'];
                $status = $_POST['status'];
                $licencaWin = $_POST['LWindows'];
                AtivosComputador($res,$filial,$status,$licencaWin);
            }else{
                $res ='default';
                $filial ='default';
                $status ='default';
                $LicencaWin ='default';
                AtivosComputador($res,$filial,$status,$LicencaWin);
            }
        ?> 
    </div>
</div>    

<?php 
    if(isset($_POST['numeroAtivo'])){

        $numero = $_POST["numeroAtivo"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $status = $_POST["status"];
        $filial = $_POST["cidade"];
        $dominio = $_POST["dominio"];
        $processador =$_POST["processador"];
        $memoria = $_POST["memoria"];
        $SO = $_POST["SO"];
        $nome_pc =$_POST["nomePC"];
        $usuario = $_POST["usuario"];
        $responsavel = $_POST["responsavel"];
        $data = $_POST["data"];
        $tipo = $_POST["tipo"];
        $obs = $_POST["obs"];
        $licencaWin= $_POST["licencaWindows"];


       if($_FILES['foto']['size'] != 0){
            $target_dir = "../_img/_computadores/";
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
                    echo "Já existe uma foto com o mesmo nome! Tente outra vez.";
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
                    echo "Desculpe o seu arquivo não foi enviado.";
            // if everything is ok, try to upload file
            } else {
                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                            echo "The file ". basename( $_FILES["foto"]["name"]). " has been uploaded.";
                    } else {
                            echo "Desculpe ouve um erro ao enviar o seu arquivo.";
                    }
            }
                $foto = $_FILES["foto"];
                //Captura o nome da foto;
                $img = $foto["name"];
                echo cadastraComputador($numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin);
        }else{    
                $img = "padrao.jpg";     
                echo cadastraComputador($numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin);
        }
    }

   
?>     
<?php
      
    if(isset($_POST['NumeroAtivoA'])){
            $IDCOMPUTADOR = $_POST["idComputador"];
            $numero = $_POST["NumeroAtivoA"];
            $marca = $_POST["MarcaA"];
            $modelo = $_POST["ModeloA"];
            $status = $_POST["StatusA"];
            $filial = $_POST["CidadeA"];
            $dominio = $_POST["DominioA"];
            $processador =$_POST["ProcessadorA"];
            $memoria = $_POST["MemoriaA"];
            $SO = $_POST["SOA"];
            $nome_pc =$_POST["NomePCA"];
            $licencaWin = $_POST["LicençaWindowsA"];
            $usuario = $_POST["UsuarioA"];
            $responsavel = $_POST["ResponsavelA"];
            $data = $_POST["DataA"];
            $tipo = $_POST["TipoA"];
            $obs = $_POST["obsA"];
            /*echo  $IDCOMPUTADOR." ".$numero." ".$filial." ".$memoria." ".$processador." ".$modelo." ".$marca." ".$status." ".$responsavel."  ".$obs." ".$data." ".$dominio." ".$usuario." ".$nome_pc." ".$SO." ". $tipo." ".$licencaWin;*/

         if($_FILES['FotoA']['size'] != 0){
                $target_dir = "../_img/_computadores/";
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
                $IDCOMPUTADOR = $_POST["idComputador"];
                $foto = $_FILES["FotoA"];
                $img = $foto["name"];
                echo atulizaDadosComputador($IDCOMPUTADOR,$numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin);
            }else{
                $img = " ";
                echo atulizaDadosComputador($IDCOMPUTADOR,$numero, $filial, $memoria, $processador, $modelo,$marca, $status, $responsavel, $img, $obs, $data, $dominio, $usuario, $nome_pc, $SO, $tipo,$licencaWin);
            }  
           
        }

        if(isset($_POST['idComputadorD'])){
            $IDCOMPUTADOR = $_POST["idComputadorD"];
            echo deletaComputador($IDCOMPUTADOR);
        }
?>        
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>