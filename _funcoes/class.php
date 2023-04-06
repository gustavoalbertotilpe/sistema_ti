<?php 
    class ConsultaComprador{
    private $pdo;
    private $consulta;
    private $row;
   

    public function __construct(){
        $HOST='localhost';
        $DB='sistema_ti';
        $USER='root';
        $PASS='';
            try{
               $this->pdo= $pdo = new PDO('mysql:host='.$HOST.';dbname='.$DB,$USER,$PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                echo 'erro ao conectar';
            }
        $this->consulta = $pdo->prepare("SELECT ID_DEP_COMPRAS,NOME_COMPRADOR,EMAIL_COMPRADOR FROM DEP_COMPRAS");
        $this->consulta->execute();
        $this->row = $this->consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function getNomeComprador(){
        echo $this->row["NOME_COMPRADOR"];
    }
    public function getEmailComprador(){
        echo $this->row["EMAIL_COMPRADOR"];
    }
    public function getIDCompras(){
        echo $this->row["ID_DEP_COMPRAS"];
    }

    public function setComprador($idComprador,$nomeComprador,$emailComprador){
        $sql= $this->pdo->prepare("UPDATE DEP_COMPRAS SET NOME_COMPRADOR =?,EMAIL_COMPRADOR = ? WHERE ID_DEP_COMPRAS =?");
        if($sql->execute(array($nomeComprador,$emailComprador,$idComprador))){
            echo"<script>alert('Dados Atulizado com sucesso!')</script>";
        }
    }

}