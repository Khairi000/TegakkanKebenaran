// truffle-config.js

module.exports = {
  networks: {
    // 🔹 Koneksi ke Ganache GUI
    development: {
      host: "127.0.0.1",     // localhost
      port: 7545,            // port default Ganache GUI
      network_id: "*",       // cocok untuk semua ID jaringan
    },
  },

  // 🔹 Konfigurasi compiler Solidity
  compilers: {
    solc: {
      version: "0.8.17",     // gunakan versi stabil
      settings: {
        optimizer: {
          enabled: true,     // aktifkan optimizer
          runs: 200          // efisiensi untuk smart contract besar
        },
      },
    },
  },

  // 🔹 Nonaktifkan Truffle DB (biar migrasi lebih ringan)
  db: {
    enabled: false,
  },
};
