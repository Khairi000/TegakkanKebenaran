// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract AspirasiStorage {
    struct Aspirasi {
        uint id;
        string judul;
        string hash;
        address pengirim;
        uint timestamp;
    }

    mapping(uint => Aspirasi) public aspirasis;
    uint public totalAspirasi = 0;

    event AspirasiDisimpan(uint id, string judul, string hash, address pengirim, uint timestamp);

    function simpanAspirasi(string memory _judul, string memory _hash) public {
        totalAspirasi++;
        aspirasis[totalAspirasi] = Aspirasi(totalAspirasi, _judul, _hash, msg.sender, block.timestamp);
        emit AspirasiDisimpan(totalAspirasi, _judul, _hash, msg.sender, block.timestamp);
    }

    function getAspirasi(uint _id) public view returns (Aspirasi memory) {
        return aspirasis[_id];
    }
}
