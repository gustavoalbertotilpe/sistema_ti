<?php   
    $deskAtivoQuantidade = QuantidadeDeskAtivo();
    $deskQuantidade = QuantidadeDesk();
    $deskParado = QuantidadeDeskParado();
    $deskEstragodo = QuantidadeDeskEstragado();
    $monitorQuantidade = QuantidadeMonitor();
    $monitorQuantidadeAtivo = QuantidadeMonitorAtivo();
    $monitorQuantidadeParado = QuantidadeMonitorParado();
    $monitorQuantidadeEstragado = QuantidadeMonitorEstradago();
    $impressoraQuantidade = QuantidadeImpressora();
    $impressoraQuantidadeAtivo = QuantidadeImpressoraAtivo();
    $impressoraQuantidadeParado = QuantidadeImpressoraParado();
    $impressoraQuantidadeEstragado = QuantidadeImpressoraEstragado();
    $filias = exibirFilial();
 ?>
<div class="row">
    <div class='col'>
        <h1><a href="lembrete.php">Lembretes</a></h1>
    </div>
</div>
<div class="row">    
   <div class='col lembretes'>
    <?php 
        lembrete($IDUSUARIO);
    ?>   
    </div>
</div>
<div style="height:80px"></div>
<div class="row">
    <div class="col" style="margin-bottom: 12px;">
        <a class="btn btn-info"  href="../_funcoes/gerarPlanilhaComputador.php">Gerar Planilha</a> 
        <a class="btn btn-info" href="../_funcoes/gerarPDFAtivos.php" target='_blank'>Gerar PDF</a> 
    </div>
    <div class='col-sm-12 col-md-6'>
        <form class="form-group" action='' method='GET'>
            <div class="input-group mb-3">
                <input type='search' name='res' class="form-control form-control" placeholder='Buscar por Responsavel' required>
                <div class="input-group-append">
                    <button type='submit' class="btn btn-outline-primary" type="button">BUSCAR</button>
                </div>
            </div>    
        </form>
    </div> 
</div>   
<div class="row">
    <div class="col"  style="padding: 0;">   
        <?php
        $res = (isset($_GET['res'])) ? $_GET['res'] : 'default';
            tableaAtivos($res);
        ?>
    </div>    
</div>        
