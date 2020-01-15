<?php
namespace Modulo\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
class ModeloTable{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        /*
            O Modelo Table trabalha com o padrao de projeto
            Dependency injection, nesse padrao de projeto,
            consiste em voce pegar um objeto que ja esteja 
            devidamente instanciado. Repare que aqui no construtor
            voce pega um TableGatewayInterface instanciado e 
            passa como parametro, e esse parametro fica salvo
            no atributo tableGateway aqui dentro. Esse padrao
            de injecao de independencia eh interessante, pois
            permite o reuso de objetos, nesse caso, o mesmo
            objeto passado aqui como parametro, pode ser usado
            em outros lugares, otimizando ainda mais os recursos
            computacionais na execucao do codigo.
        */
        $this->tableGateway = $tableGateway;
    }
    
    public function getAll(){
        //Esse metodo do TableGateway sem criterios,
        //retorna todos os dados que ele gerencia no BD. 
        return $this->tableGateway->select();
    }

    public function getModel($id){
        $id = (int) $id; //Cast para inteiro.
        /*
            Aqui o select ja tem um criterio.
            Para fazer uso do select voce deve passar
            um array, sendo as chaves as colunas
            e os valores os valores a serem inseridos
            no banco de dados. 
            No exemplo abaixo, temos a coluna id, recebendo
            o valor de $id, se fosse nome por exemplo, 
            seria: ['nome' => $variavelComValor]
        */
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current(); //Pega apenas o ultimo resultado.
        if(!$row){ //Se nao tiver nada.
            throw new RuntimeException(sprintf('Nao foi encontrado o id %d',$id));
        }else{
            return $row;
        }        
    }
    public function save(Modelo $modelo){
    //Como explicado acima no select, aqui o Zend trabalha inserindo 
    //um array no banco de dados. Repare sempre que o indice bate com
    //a coluna la no banco de dados, e o valor do de cada indice do array
    //com cada tupla la no banco de dados.
        $data = [            
            'valor' => $modelo->getValor(),
            'dataRegistro' => $modelo->getDataRegistro()
        ];
        $id = (int) $modelo->getId(); //Cast no ID.
        //Nesse desvio condicional abaixo, verifica-se se eh insercao ou atualizacao.
        if($id === 0){ //Se zero, eh insercao, caso nao seria atualizacao.
            /*
                Para inserir, voce usa o metodo insert do seu Table Gateway.
                Voce passa o valor e o zend cria um novo registro no banco
                de dados.
                Sendo o equivalente a:
                insert into MODELO values('seu_valor','sua_dataRegistro');
            */
            $this->tableGateway->insert($data);                        
        }else if($id > 0){ //Se maior que zero.
            /*
                Esse eh o metodo update, repare que eh parecido com
                o save acima, porem voce passa um segundo array apos
                o array que voce com os dados a serem atualizados.
                O array data tem os dados atualizados e o segundo
                array como parametro, seriam as condicoes para a 
                clausura where, ou seja o where eh feito em cima
                do segundo array, como so tem um elemento, apenas
                tem uma condicao para que a atualizacao no banco
                de dados ocorra. O zend envia ao banco
                de dados o equivalente a:
                update table MODELO set `valor` = `seu_novo_valor`,
                `dataRegistro` = `seu_novo_dataRegistro` where `id` = `id_valor`; 
            */
            $this->tableGateway->update($data,['id' => $id]);            
        }else{ //Agora se for um numero negativo ou outras bizarrices...
            throw new RuntimeException(sprintf('Valor invalido para o ID: %d',$id));
        }    
    }

    public function delete($id){
        $id = (int) $id;
        if($id > 0){
            $this->tableGateway->delete(['id' => $id]);
        }else{
            throw new RuntimeException(sprintf('Valor invalido para o ID: %d',$id));
        }
    }

}