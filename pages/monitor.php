<?php   
    $monitorAtivoQuantidade = QuantidadeMonitor();
    $monitorQuantidade = QuantidadeMonitorAtivo();
    $monitorParado = QuantidadeMonitorParado();
    $monitorEstragodo = QuantidadeMonitorEstradago();
    $filial =  exibirFilialAtivos();
?>    
<div class='row ativos'>
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
                                            <input type='text' name='modelo' class="form-control form-control" placeholder="Modelo"  autocomplete="off" required>
                                            <br>
                                            <input type='text' name='marca' class="form-control form-control" placeholder="Marca" autocomplete="off" required>
                                            <br>
                                            <input type='text' name='polegada' class="form-control form-control" placeholder="Polegada" autocomplete="off" required>
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
            <li><a href="?url=default">Voltar</a></li> 
        </ul> 
   </div>     
</div>
<div class='row'>  
    <div class="col">
            <h1>Quantidade de Ativos</h1>
            <h2>Total de Monitor: <?php echo $monitorAtivoQuantidade;?></h2>
            <h3 class='green'>Monitor Ativo: <?php echo $monitorQuantidade;?></h3>
            <h3 class='yellow'>Monitor Parado: <?php echo $monitorParado;?></h3>
            <h3 class='red'>Monitor Estragado: <?php echo $monitorEstragodo;?></h3>
    </div>    
</div>
<div style="height: 80px;"></div>
<div class="row"> 
    <div class="col">
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaAtivosmonitor.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFAtivosMonitor.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class="col" style='border:solid #000 1px'>
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
                    <br>
                    <button type='submit' class='btn btn-success'>Buscar</button>
                </fieldset>
            </form>
    </div>  
</div>  
<div class='row'>
    <div class="col" style="padding: 0;">
        <?php 
            if(isset($_POST["buscaResponsavel"])){
                $res = $_POST["buscaResponsavel"];
                $filial = $_POST['cidade'];
                $status = $_POST['status'];
                AtivosMonitor($res,$filial,$status);
            }else{
                $res ='default';
                $filial ='default';
                $status ='default';
                AtivosMonitor($res,$filial,$status);
            }
        ?>
    </div>    
</div>

<?php 
//Captura os dados para realizar cadastro
    if(isset($_POST['numeroAtivo'])){
        $numero = $_POST["numeroAtivo"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $responsavel = $_POST["responsavel"];
        $polegada = $_POST["polegada"];
        $status = $_POST["status"];
        $filial = $_POST["cidade"];
        $data = $_POST["data"];
        $obs = $_POST["obs"];
       if($_FILES['foto']['size'] != 0){
            $target_dir = "../_img/_monitores/";
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
                echo cadastraMonitor($numero, $filial,$modelo,$marca,$polegada,$status, $responsavel, $img, $obs, $data);
        }else{    
                $img = "padrao.jpg";     
                echo cadastraMonitor($numero, $filial,$modelo,$marca,$polegada,$status, $responsavel, $img, $obs, $data);
        }
    }

   
?>     
<?php
//Captura os dados para atualizar o Ativo      
    if(isset($_POST['NumeroAtivoA'])){
            $IDMonitor = $_POST["idmonitor"];
            $numero = $_POST["NumeroAtivoA"];
            $marca = $_POST["MarcaA"];
            $modelo = $_POST["ModeloA"];
            $polegada =$_POST['PolegadaA'];
            $status = $_POST["StatusA"];
            $filial = $_POST["CidadeA"];
            $responsavel = $_POST["ResponsavelA"];
            $data = $_POST["DataA"];
            $tipo = $_POST["TipoA"];
            $obs = $_POST["obsA"];
            /*echo  $IDCOMPUTADOR." ".$numero." ".$filial." ".$memoria." ".$processador." ".$modelo." ".$marca." ".$status." ".$responsavel."  ".$obs." ".$data." ".$dominio." ".$usuario." ".$nome_pc." ".$SO." ". $tipo." ".$licencaWin;*/

         if($_FILES['FotoA']['size'] != 0){
                $target_dir = "../_img/_monitores/";
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
                $IDMonitor = $_POST["idmonitor"];
                $foto = $_FILES["FotoA"];
                $img = $foto["name"];
                echo atulizaDadosMonitor($IDMonitor,$numero, $filial,$modelo,$marca,$polegada, $status, $responsavel, $img, $obs, $data);
            }else{
                $img = " ";
                echo atulizaDadosMonitor($IDMonitor,$numero, $filial,$modelo,$marca,$polegada, $status, $responsavel, $img, $obs, $data);
            }  
           
        }
//Deleta  o Ativo 
        if(isset($_POST['idMonitorD'])){
            $IDMONITOR = $_POST["idMonitorD"];
            echo deletaMonitor($IDMONITOR);
        }
?>        
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>