const api = require('./routes/api');
const version = require('./version');

// Load Express
const express = require('express');
const app = express();

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
