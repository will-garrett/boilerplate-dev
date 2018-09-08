<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GraphAware\Neo4j\Client\ClientBuilder;
class Neo4j extends TestCase
{

    public function testNeo4JClient(){
        $pass = urlencode(get_env("NEO4J_PASS"));
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
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
