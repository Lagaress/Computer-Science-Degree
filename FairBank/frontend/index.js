const addressContract = "0x2e32351cc094df2B07695D2B92a8F3FBEbadc479" ; 

const abi = [
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "spender",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "Approval",
		"type": "event"
	},
	{
		"anonymous": false,
		"inputs": [
			{
				"indexed": true,
				"internalType": "address",
				"name": "from",
				"type": "address"
			},
			{
				"indexed": true,
				"internalType": "address",
				"name": "to",
				"type": "address"
			},
			{
				"indexed": false,
				"internalType": "uint256",
				"name": "value",
				"type": "uint256"
			}
		],
		"name": "Transfer",
		"type": "event"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "owner",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			}
		],
		"name": "allowance",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "spender",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "approve",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "accounts",
				"type": "address"
			}
		],
		"name": "balanceOf",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "totalSupply",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "recipient",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "transfer",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address",
				"name": "sender",
				"type": "address"
			},
			{
				"internalType": "address",
				"name": "recipient",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "amount",
				"type": "uint256"
			}
		],
		"name": "transferFrom",
		"outputs": [
			{
				"internalType": "bool",
				"name": "",
				"type": "bool"
			}
		],
		"stateMutability": "nonpayable",
		"type": "function"
	}
] ; 

let web3 ; 
let account ; 
let MyCoin ; 

function init()
{

    if (typeof window.ethereum !== 'undefined')
    {

        const metamaskBtn = document.getElementById('enableEthereumButton') ; 
        metamaskBtn.classList.remove('d-none') ; 

        metamaskBtn.addEventListener('click' , async() => {

            const accounts = await ethereum.request({ method: 'eth_requestAccounts'}) ; 
            account = accounts[0] ; 

            metamaskBtn.classList.add('d-none') ; 
            document.getElementById('accountSelected').innerHTML = "Your actual account is: " + account ; 
            document.getElementById('accountSelected').classList.add('border') ; 

            detectChangueAccount() ; 
            contract() ; 

        }) ;

    }

    else
    {

        document.getElementById('accountSelected').innerHTML = "Any account detected" ; 

    }

}

function detectChangueAccount()
{

    window.ethereum.on('accountsChanged', function(accounts) {

        console.log(accounts)
        account = accounts[0] ;
        document.getElementById('accountSelected').innerHTML = account ; 

        console.log("Cuenta conectada") ;

    }) ; 

}

function contract ()
{

    web3 = new Web3(window.ethereum) ; 
    MyCoin = new web3.eth.Contract(abi , addressContract) ; 

    interact() ; 

}

function interact(){

    const btnGetBalance = document.getElementById('btnGetBalance') ; 
    btnGetBalance.addEventListener('click', () => {

        const address = document.getElementById('addressGetBalance') ; 
        const value = address.value ; 

        MyCoin.methods.balanceOf(value).call().then(res => {
            const amount = web3.utils.fromWei(res , 'ether') ; 
            const valueSpan = document.getElementById('balance') ; 
            valueSpan.innerHTML = "Balance: " + amount + " ACOIN"; 
			valueSpan.style.display = 'block'; 
        }) ;

    }) ; 

    const transfer = document.getElementById('transferir') ; 
    transfer.addEventListener('click' , () => {

        const address = document.getElementById('addressBeneficiaria') ; 
        const addressValue = address.value ; 

        const amount = document.getElementById('cantidad') ; 
        const amountString = amount.value.toString() ; 
        const amountTransfer = web3.utils.toWei(amountString , 'ether') ; 
    

        // Send method needs a signer 
        MyCoin.methods.transfer(addressValue , amountTransfer).send({ from: account }).then(res => {

            address.value = '' ;
            amount.value = 0 ; 

            const transferSpan = document.getElementById('transferConfirmation') ;  
			transferSpan.style.display = 'block'; 

        }) ;

    }) ; 

}

window.onload = init() ; 

// 0x38746759c56fAB8131540107BE9FE11E6b4980ae