const api = require('./routes/api');
const version = require('./version');

// Load Express
const express = require('express');
const neo4j = require('neo4j-driver').v1;
const app = express();
const driver = neo4j.driver("bolt://neo4j", neo4j.auth.basic("neo4j", "tango461"));
const session = driver.session();

const resultPromise = session.writeTransaction(tx => tx.run('CREATE (a:Greeting) SET a.message = $message RETURN a.message + ", from node " + id(a)', {message: 'hello, world'}));

resultPromise.then(result => {
    session.close();
    const singleRecord = result.records[0];
    const greeting = singleRecord.get(0);
    console.log(greeting);
    driver.close();
});

// using json
app.use(express.json());

// Pull url encoded values - legacy support
app.use(express.urlencoded({ extended: true}));

// Public Static Director Init
app.use(express.static('public'));



app.use('/api', api);




// Listen on .env PORT or 3000;
const port = process.env.PORT || 3000;
app.listen(port, ()=>console.log(`Listening on port ${port}`));
