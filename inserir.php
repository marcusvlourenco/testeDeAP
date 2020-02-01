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
    function testeEntrada($alfabeto,$estados,$estadoI,$simbolosA,$base){
        $j=0;
        $tamA=strlen($alfabeto);
        $tamE=strlen($estados);
        $tamI=strlen($estadoI);
        $tamS=strlen($simbolosA);
        $tamB=strlen($base);
        $alfabetoArray=str_split($alfabeto);
        $estadosArray=str_split($estados);
        $estadoIArray=str_split($estadoI);     
        $simbolosAArray=str_split($simbolosA);   
        $baseArray=str_split($base);       
        $tamanhoS=$tamS-1;        
        $todosEstados=geraEstados($estados);    
        $todosSimbolosA = str_split(str_replace(',', "", $simbolosA));   
        //teste Estado Inicial
        if($tamI==2){
            if((!ctype_lower($estadoIArray[0])&&(!ctype_upper($estadoIArray[0])))or((intval($estadoIArray[1])<>0)&&(intval($estadoIArray[1])<>1))or(ctype_lower($estadoIArray[1])or(ctype_upper($estadoIArray[1])))){
                echo "<script>alert('REJEITADO ESTADO INICIAL INSERIDO, O ESTADO INICIAL DEVE TER UM CARACTER COM UM NUMERO JUNTOS!');</script>";//retorna mensagem
                echo "<script>window.history.back()</script>";//retorna para a pagina anterior
            }
        }else{
            echo "<script>alert('REJEITADO ESTADO INICIAL INSERIDO, O ESTADO INICIAL DEVE TER UM CARACTER COM UM NUMERO JUNTOS!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior            
        }
        for($i=0;$i<$tamS;$i++){
            if(($i % 2)==0){
                if(!ctype_upper($simbolosAArray[$i])){//teste se simbolo da palavra é mAIusculo
                    echo "<script>alert('REJEITADO SIMBOLOS AUXILIARES INSERIDOS, O CONJUNTO DE SIMBOLOS DEVEM SER LETRAS DE A ATÉ Z, MAIUSCULAS, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }
            }else{
                if($simbolosAArray[$i]<>','){//se tem virgula entre os simbolos
                    echo "<script>alert('REJEITADO SIMBOLOS AUXILIARES INSERIDOS, O CONJUNTO DE SIMBOLOS DEVEM SER LETRAS DE A ATÉ Z, MAIUSCULAS, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }
            }                
        }
        if($simbolosAArray[$tamanhoS]==','){
            echo "<script>alert('REJEITADO SIMBOLOS AUXILIARES INSERIDOS, O CONJUNTO DE SIMBOLOS DEVEM SER LETRAS DE A ATÉ Z, MAIUSCULAS, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        }
        for($i=0;$i<$tamA;$i++){
            
            if(substr_count($alfabeto, $alfabetoArray[$i])>1){
                echo "<script>alert('REJEITADO ALFABETO INSERIDO, O ALFABETO NÃO DEVE SER REPETIDO!');</script>";//retorna mensagem
                echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                
            }  
            if(($i % 2)==0){
                if(!ctype_lower($alfabetoArray[$i])){//teste se simbolo da palavra é minusculo
                    if(($alfabetoArray[$i]<>'0')&&($alfabetoArray[$i]<>'1')){//se é 1 ou 0
                        echo "<script>alert('REJEITADO ALFABETO INSERIDO, O ALFABETO DEVE SER LETRAS DE A ATÉ Z, MINUSCULAS, INCLUINDO 0 E 1, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
                        echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                    }                    
                }
            }else{
                if($alfabetoArray[$i]<>','){//se tem virgula entre os simbolos
                    echo "<script>alert('REJEITADO ALFABETO INSERIDO, O ALFABETO DEVE SER LETRAS DE A ATÉ Z, MINUSCULAS, INCLUINDO 0 E 1, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }
            }    
        }

        if(($estadosArray[$tamE-1]==',')or(ctype_lower($estadosArray[$tamE-1]))or(ctype_upper($estadosArray[$tamE-1]))){
            echo "<script>alert('REJEITADO ESTADOS INSERIDO, O ESTADO NÃO DEVE TERMINAR EM LETRAS DE A ATÉ Z OU VIRGULA!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        }
        if((!ctype_lower($estadosArray[0]))&&(!ctype_upper($estadosArray[0]))){//teste se a primeira o simbolo do estado é um caracter alfabetico maiusculo ou minusculo  
            echo "<script>alert('REJEITADO ESTADO(S) INSERIDO(S), O ESTADO DEVE SER LETRAS DE A ATÉ Z, MINUSCULAS OU MAIUSCULAS, COM VIRGULA ENTRE CADA SIMBOLO!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        } 
        
        if($tamE<30){//para estados de s0 a s9
            for($i=0;$i<$tamE-2;$i+=3){
                $k=$i+1;
                $l=$i+2;
                if(($estadosArray[0]<>$estadosArray[$i])or(intval($estadosArray[$k])<>$j)or($estadosArray[$l]<>',')){//testa se todos os simbolos alfabeticos sao iguais
                   //testa se existe sequencia nos estados, se nao se repetem,
                    //testa se existe separacao de entrada entre os estados
                    echo "<script>alert('REJEITADO ESTADO(S) INSERIDO(S)! \\n OS ESTADOS DEVE SER UMA LETRA DE A ATÉ Z, MINUSCULA OU MAIUSCULA, SEMPRE IGUAIS, ACOMPANHADO DE UM NÚMERO SEQUENCIAL PARA CADA ESTADO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }        
                $j++;
            }
        }else{
            for($i=0;$i<28;$i+=3){//para os primeiros estados s0, s1, s2, ... , s9
                $k=$i+1;
                $l=$i+2;
                if(($estadosArray[0]<>$estadosArray[$i])or(intval($estadosArray[$k])<>$j)or($estadosArray[$l]<>',')){//testa se todos os simbolos alfabeticos sao iguais
                    //testa se existe sequencia nos estados, se nao se repetem,
                    //testa se existe separacao de entrada entre os estados
                    echo "<script>alert('REJEITADO ESTADO(S) INSERIDO(S)! \\n OS ESTADOS DEVE SER UMA LETRA DE A ATÉ Z, MINUSCULA OU MAIUSCULA, SEMPRE IGUAIS, ACOMPANHADO DE UM NÚMERO SEQUENCIAL PARA CADA ESTADO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }        
                $j++;
            }
            for($i=30;$i<$tamE-3;$i+=4){//para demais estados iniciando em 30 e irá funcionar até s99, poderia ser testado para s100, mas neste range já é suficiente
                
                $k=$i+1;
                $l=$i+3;
                $m=$k+1;
                $aux=$estadosArray[$k]; 
                $aux.=$estadosArray[$m];//junta os numeros de estado acima de 9, ou seja, 1 e 0=10
                if(($estadosArray[0]<>$estadosArray[$i])or(intval($aux)<>$j)or($estadosArray[$l]<>',')){//testa se todos os simbolos alfabeticos sao iguais
                    //testa se existe sequencia nos estados, se nao se repetem,
                    //testa se existe separacao de entrada entre os estados
                    echo "<script>alert('REJEITADO ESTADO(S) INSERIDO(S)! \\n OS ESTADOS DEVE SER UMA LETRA DE A ATÉ Z, MINUSCULA OU MAIUSCULA, SEMPRE IGUAIS, ACOMPANHADO DE UM NÚMERO SEQUENCIAL PARA CADA ESTADO!');</script>";//retorna mensagem
                    echo "<script>window.history.back()</script>";//retorna para a pagina anterior
                }        
                $j++;
            }
        }           
        if (!(in_array($base, $todosSimbolosA))) { //se não encontrar o estado que esta testando dentro dos estados finais
            echo "<script>alert('REJEITADA A BASE INSERIDA, A BASE NÃO ESTÁ NA LISTA DE SIMBOLOS AUXILIARES!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        } 
        if (!(in_array($estadoI, $todosEstados))) { //se não encontrar o estado que esta testando dentro dos estados finais
            echo "<script>alert('REJEITADO ESTADO INICIAL INSERIDO, O ESTADO INICIAL NÃO ESTÁ NA LISTA DE ESTADOS!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        } 

    }

    if(isset($_POST['descricaoF'])){//se a pagina inicia a partir do form enviado, recebe os dados
    //if(filter_input(INPUT_POST, 'alfabeto')!=""){//se a pagina inicia a partir do form enviado, recebe os dados
        $alfabeto = filter_input(INPUT_POST, 'alfabeto');
        $estados = filter_input(INPUT_POST, 'estados');
        $estadoI = filter_input(INPUT_POST, 'estadoI');
        $simbolosA = filter_input(INPUT_POST, 'simbolosA');
        $base = filter_input(INPUT_POST, 'base');
        $quantSA = filter_input(INPUT_POST, 'quantSA');        
        $quantidadeT = filter_input(INPUT_POST, 'quantidadeT');        
        testeEntrada($alfabeto,$estados,$estadoI,$simbolosA,$base);
        $virgula = array(",");
        $alfabetoFinal = str_split(str_replace($virgula, "", $alfabeto));
        $estadosFinal=geraEstados($estados);  
        $estadoIFinal=str_split($estadoI); 
        $baseFinal=$base; 
        $quantidadeTFinal=$quantidadeT;
        $simbolosAFinal = str_split(str_replace($virgula, "", $simbolosA), 1);      
        $gerou=1;    //essa variavel servirá para o form, se gerou for 1, quer dizer que pode mostrar o FT
    }else{//senão, inicia as váriaveis vazias, para o valor dos inputs serem nulos
        $alfabeto="";
        $estados="";
        $estadoI="";
        $simbolosA="";     
        $base="";
        $quantSA="";
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
    if($gerou==0){            //primeira vez que pagina é iniciada
        echo '<h2>Preencha os campos da Descrição Formal</h2>';
        echo '<form method="post" action="#" name="descricaoF">';//o form irá enviar inputs para a mesma pagina
        //inputs para receber os valores do alfabeto, estados, estado incial e estados finais
        echo '<div class="input-group mb-3">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Sigma;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control col-md-5" value="" required id="alfabeto" placeholder="Digite o Conj. finito de estados. Ex: a,b,c"  name="alfabeto">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">E=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="estados" required value="" placeholder="Digite o Conj. finito de símbolos alfabeto. Ex: q0,q1" name="estados">';
        echo '</div>';
        echo '<div class="input-group mb-3">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">i=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control col-md-5" id="estadoI" required value="" placeholder="Digite o estado inicial. Ex: q0" name="estadoI">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';  
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Gamma;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="simbolosA" required value="" placeholder="Digite símbolos auxiliares da pilha.Ex: Z,X" name="simbolosA">';
        echo '</div>';
        echo '<div class="input-group mb-2">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Beta;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control col-md-5" id="base" required value="" placeholder="Digite a Base da pilha. Ex: Z" name="base">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">Quantia Transições=</span>';
        echo '</div>';
        echo '<input type="number" class="form-control  col-md-1" min="1" required id="quantidadeT" value="" name="quantidadeT">';    
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">Repetições Símbolos Aux.=</span>';
        echo '</div>';
        echo '<input type="number" class="form-control  col-md-1" min="1" required id="quantSA" value=""  name="quantSA">';   
        echo '</div>';  
        echo '<button type="submit" class="btn btn-secondary" name="descricaoF">Inserir &delta; (Função de Transição)</button>';//botão de envio do form para inserir o FT
    }else{  //como gerou é igual a 1, mostra o conteudo abaixo, a tabela para inserir os estados de transição, na função de transição, *delta               
        echo '<h2>Preencha os campos da função de transição</h2>';
        echo '<form method="post" action="testar.php" name="descricaoF">';//o form enviará os inputs para a pagina de teste
        echo '<input type="hidden" id="alfabetoFinal" name="alfabetoFinal" value="'.$alfabeto.'">';//valores das variaveis
        echo '<input type="hidden" id="estadosFinal" name="estadosFinal" value="'.$estados.'">';
        echo '<input type="hidden" id="estadoIFinal" name="estadoIFinal" value="'.$estadoI.'">';
        echo '<input type="hidden" id="baseFinal" name="baseFinal" value="'.$base.'">';
        echo '<input type="hidden" id="simbolosAFinal" name="simbolosAFinal" value="'.$simbolosA.'">';
        echo '<input type="hidden" id="quantidadeTFinal" name="quantidadeTFinal" value="'.$quantidadeT.'">';
        echo '<input type="hidden" id="quantSAFinal" name="quantSAFinal" value="'.$quantSA.'">';
        //inputs para receber os valores do alfabeto, estados, estado incial
        echo '<div class="input-group mb-3">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Sigma;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" value="'.$alfabeto.'" id="alfabeto" readonly="readonly" name="alfabeto">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">E=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="estados" value="'.$estados.'"  readonly="readonly" name="estados">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">i=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="estadoI" value="'.$estadoI.'"  readonly="readonly" name="estadoI">';
        echo '</div>';
        echo '<div class="input-group mb-3">';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Gamma;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="simbolosA" value="'.$simbolosA.'"  readonly="readonly" name="simbolosA">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">&Beta;=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="base" value="'.$base.'"  readonly="readonly" name="base">';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">QT=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="quantidadeT" value="'.$quantidadeT.'"  readonly="readonly" name="quantidadeT">';  
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<div class="input-group-prepend">';
        echo '<span class="input-group-text">QSA=</span>';
        echo '</div>';
        echo '<input type="text" class="form-control" id="quantSA" value="'.$quantSA.'"  readonly="readonly" name="quantSA">';    
        echo '</div>';  
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
            echo '<option>&lambda;</option>';     
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
            //echo '<input type="text" class="form-control" id="fT'.$j.'4" name="fT'.$j.'4">';
            echo '<select class="form-control" id="fT'.$j.'4" name="fT'.$j.'4" >';
            echo '<option></option>';         
            echo '<option>&lambda;</option>';
            echo '<option value="'.$baseFinal.'">'.$baseFinal.'</option>';
            $chaveSimbolo= array_search($base, $simbolosAFinal);
            for($l=0;$l<$quantidadeSimbolosA;$l++){
                if($l<>$chaveSimbolo){                    
                    for($k=1;$k<=$quantSA;$k++){
                        $aux= str_repeat($simbolosAFinal[$l], $k);
                        echo '<option  value="'.$aux.'">'.$aux.'</option>';            
                    } 

                }            
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