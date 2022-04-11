const HDWalletProvider = require('truffle-hdwallet-provider') ; 
const Web3 = require('web3') ; 
const {

    abi, 
    bytecode

} = require ('./compile') ; 

const mnemonic = 'view desk life tennis cash cram junk debris afraid airport art pudding' ; 
const provider = new HDWalletProvider(mnemonic , 'http://127.0.0.1:80') ; 

// Use the provider to instance a new web3 object
const web3 = new Web3(provider) ; 

const deploy = async () => {

    const accounts = await web3.eth.getAccounts() ; 

    const argumentsConstructor = [

        "InmigrantCoint" , 
        "ICOIN", 
        18,
        21000000
    ] ; 

    const gasEstimate = await new web3.eth.Contract(abi)
        .deploy( { data: bytecode, arguments: argumentsConstructor } )
        .estimateGas( {from: accounts[0] } ) ; 

    const result = await new web3.eth.Contract(abi)
        .deploy( { data: bytecode, arguments: argumentsConstructor } )
        .send( { gas: gasEstimate , from: accounts[0] } ) ;

    
    console.log("The contract address is: " , result.options.address) ; 

} ; 

// Start the fun
deploy() ; 
