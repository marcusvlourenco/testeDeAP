<?php
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>AFD - Descrição do Trabalho</title>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link href="arquivos/css/bootstrap.css" rel="stylesheet" type="text/css"/>';
    echo '<script src="arquivos/js/bootstrap.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/jquery.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/popper.min.js" type="text/javascript"></script>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container-fluid">';
    echo '<h3 clas="">Trabalho de Linguagens Formais e Autômatos – Autômato Finito Determinístico</h3>';
    echo '</br>';
    echo '<h4 clas="">OBJETIVO</h4>';
    echo '<p>Implementar um algoritmo para o funcionamento de um Autômato Finito Determinístico, e que realize o teste de palavras fornecidas pelo usuário.</p>';
    echo '<h4 clas="">DESCRIÇÃO</h4>';
    echo '<p>O trabalho consiste em implementar um programa que em um primeiro momento leia a descrição formal de uma AFD do usuário, e em seguida teste palavras por ele fornecidas, respondendo se as palavras pertencem ou não à linguagem descrita pelo autômato.</p>';
    echo '<h4 clas="">IMPLEMENTAÇÃO</h4>';
    echo '<p>Uma possível implementação do AFD se daria de modo que a descrição formal do AFD {E, Σ, δ, i, F} é inserida em um programa, e após isso pode se testar uma palavra, e o programa responde se a palavra pertence ou não à linguagem que o AFD reconhece</p>';
    echo '</br>';
    echo '<p>Início</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;Estado Atual &#60;- Estado Inicial;</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;Para i variar do Símbolo inicial da fita até o símbolo final</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Faça Se Existe δ (Estado Atual, i)</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Então Estado Atual &#60;- δ (Estado Atual, i);</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Senão REJEITA;</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;Se Estado Atual é Final</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Então ACEITA;</p>';
    echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Senão REJEITA;</p>';
    echo '<p>Fim.</p>';
    echo '</div>';
    echo '</body>';
    echo '</html>';