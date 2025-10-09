import Web3 from "web3";
import contractData from "../../../blockchain/build/contracts/AspirasiStorage.json";

let web3;
let contract;

async function initBlockchain() {
    if (window.ethereum) {
        // Hubungkan ke Metamask
        web3 = new Web3(window.ethereum);
        await window.ethereum.request({ method: "eth_requestAccounts" });

        const networkId = await web3.eth.net.getId();
        const deployedNetwork = contractData.networks[networkId];

        contract = new web3.eth.Contract(
            contractData.abi,
            deployedNetwork && deployedNetwork.address
        );
        console.log("✅ Blockchain connected:", deployedNetwork.address);
    } else {
        alert("Metamask tidak terdeteksi!");
    }
}

export async function simpanAspirasiBlockchain(judul, hash) {
    if (!contract) await initBlockchain();

    const accounts = await web3.eth.getAccounts();
    await contract.methods.simpanAspirasi(judul, hash).send({ from: accounts[0] });

    console.log("Aspirasi disimpan di blockchain!");
}
