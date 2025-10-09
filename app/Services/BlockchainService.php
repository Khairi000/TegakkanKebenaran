<?php

namespace App\Services;

use Web3\Web3;
use Web3\Contract;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class BlockchainService
{
    protected $web3;
    protected $contract;
    protected $account;

    public function __construct()
    {
        $this->web3 = new Web3(Config::get('blockchain.host'));
        $this->account = Config::get('blockchain.private_key');
        $this->contract = $this->loadContract();
    }

    private function loadContract()
    {
        $abiPath = base_path('blockchain/build/contracts/AspirasiStorage.json');

        if (!file_exists($abiPath)) {
            throw new \Exception("File ABI contract tidak ditemukan di: {$abiPath}");
        }

        $json = json_decode(file_get_contents($abiPath), true);
        $abi = $json['abi'];
        $address = Config::get('blockchain.contract_address');

        return new Contract($this->web3->provider, $abi, $address);
    }

    /**
     * Simpan aspirasi ke blockchain
     */
    public function storeAspirasi($judul, $isi)
    {
        $hash = hash('sha256', $judul . $isi . now());

        try {
            $this->contract->send(
                'storeAspirasi',
                $judul,
                $isi,
                $hash,
                [
                    'from' => $this->getFirstAccount(),
                    'gas' => 3000000
                ],
                function ($err, $tx) {
                    if ($err) {
                        Log::error('Blockchain TX Error: ' . $err->getMessage());
                        throw new \Exception("Gagal kirim transaksi ke blockchain");
                    } else {
                        Log::info('Transaksi blockchain berhasil dikirim: ' . $tx);
                    }
                }
            );
        } catch (\Exception $e) {
            Log::error('Blockchain error: ' . $e->getMessage());
        }

        return $hash;
    }

    /**
     * Ambil akun pertama di Ganache
     */
    private function getFirstAccount()
    {
        $account = null;

        $this->web3->eth->accounts(function ($err, $accounts) use (&$account) {
            if ($err !== null) {
                throw new \Exception("Gagal mengambil akun dari Ganache");
            }
            $account = $accounts[0];
        });

        return $account;
    }
}
