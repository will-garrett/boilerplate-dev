<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GraphAware\Neo4j\Client\ClientBuilder;
use Will0g\Neo4j as NeoGeo;
class Neo4j extends TestCase
{
    public function testNeo4JClient(){
        $pass = urlencode(env('NEO4J_PASS', 'neo4j'));
        $client = ClientBuilder::create()
        ->addConnection('default', 'http://neo4j:'.$pass.'@neo4j:7474')
        ->build();
        $this->assertInstanceOf('GraphAware\Neo4j\Client\Client', $client);
        //$create = $client->run('CREATE (n:Person) SET n += {infos}', ['infos' => ['name' => 'Will', 'age' => 35]]);
        $result = $client->run('MATCH (n:Person{name:"Will"}) RETURN n');
        $items = $result->firstRecord();
        $record=$items->value("n")->values();
        $this->assertArraySubset(['name'=>'Will', 'age'=>35], $record);
        
    }
    public function testWill0gClient(){
        $neo4j = new NeoGeo();
        $this->assertInstanceOf('Will0g\Neo4j', $neo4j);
        $results = $neo4j->run('MATCH (n:Person{name:"Will"}) RETURN n');
        $obj = $results->firstRecord()->value("n")->values();
        $this->assertArraySubset(['name'=>'Will', 'age'=>35], $obj);
    }
    public function testWill0gPerson(){
        $neo4j = new NeoGeo();
        /*
        $id = $neo4j->createPerson([
            'name'=>"William Garrett",
            'email'=>"the@willgarrett.io"
        ]);
        */
        //$this->assertInstanceOf('GraphAware\Neo4j\Client\Formatter\Type\Node', $id);
        //$this->assertInternalType('int', $id->identity());
        //$id_number = $id->identity();

        $request1 = $neo4j->run('MATCH (n:Person{name:"Will"}) RETURN n');
        echo "Size: ".$request1->size();
        echo "\nFirst:";
        $record = $request1->firstRecord();
        var_dump($record);
        echo "\nValues:";
        var_dump($record->values());
        
        die();
        $request2 = $neo4j->run('MATCH (n:Person{name:"Johan"}) RETURN n');
        var_dump($request2);

        //$neo4j->deletePerson(['id'=>$id_number]);
        
//        $neo4j->deletePerson(['id'=>$id->identity()]);
        
    }
}
