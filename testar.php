<?php     //é recebido tanto da pagina inserir.php como de testar.php os valores dos inputs, que preencheram com valor as váriaveis
    $tamanho=100;
    $base='Z';
    $virgula = ",";
    $vazio="";
    $alfabetoForm = filter_input(INPUT_POST, 'alfabetoFinal');
    $estadosForm = filter_input(INPUT_POST, 'estadosFinal');
    $estadoInicialForm = filter_input(INPUT_POST, 'estadoIFinal');
    $estadosFinalForm = filter_input(INPUT_POST, 'estadosFFinal');
    $alfabeto = str_split(str_replace($virgula, $vazio, $alfabetoForm));//como foi inserido virgula, essa função a retira e tambem gera um array com str_split
    $estados = str_split(str_replace($virgula, $vazio, $estadosForm), 2);//essa função armazena a cada 2 digitos o valor em uma posição do array, como estados[0]=S0, estados[1]=S1
    $estadosFinal = str_split(str_replace($virgula, $vazio, $estadosFinalForm), 2);
    $estadoInicial = str_split($estadoInicialForm, 2);
    $quantidadeSimbolosAlfabeto=count($alfabeto);//conta quantos simbolos há no alfabeto
    $quantidadeEstados=count($estados);
    if(isset($_POST['testePalavra'])){//so é executado se a pagina for carregada do post do form para receber palavra 
        for($i = 0; $i < $quantidadeEstados; $i++){//esse loop recebe de forma dinamica os valores de cada input do FT
            for($j = 0; $j < $quantidadeSimbolosAlfabeto; $j++){   
                $funcaoTransicao[$i][$j]= filter_input(INPUT_POST, 'fT'.$i.$j);//aramzenando dentro deste array multidimensional   
            }               
        } 
        $palavra =str_split(filter_input(INPUT_POST, 'palavra'));//valor recebido do form para a palavra
        $quantidaePalavra=count($palavra);   //funcao faz a contagem da quantidade de palavras  
        $simboloTeste= current($palavra); //aponta para o primeiro valor da array
        $palavraReturn=0;
        for($i=0;$i<$quantidaePalavra;$i++){//percorre cada simbolo da palavra
            $palavraReturn=testePalavra($simboloTeste, $alfabeto);//para testar se a palavra esta no alfabeto, retornando valor de teste
            if($palavraReturn==0){
                $simboloTeste= next($palavra);//se 0, continua o teste ate a ultima palavta
            }else{
                break;//senao, para o teste e o valor de return sera 1
            }            
        }                             
        if($palavraReturn==0){//caso passou no teste, sera executado a funcao que verifica se é possivel a palavra dentro da descricao formal
            testeAP($tamanho, $base, $alfabeto, $estadoInicial, $estadosFinal, $palavra, $funcaoTransicao, $estados, $quantidaePalavra);//com o envio, é chamado a funcao de teste do AFD, que envia os dados recebido para a funcao
        }    
    } else {   //quando executa a primeira vez a pagina, vem para essa parte da pagina
        $contFT=0;
        for($i = 0; $i < $quantidadeEstados; $i++){//esse loop recebe de forma dinamica os valores de cada input do FT
            for($j = 0; $j < $quantidadeSimbolosAlfabeto; $j++){   
                $funcaoTransicao[$i][$j]= filter_input(INPUT_POST, 'fT'.$i.$j);      //aramzenando dentro deste array multidimensional   
                $estadoTeste=$funcaoTransicao[$i][$j];//recebe valor corrente da funcao de transicao
                if($estadoTeste!=$vazio){//se o valor  nao for vazio
                    testeFT($estadoTeste, $estados);//chama funcao de teste do FT, para verificar se o estado atual é valido dentro dos estados da descricao formal
                    $contFT++;    //conta quantos estados foram inseridos na FT 
                }
            }               
        } 
        if($contFT==0){//Se nao foi inserido nenhum estado, retorna a pagina
            echo "<script>alert('REJEITADO ESTADOS INSERIDO, OS ESTADOS NA FUNÇÃO TRANSIÇÃO ESTÃO VAZIOS!');</script>";
            echo "<script>window.history.back()</script>";
        }
    }    
    function testeFT($estadoTeste, $estados){//essa funcao verifica se um estado do ft realmente esta na lista de estados
        if (!(in_array($estadoTeste, $estados))) { 
            echo "<script>alert('REJEITADO ESTADO INSERIDO, ALGUM ESTADO NA FUNÇÃO TRANSIÇÃO NÃO ESTÁ NA LISTA DE ESTADOS!');</script>";
            echo "<script>window.history.back()</script>";
        }
    }    
    function testePalavra($simboloTeste, $alfabeto){//essa funcao verifica se o simbolo da palavra existe dentro do alfabeto
        if (!(in_array($simboloTeste, $alfabeto))) { 
            echo "<script>alert('REJEITADA PALAVRA INSERIDA, NÃO EXISTE ALGUM SIMBOLO NO ALFABETO!');</script>";
            return 1;
        }else{
            return 0;
        }
    }    
    
    function testeAP ($tamanho, $base, $alfabeto, $estadoInicial, $estadosFinal, $palavra, $funcaoTransicao, $estados, $quantidaePalavra){
        $estadoAtual=$estadoInicial;//ok
        $pilha = new \Ds\Stack();//ok  
        $pilha->allocate($tamanho);//ok
        $pilha->push($base);//ok coloca item na pilha
        /*
        $pilhaVazia=var_dump($pilha->isEmpty());//ok, se pilha for vasia: true ou false
        $pilha->clear();//limpa a pilha
        var_dump($pilha->capacity());//mostra a capacidade da pilha
        var_dump($pilha->pop());//retira item da pilha
        var_dump($pilha->peek());//valor do topo da pilha, só pra ver, nao desempilha
        */
        $simboloAtual=current($palavra);
        for($i=0;$i<$quantidaePalavra;$i++){
            $j= array_search($estadoAtual, $estados);
            $k= array_search($simboloAtual, $alfabeto);
            $estadoTransicao=$funcaoTransicao[$j][$k];
            if($estadoTransicao){
                $estadoAtual=$estadoTransicao;
                $simboloAtual=next($palavra);
            }else{
                echo "<script>alert('REJEITA');</script>";
                return;
            }
        }
        if(in_array($estadoAtual, $estadosFinal)){
            echo "<script>alert('ACEITA');</script>";
            return;
        } else {//senao, rejeita
            echo "<script>alert('REJEITA');</script>";
            return;            
        }        
    }
    
    function testeAFD ($alfabeto, $estadoInicial, $estadosFinal, $palavra, $funcaoTransicao, $estados, $quantidaePalavra){//funcao de teste do afd, melhor dizendo, testa a palavra
        $estadoAtual=$estadoInicial;//recebe valor do estado inicial no estado atual
        $simboloAtual=current($palavra);//recebe o primeiro simbolo, armazenando em simboloatual
        for($i=0;$i<$quantidaePalavra;$i++){//laco que percorre cada simbolo da palavra inserida
            $j= array_search($estadoAtual, $estados);//funcao recebe o indice do array que se encontra o estado atual dentro da lista de estados
            $k= array_search($simboloAtual, $alfabeto);//mesma funcao para achar indice do simbolo atual dentro do alfabeto
            $estadoTransicao=$funcaoTransicao[$j][$k];//estadoTransicao recebe valor da funcaoTransicao onde o estado atual recebe o simbolo da palavra e mostra o estado que irá
            if($estadoTransicao){//se existe o estado 
                $estadoAtual=$estadoTransicao;//o estado atual o recebe
                $simboloAtual=next($palavra);//e passamos para a proxima palavra
            }else{//se nao existir o estado, rejeita
                echo "<script>alert('REJEITA');</script>";
                return;
            }
        }
        if(in_array($estadoAtual, $estadosFinal)){//no final, se o estado atual, apos percorrer toda a transicao, for estado final, aceita
            echo "<script>alert('ACEITA');</script>";
            return;
        } else {//senao, rejeita
            echo "<script>alert('REJEITA');</script>";
            return;            
        }        
    }// a seguir, formulario que recebe o valor da palavra e reenvia para esta mesma pagina, teste.php, junto com os valores dos inputs anteriores
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>Teste de Palavra</title>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<link href="arquivos/css/bootstrap.css" rel="stylesheet" type="text/css"/>';
    echo '<script src="arquivos/js/bootstrap.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/jquery.min.js" type="text/javascript"></script>';
    echo '<script src="arquivos/js/popper.min.js" type="text/javascript"></script>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<h2>Teste de Palavra</h2>';
    echo '<form method="post" action="#" name="testePalavra">';
    echo '<input type="hidden" id="alfabetoFinal" name="alfabetoFinal" value='.$alfabetoForm.'>';
    echo '<input type="hidden" id="estadosFinal" name="estadosFinal" value='.$estadosForm.'>';
    echo '<input type="hidden" id="estadoIFinal" name="estadoIFinal" value='.$estadoInicialForm.'>';
    echo '<input type="hidden" id="estadosFFinal" name="estadosFFinal" value='.$estadosFinalForm.'>';                
    for($j = 0; $j < $quantidadeEstados; $j++){
        for($k = 0; $k < $quantidadeSimbolosAlfabeto; $k++){
            echo '<input type="hidden" value="'.$funcaoTransicao[$j][$k].'" id="fT'.$j.$k.'" name="fT'.$j.$k.'">';                            
        }
    }
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">Palavra = </span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="palavra" placeholder="Digite a palavra, de acordo com a Descrição Formal. Exemplo: aabbc"  name="palavra">';
    echo '<button type="submit" class="btn btn-secondary" name="testePalavra">Testar Palavra</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    //a aprtir daqui, é somente um demonstrativo da descricao formal completa
    echo '<div class="container">';
    echo '<h3>Descrição Formal Inserida:</h3>';
    echo '<div class="input-group mb-3">';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Sigma;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" value="'.$alfabetoForm.'" id="alfabeto"  name="alfabeto"  readonly="readonly" >';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">E=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estados" value="'.$estadosForm.'" name="estados" readonly="readonly">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">i=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estadoI" value="'.$estadoInicialForm.'" name="estadoI" readonly="readonly">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">F=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="estadosF" value="'.$estadosFinalForm.'" name="estadosF" readonly="readonly">';
    echo '</div>';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>&delta;</th>';    
    for($i = 0; $i < $quantidadeSimbolosAlfabeto; $i++){
        echo '<th>'.$alfabeto[$i].'</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for($j = 0; $j < $quantidadeEstados; $j++){
        echo '<tr><td>'.$estados[$j].'</td>';
        for($k = 0; $k < $quantidadeSimbolosAlfabeto; $k++){
            echo '<td><input type="text" class=""  value="'.$funcaoTransicao[$j][$k].'" id="fT'.$j.$k.'" name="fT'.$j.$k.'" readonly="readonly"></td>';                            
        }                        
        echo '</tr>'; 
    }
    echo '</tbody>';
    echo '</table>';    
    echo '</div>';   
    echo '</body>';
    echo '</html>';