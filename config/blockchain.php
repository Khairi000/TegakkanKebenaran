<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Blockchain (Ganache)
    |--------------------------------------------------------------------------
    |
    | File ini digunakan untuk menyimpan konfigurasi dasar koneksi antara
    | Laravel dan jaringan blockchain lokal (Ganache). Pastikan port, private key,
    | dan contract address sesuai dengan pengaturan Ganache serta hasil deploy
    | Truffle kamu.
    |
    */

    // URL RPC dari Ganache
    'host' => env('BLOCKCHAIN_HOST', 'http://127.0.0.1:7545'),

    // Alamat contract hasil deploy (bisa juga diatur dari .env)
    'contract_address' => env('CONTRACT_ADDRESS', '0x207ca36d991C823980440eE514506BC1C88798b3'),

    // Private key akun Ganache yang digunakan untuk transaksi
    'private_key' => env('BLOCKCHAIN_PRIVATE_KEY', '0x22dc6588afaa2de53923d0bc76b6b19fbb31d7693f6ed7eb4978a840d5104faa'),

    // ABI otomatis dibaca dari file build contract Truffle
    'abi' => json_decode(
        file_get_contents(base_path('blockchain/build/contracts/AspirasiStorage.json')),
        true
    )['abi'] ?? [],
];
