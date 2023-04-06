<?php
    require("../_funcoes/conf.php");
?>
<div>
    <form>
        <input type='text' name='numero_ativo' size=40 placeholder="Numero do Ativo">
        <br>
        <input type='text' name='responsavel' size=40 placeholder="Responsavel">
        <br>
        <input type='text' name='tipo' size=40 placeholder="Tipo">
        <br>
        <input type='text' name='marca' size=40 placeholder="Modelo">
        <br>
        <input type='text' name='processador' size= 40 placeholder='Processador'>
        <br>
        <input type='text' name='memoriaRam' size= 40 placeholder="Memoria RAM">
        <br>
        <input type='text' name='nomePc' size=40 placeholder="Nome do PC">
        <br>
        <input type='text' name='usuario' size=40 placeholder='usuario'>
        <br>
        <input type='text' name='dominio' size=40 placeholder='Dominio'>
        <br>
        <input type='text' name='SistemaOperacional' size=40 placeholder='Sistema Opercional'>
        <br>
        <input type='text' name='licencaWindows' size=40 placeholder='Licença Windows'>
        <br>
        <input type='text' name='situacao' size=40 placeholder='Situação'>
        <br>
        <label for='dataCompraId'>Data da compra:</p>
        <input type='date' name='dataCompra' size=40>
        <br>
        <label for='filialID'>Filial:</label>
        <select id='filialID'>
            <option></option>
        </select>   
        <br>
        <input type='file'>
        <br>
        <label for='obsID'>Obs:</label>
        <br>
        <input type='submit'>
    </form>
</div>