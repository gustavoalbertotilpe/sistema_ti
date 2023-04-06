<?php 
    require("../_funcoes/conf.php");
?>    
<?php
 include("../view/header.php");
?>   
<div class="container-fluid" style="position:absolute;top:0;z-index: 3;" >
   <div class="row">
      <div class="col"  style="background-color: #343a40; width: 100%;">
           <div></div>
            <nav class="navbar navbar-expand-lg navbar-dark  bg-dark "  >
                    <a class="navbar-brand" href="index.php">SGTI</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <!-- Links -->
                    <ul  class='navbar-nav '>
                        <li class="nav-item" >
                        <a class="nav-link" href="?url=chamado">CHAMADO TI</a>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            CONTATOS
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="?url=contatos">CONTATOS</a>
                            <a class="dropdown-item" href="?url=ramais">RAMAIS</a>
                        </div>
                        </li>
                            
                        <li class="nav-item">
                        <a class="nav-link"  href="https://cpanel.plsscloud.com.br:2083/" target="_blank">CPANEL</a>
                        </li>
                    
                        
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            LINKS UTEIS
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="http://zabbix.plss.com.br/zabbix.php?action=dashboard.view" target="_blank">ZABIX</a>
                            <a class="dropdown-item"  href="http://www.speedtest.net/pt" target="_blank">TESTE DE VELOCIDADE</a>
                            <a class="dropdown-item" href="https://www.jivochat.com.br/" target="_blank">JIVOCHAT</a>
                            <a class="dropdown-item" href="http://helpdesk.plss.com.br/index.php?noAUTO=1" target="_blank">HELPDESK PLSS</a>
                            <a class="dropdown-item"  href="https://quiver.freshdesk.com/support/login" target="_blank">HELPDESK QUIVER</a>
                            <a class="dropdown-item" href="https://unifi.plss.com.br:8443/manage/account/login" target="_blank">UNIFI</a>
                        </div>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            ATIVOS
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="?url=computador">COMPUTADOR</a>
                            <a class="dropdown-item" href="?url=monitor">MONITOR</a>
                            <a class="dropdown-item" href="?url=impressora">IMPRESSORA</a>
                            <a class="dropdown-item" href="?url=celular">CELULAR</a>
                            <a class="dropdown-item" href="?url=software">SOFTWARE</a>
                        </div>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            IMPRESSORAS
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="http://192.168.200.252/" target="_blank">DIGITALIZADORA</a>
                            <a class="dropdown-item" href="http://192.168.200.83/" target="_blank">COMERCIAL</a>
                            <a class="dropdown-item" href="http://192.168.200.251/" target="_blank">RECPÇÃO</a>
                        </div>
                        </li>
                        <!-- Dropdown -->
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            SISTEMA
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="?url=usuario">USUARIOS</a>
                            <a class="dropdown-item" href="?url=user">ALTERAR SENHA OU E-MAIL</a>
                            <a class="dropdown-item" href="?url=solicitacao">SOLICITAÇÕES</a>
                            <a class="dropdown-item" href="?url=senhas">SENHAS</a>
                            <a class="dropdown-item" href="?url=contas-email">CONTAS E-MAIL</a>
                        </div>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="sair.php">SAIR</a>
                        </li>     
                    </ul>
                </div>
            </nav>
       </div>     
   </div>
</div>
<div style="height: 40px;"></div>
<div class="container-fluid">         
<?php
    if(file_exists($url)){
        include($url);
    }else{
        include("erro404.php");
    }  
?>
</div>  

<?php 
  include("rodape.php");
?>  
      
<?php
 include("../view/footer.php");
?>     