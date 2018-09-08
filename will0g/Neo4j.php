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
    public function deletePerson($args = []){
        if(!empty($args)){
            $items = [];
            foreach($args as $key=>$val){
                $items[]="{$key}:\"{$val}\"";
            }
            echo "MATCH (a:Person {".implode(",", $items)."}) DETACH DELETE a";
            $result = $this->run("MATCH (a:Person {".implode(",", $items)."}) DETACH DELETE a");
            return $result;
        }
    }

}

?>