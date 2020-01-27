<?php
    function geraEstados($estados){
        $estadosArray=str_split($estados);
        $tamE=strlen($estados);
        if($tamE<30){//se quantidade de estados for de s0 a s9
            $todosEstados = str_split(str_replace(',', "", $estados), 2);        
        }else{//se maior
            $outputE1 = array_slice($estadosArray, 0, 29);//pega parcela de s0 a s9
            $outputE2 = array_slice($estadosArray, 30, $tamE);//pega resto de $estados
            $outputE3 = implode('', $outputE1);
            $outputE4 = implode('', $outputE2);
            $outputEs1 = str_split(str_replace(',', "", $outputE3), 2);//da primeira parte, retira ',' e cria array de 2 em 2 caracteres
            $outputEs2 = str_split(str_replace(',', "", $outputE4), 3);//da segunda parte, retira ',' e cria array de 3 em 3 caracteres
            $todosEstados=array_merge($outputEs1, $outputEs2);//junta a segunda parte
        }
        return $todosEstados;
    }
    function geraEstadosFinal($estadosF){    
        $estadosFArray=str_split($estadosF);     
        $tamEF=strlen($estadosF);
        if($tamEF<30){//se quantidade de estados for de s0 a s9
            $todosEstadosFinal = str_split(str_replace(',', "", $estadosF), 2);            
        }else{//se maior
            $outputEF1 = array_slice($estadosFArray, 0, 29);//pega parcela de s0 a s9
            $outputEF2 = array_slice($estadosFArray, 30, $tamEF);//pega resto de $estados final
            $outputEF3 = implode('', $outputEF1);
            $outputEF4 = implode('', $outputEF2);
            $outputEsF1 = str_split(str_replace(',', "", $outputEF3), 2);//da primeira parte, retira ',' e cria array de 2 em 2 caracteres
            $outputEsF2 = str_split(str_replace(',', "", $outputEF4), 3);//da segunda parte, retira ',' e cria array de 3 em 3 caracteres
            $todosEstadosFinal=array_merge($outputEsF1, $outputEsF2);//junta a segunda parte
        }
        return $todosEstadosFinal;        
    }
    function testeEI($estadoI, $estadosFinal){//essa funcao verifica se um estado inicial realmente esta na lista de estados
        if (!(in_array($estadoI, $estadosFinal))) { //se não encontrar o estado que esta testando dentro dos estados finais
            echo "<script>alert('REJEITADO ESTADO INICIAL INSERIDO, O ESTADO INICIAL NÃO ESTÁ NA LISTA DE ESTADOS!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        }
    }    
    function testeBase($simbolosAFinal, $base){//essa funcao verifica se a base inserida realmente esta na lista de simbolos auxiliares      
        if (!(in_array($base, $simbolosAFinal))) { //teste se não haver a base na lista de simbolos auxiliares, 
            echo "<script>alert('REJEITADA BASE INSERIDA, BASE NÃO ESTÁ NA LISTA DE SIMBOLOS AUXILIARES!');</script>";//manda mensagem
            echo "<script>window.history.back()</script>";//retorna para pagina anterior
        }                 
    }
    if(isset($_POST['descricaoF'])){//se a pagina inicia a partir do form enviado, recebe os dados
    //if(filter_input(INPUT_POST, 'alfabeto')!=""){//se a pagina inicia a partir do form enviado, recebe os dados
        $alfabeto = filter_input(INPUT_POST, 'alfabeto');
        $estados = filter_input(INPUT_POST, 'estados');
        $estadoI = filter_input(INPUT_POST, 'estadoI');
        $simbolosA = filter_input(INPUT_POST, 'simbolosA');
        $base = filter_input(INPUT_POST, 'base');
        $quantidadeT = filter_input(INPUT_POST, 'quantidadeT');
        $virgula = array(",");
        $alfabetoFinal = str_split(str_replace($virgula, "", $alfabeto));    
        $estadosFinal = str_split(str_replace($virgula, "", $estados), 2);
        $estadoIFinal=str_split($estadoI); 
        $baseFinal=$base; 
        $quantidadeTFinal=$quantidadeT;
        $simbolosAFinal = str_split(str_replace($virgula, "", $simbolosA), 1);    
        testeEI($estadoI, $estadosFinal);
        testeBase($simbolosAFinal, $base);   
        $gerou=1;    //essa variavel servirá para o form, se gerou for 1, quer dizer que pode mostrar o FT
    }else{//senão, inicia as váriaveis vazias, para o valor dos inputs serem nulos
        $alfabeto="";
        $estados="";
        $estadoI="";
        $simbolosA="";     
        $base="";         
        $quantidadeT="";  
        $quantidadeTFinal="";         
        $baseFinal="";        
        $alfabetoFinal = array();
        $estadosFinal = array(); 
        $estadoIFinal=array(); 
        $simbolosAFinal = array(); 
        $gerou=0; //variavel que, com valor zero, quer dizer que é a primeira vez que a pagina é chamada
    }
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>Inserir Descrição Formal</title>';
    echo '<meta charset="utf-8">';//inicia scrits para melhor design da pagina
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link href="arquivos/css/bootstrap.css" rel="stylesheet" type="text/css"/>';
    echo '<script src="arquivos/js/bootstrap.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/jquery.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/popper.min.js" type="text/javascript"></script>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<h2>Preencha os campos da Descrição Formal</h2>';
    if($gerou==0){            //primeira vez que pagina é iniciada
        echo '<form method="post" action="#" name="descricaoF">';//o form irá enviar inputs para a mesma pagina
    }else{
        echo '<form method="post" action="testar.php" name="descricaoF">';//o form enviará os inputs para a pagina de teste
        echo '<input type="hidden" id="alfabetoFinal" name="alfabetoFinal" value="'.$alfabeto.'">';//valores das variaveis
        echo '<input type="hidden" id="estadosFinal" name="estadosFinal" value="'.$estados.'">';
        echo '<input type="hidden" id="estadoIFinal" name="estadoIFinal" value="'.$estadoI.'">';
        echo '<input type="hidden" id="baseFinal" name="baseFinal" value="'.$base.'">';
        echo '<input type="hidden" id="simbolosAFinal" name="simbolosAFinal" value="'.$simbolosA.'">';
        echo '<input type="hidden" id="quantidadeTFinal" name="quantidadeTFinal" value="'.$quantidadeT.'">';
    }
    //inputs para receber os valores do alfabeto, estados, estado incial e estados finais
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Sigma;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" value="'.$alfabeto.'" id="alfabeto" placeholder="Digite o Conj. finito de estados. Ex: a,b,c"  name="alfabeto">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">E=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estados" value="'.$estados.'" placeholder="Digite o Conj. finito de símbolos alfabeto. Ex: q0,q1" name="estados">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">i=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estadoI" value="'.$estadoI.'" placeholder="Digite o estado inicial. Ex: q0" name="estadoI">';
    echo '</div>';
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Gamma;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="simbolosA" value="'.$simbolosA.'" placeholder="Digite símbolos auxiliares da pilha.Ex: Z,X" name="simbolosA">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Beta;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="base" value="'.$base.'" placeholder="Digite a Base da pilha. Ex: Z" name="base">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">QT=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="quantidadeT" value="'.$quantidadeT.'" placeholder="Digite a quantidade de Transições. Ex:6" name="quantidadeT">';    
    echo '</div>';
    if($gerou==0){    
        echo '<button type="submit" class="btn btn-secondary" name="descricaoF">Inserir &delta; (Função de Transição)</button>';//botão de envio do form para inserir o FT
    }else{  //como gerou é igual a 1, mostra o conteudo abaixo, a tabela para inserir os estados de transição, na função de transição, *delta               
        echo '<h3>Função de Transição</h3>';
        $quantidadeEstados=count($estadosFinal);        
        $quantidadeSimbolosAlfabeto=count($alfabetoFinal);
        $quantidadeSimbolosA=count($simbolosAFinal);
        for($j = 0; $j < $quantidadeTFinal; $j++){
            echo '<div class="input-group mb-3">';
            echo '<div class="input-group-prepend">';
            echo '<h3>&delta;</h3>';
            echo '</div>';
            echo '<h3>&nbsp;(</h3>';  
            echo '<select class="form-control" id="fT'.$j.'0" name="fT'.$j.'0" >';
            echo '<option></option>';   
            for($k=0;$k<$quantidadeEstados;$k++){
                echo '<option value="'.$estadosFinal[$k].'">'.$estadosFinal[$k].'</option>';
            }
            echo '</select>';  
            echo '<h3>,&nbsp;</h3>';        
            echo '<select class="form-control" id="fT'.$j.'1" name="fT'.$j.'1" >';
            echo '<option></option>';            
            for($k=0;$k<$quantidadeSimbolosAlfabeto;$k++){
                echo '<option value="'.$alfabetoFinal[$k].'">'.$alfabetoFinal[$k].'</option>';
            }
            echo '</select>';
            echo '<h3>,&nbsp;</h3>';         
            echo '<select class="form-control" id="fT'.$j.'2" name="fT'.$j.'2" >';
            echo '<option></option>';         
            echo '<option>&lambda;</option>';
            for($k=0;$k<$quantidadeSimbolosA;$k++){
                echo '<option value="'.$simbolosAFinal[$k].'">'.$simbolosAFinal[$k].'</option>';
            }
            echo '</select>';
            echo '<h3>)&nbsp;=&nbsp;(</h3>'; 
            echo '<select class="form-control" id="fT'.$j.'3" name="fT'.$j.'3" >';
            echo '<option></option>';         
            for($k=0;$k<$quantidadeEstados;$k++){
                echo '<option value="'.$estadosFinal[$k].'">'.$estadosFinal[$k].'</option>';
            }
            echo '</select>';   
            echo '<h3>,&nbsp;</h3>';     
            echo '<select class="form-control" id="fT'.$j.'4" name="fT'.$j.'4" >';
            echo '<option></option>';         
            echo '<option>&lambda;</option>';
            for($k=0;$k<$quantidadeSimbolosA;$k++){
                echo '<option value="'.$simbolosAFinal[$k].'">'.$simbolosAFinal[$k].'</option>';
            }
            for($k=1;$k<$quantidadeSimbolosA;$k++){
                $aux= str_repeat($simbolosAFinal[$k], 2);
                echo '<option  value="'.$aux.'">'.$aux.'</option>';            
            }
            echo '</select>';
            echo '<h3>)</h3></br>'; 
            echo '</div>';            
        }
        echo '<button type="submit" class="btn btn-secondary" name="descricaoF">Inserir Palavra</button>';
    }
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';