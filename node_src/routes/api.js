const express = require('express');
const router = express.Router();

const version = require('../version');

function make_message(my_string){
    if(my_string.charAt(my_string.length-1) != "."){
        my_string = my_string + ".";
    }

    return my_string.charAt(0).toUpperCase() + my_string.slice(1);
}
// Boilerplate routes
router.get('/', (req, res) => {
    console.log(version.version);
    res.send({
        name: version.version.name,
        version: version.version.version,
        message: make_message(version.version.s_message)
    });
});

module.exports = router;