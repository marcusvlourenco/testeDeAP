<?php
    function testeEI($estadoI, $estadosFinal){//essa funcao verifica se um estado inicial realmente esta na lista de estados
        if (!(in_array($estadoI, $estadosFinal))) { //se não encontrar o estado que esta testando dentro dos estados finais
            echo "<script>alert('REJEITADO ESTADO INICIAL INSERIDO, O ESTADO INICIAL NÃO ESTÁ NA LISTA DE ESTADOS!');</script>";//retorna mensagem
            echo "<script>window.history.back()</script>";//retorna para a pagina anterior
        }
    }    
    function testeEF($estadosFFinal, $estadosFinal){//essa funcao verifica se um estado final inserido realmente esta na lista de estados      
        $teste=current($estadosFFinal);//variavel recebe o primeiro valor dos estados final 
        $i = 0;
        $c = count($estadosFFinal);//conta a quantidade de estados final
        while ($i < $c) {
            if (!(in_array($teste, $estadosFinal))) { //teste se não haver o estado final na lista de estados, 
                echo "<script>alert('REJEITADO ESTADO FINAL INSERIDO, ALGUM ESTADO FINAL NÃO ESTÁ NA LISTA DE ESTADOS!');</script>";//manda mensagem
                echo "<script>window.history.back()</script>";//retorna para pagina anterior
            }
            $teste = next($estadosFFinal);//passa para o proximo estado final, se houver
            $i++;
        }        
    }
    if(isset($_POST['descricaoF'])){//se a pagina inicia a partir do form enviado, recebe os dados
    //if(filter_input(INPUT_POST, 'alfabeto')!=""){//se a pagina inicia a partir do form enviado, recebe os dados
        $alfabeto = filter_input(INPUT_POST, 'alfabeto');
        $estados = filter_input(INPUT_POST, 'estados');
        $estadoI = filter_input(INPUT_POST, 'estadoI');
        $estadosF = filter_input(INPUT_POST, 'estadosF');
        $virgula = array(",");
        $alfabetoFinal = str_split(str_replace($virgula, "", $alfabeto));    
        $estadosFinal = str_split(str_replace($virgula, "", $estados), 2);
        $estadoIFinal=str_split($estadoI); 
        $estadosFFinal = str_split(str_replace($virgula, "", $estadosF), 2);    
        testeEI($estadoI, $estadosFinal);
        testeEF($estadosFFinal, $estadosFinal);   
        $gerou=1;    //essa variavel servirá para o form, se gerou for 1, quer dizer que pode mostrar o FT
    }else{//senão, inicia as váriaveis vazias, para o valor dos inputs serem nulos
        $alfabeto="";
        $estados="";
        $estadoI="";
        $estadosF="";        
        $alfabetoFinal = array();
        $estadosFinal = array(); 
        $estadoIFinal=array(); 
        $estadosFFinal = array(); 
        $gerou=0; //variavel que, com valor zero, quer dizer que é a primeira vez que a pagina é chamada
    }
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>Bootstrap Example</title>';
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
        echo '<input type="hidden" id="estadosFFinal" name="estadosFFinal" value="'.$estadosF.'">';
    }
    //inputs para receber os valores do alfabeto, estados, estado incial e estados finais
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Sigma;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" value="'.$alfabeto.'" id="alfabeto" placeholder="Digite os símbolos, com &#34;,&#34; entre eles. Exemplo: a,b,c,d"  name="alfabeto">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">E=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estados" value="'.$estados.'" placeholder="Digite os ESTADOS, com &#34;,&#34; entre eles. Ex: S0,S1,S2" name="estados">';
    echo '</div>';
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">i=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estadoI" value="'.$estadoI.'" placeholder="Digite o ESTADO INICIAL. Exemplo: S0" name="estadoI">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">F=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estadosF" value="'.$estadosF.'" placeholder="Digite os ESTADOS FINAIS, com &#34;,&#34; entre eles. Ex: S1,S2" name="estadosF">';
    echo '</div>';
    if($gerou==0){    
        echo '<button type="submit" class="btn btn-secondary" name="descricaoF">Inserir &delta; (Função de Transição)</button>';//botão de envio do form para inserir o FT
    }else{  //como gerou é igual a 1, mostra o conteudo abaixo, a tabela para inserir os estados de transição, na função de transição, *delta       
        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>&delta;</th>';    
        $quantidadeSimbolosAlfabeto=count($alfabetoFinal);
        $quantidadeEstados=count($estadosFinal);
        for($i = 0; $i < $quantidadeSimbolosAlfabeto; $i++){
            echo '<th>'.$alfabetoFinal[$i].'</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        for($j = 0; $j < $quantidadeEstados; $j++){
            echo '<tr><td>'.$estadosFinal[$j].'</td>';
            for($k = 0; $k < $quantidadeSimbolosAlfabeto; $k++){
                echo '<td><input type="text" class="" id="fT'.$j.$k.'" name="fT'.$j.$k.'"></td>';                            
            }                        
            echo '</tr>'; 
        }
        echo '</tbody>';
        echo '</table>';
        echo '<button type="submit" class="btn btn-secondary" name="descricaoF">Inserir Palavra</button>';
    }
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';