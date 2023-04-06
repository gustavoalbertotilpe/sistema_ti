<?php

    require("banco.php");   
    function autenticacao($usuario,$senha){
        global $pdo;
        $sql = $pdo->prepare("SELECT IDUSUARIO, USERNAME,SENHA,NOME,CODIGOSENHA,FOTO FROM USUARIO WHERE USERNAME =? && SENHA  =?");
        $sql->execute(array($usuario,$senha));
        $valida = $sql->fetch(PDO::FETCH_ASSOC);
        if(empty($valida)){
            echo"<div class='alert alert-danger alert-dismissible'> <button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario ou senha invalido</strong></div>";
        }else{
            $_SESSION["IDUSUARIO"] = $valida["IDUSUARIO"];
            $_SESSION["NOME"] = $valida["NOME"];
            header("location:pages");
            die;
        }
    }
    function esqueceuSenha($email){
        global $pdo;

                // Inclui o arquivo class.phpmailer.php localizado na mesma pasta do arquivo php 
        include "../_bibliotecas/phpmailer/PHPMailerAutoload.php"; 
        
        // Inicia a classe PHPMailer 
        $mail = new PHPMailer(); 
        
        // Método de envio 
        $mail->IsSMTP(); 
        
        // Enviar por SMTP 
        $mail->Host = "cmail.madalozzocorretora.com.br"; 
        $mail->SMTPSecure = "tls"; // conexão segura com TLS
        
        // Você pode alterar este parametro para o endereço de SMTP do seu provedor 
        $mail->Port = 587; 
        
        
        // Usar autenticação SMTP (obrigatório) 
        $mail->SMTPAuth = true; 
        
        // Usuário do servidor SMTP (endereço de email) 
        // obs: Use a mesma senha da sua conta de email 
        $mail->Username = 'sgti@madalozzocorretora.com.br'; 
        $mail->Password = 'Brasil2019*'; 
        
        // Configurações de compatibilidade para autenticação em TLS 
        $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
        
        // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro. 
        //$mail->SMTPDebug = 2; 
        
        // Define o remetente 
        // Seu e-mail 
        $mail->From = "sgti@madalozzocorretora.com.br"; 
        
        // Seu nome 
        $mail->FromName = "Sistema SGTI"; 
        

        $sql = $pdo->prepare("SELECT IDUSUARIO, USERNAME,NOME,EMAIL FROM USUARIO WHERE EMAIL =?");
        $sql->execute(array($email));
        $valida = $sql->fetch(PDO::FETCH_ASSOC);
        if(empty($valida)){
            include("formulario.php");
            echo"<br><br><div class='alert alert-danger alert-dismissible'> <button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario não cadastrado!</strong></div>";
            die;
        }else{
            $IDUSUARIO = $valida["IDUSUARIO"];
            $NOME= $valida["NOME"];
            $EMAIL = $valida["EMAIL"];
            $numero=rand();
            $cod="SGTI-".$numero;
            $MSG ="<h1>Ola, ".$NOME."</h1>";
            $MSG.="<p>Você Solicitou nova senha de acesso: ".$cod."</p><h3>Sistema SGTI</h3>";
            $senha = md5($cod);
            $sql = $pdo->prepare("UPDATE USUARIO SET SENHA='{$senha}' WHERE IDUSUARIO='{$IDUSUARIO}'");
                if ($sql->execute()) {
                    
                    } else {
                            echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
                    }

            // Define o(s) destinatário(s) 
	 $mail->AddAddress($EMAIL, $NOME); 
 
                            // Opcional: mais de um destinatário
                            // $mail->AddAddress('fernando@email.com'); 
    
                            // Opcionais: CC e BCC
                            // $mail->AddCC('joana@provedor.com', 'Joana'); 
                            // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 
    
                            // Definir se o e-mail é em formato HTML ou texto plano 
                            // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
                            $mail->IsHTML(true); 
    
                            // Charset (opcional) 
                            $mail->CharSet = 'UTF-8'; 
    
                            // Assunto da mensagem 
                            $mail->Subject = "Nova Senha"; 
    
                            // Corpo do email 
                            $mail->Body = $MSG; 
    
                            // Opcional: Anexos 
                            // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf"); 
    
                            // Envia o e-mail 
                            $enviado = $mail->Send(); 
    
                            // Exibe uma mensagem de resultado 
                            if ($enviado) 
                            { 
                                    $mensagem= "<strong>SENHA ENVIADA NO E-MAIL CADASTRADO!</strong>"; 
                                    $mensagem.="<br><a href='../'>Voltar</a>";
                                    echo $mensagem;
                            } else { 
                                    $mensagem = "Codigo enviado no E-mail cadastrado!"; "Houve um erro enviando o email: ".$mail->ErrorInfo; 
                            } 
                    
    
        }

    }
?>