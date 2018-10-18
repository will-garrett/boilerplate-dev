<?php namespace Will0g;

use GraphAware\Neo4j\Client\ClientBuilder;
use function GuzzleHttp\json_encode;

class Neo4j{
    public $client;
    public function __construct(){
        $this->client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:'.env('NEO4J_PASS', 'neo4j').'@neo4j:7474')
        ->build();
    }
    public function run($string){
        return $this->client->run($string);
    }
    public function createPerson($args = []){
        if(!empty($args)){
            $items = [];
            foreach($args as $key=>$val){
                $items[]="{$key}:\"{$val}\"";
            }
            $result = $this->run("CREATE (n:Person {".implode(",",$items)."}) RETURN n");
            $records = $result->getRecords();
            $node = $records[0]->value("n");
            return $node;
        }
    }
    public function getPersonByID($idnum){

    }
    public function deletePerson($args = []){
        if(!empty($args)){
            if(!empty($args['id'])){
                $query = "MATCH (s) WHERE ID(s) = {$args['id']} DETACH DELETE s";
            }
            else{
                $query_items = [];
                foreach($args as $key=>$val){
                    $query_items[]="{$key}:\"{$val}\"";
                }
                $query = "MATCH (a:Person {".implode(",", $query_items)."}) DETACH DELETE a";
            }
            $result = $this->run($query);
            return $result;
        }
    }

}

?>