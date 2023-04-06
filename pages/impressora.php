<?php
    $impressoraQuantidade = QuantidadeImpressora();
    $impressoraQuantidadeAtivo = QuantidadeImpressoraAtivo();
    $impressoraQuantidadeParado = QuantidadeImpressoraParado();
    $impressoraQuantidadeEstragado = QuantidadeImpressoraEstragado();
    $filial =  exibirFilialAtivos();
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
                                    <form class="form-group" action='' method='POST' enctype="multipart/form-data">
                                        <input type='text' name='numeroAtivo' class="form-control form-control" placeholder="Numero Ativo" autocomplete="off" required >
                                        <br>
                                        <input type='text' name='toner' class="form-control form-control" placeholder="Toner" autocomplete="off">
                                        <br>
                                        <input type='text' name='modelo' class="form-control form-control" placeholder="Modelo"  autocomplete="off" >
                                        <br>
                                        <input type='text' name='marca' class="form-control form-control" placeholder="Marca" autocomplete="off" >
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
                </div>
            </li>
        </ul>   
    </div>  
</div> 
<div class='row'>  
    <div class="col">
        <h1>Quantidade de Ativos</h1>
        <h2>Total de Impressora: <?php echo  $impressoraQuantidade;?></h2>
        <h3 class='green'>Impressora Ativo: <?php echo  $impressoraQuantidadeAtivo ;?></h3>
        <h3 class='yellow'>Impressora Parado: <?php echo $impressoraQuantidadeParado;?></h3>
        <h3 class='red'>Impressora Estragado: <?php echo $impressoraQuantidadeEstragado;?></h3>
    </div>
</div> 
<div style="height: 80px;"></div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <a  class="btn btn-info" href="../_funcoes/gerarPlanilhaImpressora.php" >Gerar XLS</a> 
        <a  class="btn btn-info" href="../_funcoes/gerarPDFAtivosImpressora.php" target='_blank'>Gerar PDF</a>
    </div>
    <div class='col-sm-12 col-md-6' style='border:solid #000 1px'>
        <form class="form-group" method='POST' action='' >
            <fieldset>
                <legend>Filtro</legend>
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
            if(isset($_POST["cidade"])){
                $filial = $_POST['cidade'];
                $status = $_POST['status'];
                AtivosImpressora($filial,$status);
            }else{
                $filial ='default';
                $status ='default';
                AtivosImpressora($filial,$status);
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
        $toner = $_POST["toner"];
        $status = $_POST["status"];
        $filial = $_POST["cidade"];
        $data = $_POST["data"];
        $obs = $_POST["obs"];
       if($_FILES['foto']['size'] != 0){
            $target_dir = "../_img/_impressora/";
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
                echo cadastraImpressora($numero, $filial,$modelo,$marca,$status, $toner, $img, $obs, $data);
        }else{    
                $img = "padrao.jpg";     
                echo cadastraImpressora($numero, $filial,$modelo,$marca,$status, $toner, $img, $obs, $data);
        }
    }

   
?>     
<?php
//Captura os dados para atualizar o Ativo      
    if(isset($_POST['NumeroAtivoA'])){
            $IDImpressora = $_POST["idimpressora"];
            $numero = $_POST["NumeroAtivoA"];
            $marca = $_POST["MarcaA"];
            $modelo = $_POST["ModeloA"];
            $status = $_POST["StatusA"];
            $filial = $_POST["CidadeA"];
            $toner = $_POST["TonerA"];
            $data = $_POST["DataA"];
            $obs = $_POST["obsA"];
            /*echo  $IDCOMPUTADOR." ".$numero." ".$filial." ".$memoria." ".$processador." ".$modelo." ".$marca." ".$status." ".$responsavel."  ".$obs." ".$data." ".$dominio." ".$usuario." ".$nome_pc." ".$SO." ". $tipo." ".$licencaWin;*/

         if($_FILES['FotoA']['size'] != 0){
                $target_dir = "../_img/_impressora/";
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
                echo atulizaDadosImpressora($IDImpressora,$numero, $filial,$modelo,$marca, $status, $toner, $img, $obs, $data);
            }else{
                $img = " ";
                echo atulizaDadosImpressora($IDImpressora,$numero, $filial,$modelo,$marca, $status, $toner, $img, $obs, $data);
            }  
           
        }
//Deleta  o Ativo 
        if(isset($_POST['idImpressoraD'])){
            $IDIMPRESSORA = $_POST["idImpressoraD"];
            echo deletaImpressora($IDIMPRESSORA);
        }
?>        
  <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
</script>