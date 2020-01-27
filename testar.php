<?php     //é recebido tanto da pagina inserir.php como de testar.php os valores dos inputs, que preencheram com valor as váriaveis

    class stack{
        private $arr=array();
        
        public function push($s){
            $this->arr[]=$s;
        }
        
        public function pop(){
            return array_pop($this->arr);
        }
        
        public function peek(){
            return end($this->arr);            
        }
        
        public function isEmpty(){
            return empty($this->arr);
        }
              
        
        
    }

    $virgula = ",";
    $vazio="";
    $alfabetoForm = filter_input(INPUT_POST, 'alfabetoFinal');
    $estadosForm = filter_input(INPUT_POST, 'estadosFinal');
    $estadoInicialForm = filter_input(INPUT_POST, 'estadoIFinal');
    $simbolosAuxiliaresForm = filter_input(INPUT_POST, 'simbolosAFinal');
    $baseForm = filter_input(INPUT_POST, 'baseFinal');
    $quantidadeTForm = filter_input(INPUT_POST, 'quantidadeTFinal');
    $alfabeto = str_split(str_replace($virgula, $vazio, $alfabetoForm));//como foi inserido virgula, essa função a retira e tambem gera um array com str_split
    $estados = str_split(str_replace($virgula, $vazio, $estadosForm), 2);//essa função armazena a cada 2 digitos o valor em uma posição do array, como estados[0]=S0, estados[1]=S1
    $simbolosA = str_split(str_replace($virgula, $vazio, $simbolosAuxiliaresForm), 1);
    $estadoInicial = $estadoInicialForm;
    $quantidadeT = $quantidadeTForm;
    $base = $baseForm;
    $quantidadeSimbolosAlfabeto=count($alfabeto);//conta quantos simbolos há no alfabeto
    $quantidadeEstados=count($estados);
    if(isset($_POST['testePalavra'])){//so é executado se a pagina for carregada do post do form para receber palavra 
        for($i = 0; $i < $quantidadeT; $i++){//esse loop recebe de forma dinamica os valores de cada input do FT
            for($j=0; $j <5; $j++){
                $funcaoTransicao[$i][$j]= filter_input(INPUT_POST, 'fT'.$i.$j);//aramzenando dentro deste array multidimensional   
            }
        } 
        $palavra =str_split(filter_input(INPUT_POST, 'palavra'));//valor recebido do form para a palavra
        $quantidadePalavra=count($palavra);   //funcao faz a contagem da quantidade de palavras  
        $simboloTeste= current($palavra); //aponta para o primeiro valor da array
        $palavraReturn=0;
        for($i=0;$i<$quantidadePalavra;$i++){//percorre cada simbolo da palavra
            $palavraReturn=testePalavra($simboloTeste, $alfabeto);//para testar se a palavra esta no alfabeto, retornando valor de teste
            if($palavraReturn==0){
                $simboloTeste= next($palavra);//se 0, continua o teste ate a ultima palavta
            }else{
                break;//senao, para o teste e o valor de return sera 1
            }            
        }                             
        if($palavraReturn==0){//caso passou no teste, sera executado a funcao que verifica se é possivel a palavra dentro da descricao formal
            testeAP($base, $estadoInicial, $palavra, $funcaoTransicao, $quantidadePalavra, $quantidadeT);//com o envio, é chamado a funcao de teste do AFD, que envia os dados recebido para a funcao 
        }    
    } else {   //quando executa a primeira vez a pagina, vem para essa parte da pagina
        for($i = 0; $i < $quantidadeT; $i++){//esse loop recebe de forma dinamica os valores de cada input do FT
            for($j = 0; $j < 5; $j++){   
                $funcaoTransicao[$i][$j]= filter_input(INPUT_POST, 'fT'.$i.$j);//aramzenando dentro deste array multidimensional  
            }               
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
    function estadoTransicao($estadoAtual,$TopoDaPilha, $i,$funcaoTransicao ,$quantidadeT){//funcao busca o resultado da funcao de transicao e retorna
        for($j=0;$j<$quantidadeT;$j++){
            if(($funcaoTransicao[$j][0]==$estadoAtual)&&($funcaoTransicao[$j][1]==$i)&&($funcaoTransicao[$j][2]==$TopoDaPilha)){                
                $aux[0]=$funcaoTransicao[$j][3];              
                $aux[1]=$funcaoTransicao[$j][4];
                return $aux;                
            }            
        }        
    }
    
    
    function testeAP ($base, $estadoInicial, $palavra, $funcaoTransicao, $quantidadePalavra, $quantidadeT){
        
        $pilha = new stack();// gera uma pilha
        $estadoAtual=$estadoInicial;//Estado atual recebe o estado incial
        $i='';
        $i=$palavra[0]; // $i recebe a primeira letra da palavra a ser testada
        $pilha->push($base);// coloca a base na pilha, no topo
        $TopoDaPilha=$pilha->peek();    //variavel recebe topo da pilha         
        for($m=0;$m<$quantidadePalavra;$m++){//Para i variar do simbolo incial ate o simbolo final
            if((($estadoAtual!=null)or($estadoAtual!=''))&&(($TopoDaPilha!=null)or($TopoDaPilha!=''))&&(($i!=null)or($i!=''))){  //se existir a parte da funcao de transicao
                $aux=estadoTransicao($estadoAtual,$TopoDaPilha, $i,$funcaoTransicao, $quantidadeT);//variavel aux recebe retorno da funcao que busca o resultado da funcao de transicao
                $estadoAtual=$aux[0];     
                $resposta=$aux[1];
                $pilha->pop();//retira item da pilha    
                $var=str_split($aux[1]);
                if((strlen($resposta)!=1)&&($resposta!='λ')){    //verifica se no resultado da funcao de transicao tem a adicao de dois simbolos para adicionar na pilha  e diferente de lambda 
                    $pilha->push($var[0]);
                    $pilha->push($var[1]);
                }else if($resposta!='λ'){      //se nao for igual a lambda, ou seja, um simbolo só...                                
                    $pilha->push($aux[1]);
                } 
                $i=next($palavra);          
                $TopoDaPilha=$pilha->peek();//valor do topo da pilha
            }else{
                echo "<script>alert('REJEITA');</script>";
                return;
            }            
        }        
        if($pilha->isEmpty()){//ok, se pilha for vasia: true ou false
            echo "<script>alert('ACEITA');</script>";
            return;
        }else {//senao, rejeita
            echo "<script>alert('REJEITA');</script>";
            return;            
        }    
    }
    
    
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
    echo '<input type="hidden" id="simbolosAFinal" name="simbolosAFinal" value='.$simbolosAuxiliaresForm.'>';  
    echo '<input type="hidden" id="baseFinal" name="baseFinal" value='.$baseForm.'>';  
    echo '<input type="hidden" id="quantidadeTFinal" name="quantidadeTFinal" value='.$quantidadeTForm.'>';                
    for($i = 0; $i < $quantidadeTForm; $i++){ 
        for($j=0; $j <5; $j++){
            $funcaoTransicao[$i][$j]= filter_input(INPUT_POST, 'fT'.$i.$j);//aramzenando dentro deste array multidimensional 
            echo '<input type="hidden" value="'.$funcaoTransicao[$i][$j].'" id="fT'.$i.$j.'" name="fT'.$i.$j.'">';    
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
    echo '<input type="text" class="form-control" id="estadosI" value="'.$estadoInicialForm.'" name="estadosI" readonly="readonly">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Gamma;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="simbolosA" value="'.$simbolosAuxiliaresForm.'" name="simbolosA" readonly="readonly">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">&Beta;=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="base" value="'.$baseForm.'" name="base" readonly="readonly">';
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<div class="input-group-prepend">';
    echo '<span class="input-group-text">QT=</span>';
    echo '</div>';
    echo '<input type="text" class="form-control" id="quantidadeT" value="'.$quantidadeTForm.'" name="quantidadeT" readonly="readonly">';
    echo '</div>';
    echo '<h3>Função de Transição</h3>';
    for($i = 0; $i < $quantidadeTForm; $i++){
        echo '<div class="input-group mb-3">';
        echo '<div class="input-group-prepend">';  
        $j=0;
        echo '&delta;('.$funcaoTransicao[$i][$j].',&nbsp';    
        echo ''.$funcaoTransicao[$i][$j+1].',&nbsp';    
        echo ''.$funcaoTransicao[$i][$j+2].')&nbsp=&nbsp';    
        echo '('.$funcaoTransicao[$i][$j+3].',&nbsp';    
        echo ''.$funcaoTransicao[$i][$j+4].')';   
        echo '</div>';                 
        
    }
    
    echo '</div>';   
    echo '</body>';
    echo '</html>';