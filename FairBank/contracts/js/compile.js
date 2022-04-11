// Include libraries
const path = require('path') ; // Module to manage routes
const fs = require('fs') ; 
const solc = require ('solc') ; // Compiler

const MyCoinPath = path.join(__dirname , '../MyCoin.sol') ; 
const readCode = fs.readFileSync(MyCoinPath , 'utf8') ; 

const input = {

    language: 'Solidity', 
    sources: {
        'MyCoin.sol': {
            content: readCode
        }
    },
    settings: {
        outputSelection: {
            '*': {
                '*': ['*']
            }
        }
    }

} ; 

// Parse the input
const output = JSON.parse(solc.compile(JSON.stringify(input))) ; 

module.exports = {

    abi: output.contracts['MyCoin.sol'].MyCoin.abi, 
    bytecode: output.contracts['MyCoin.sol'].MyCoin.evm.bytecode.object
}
