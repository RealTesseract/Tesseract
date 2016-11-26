<?php


 
namespace WingProxy\network\protocol\spp;

use pocketmine\utils\UUID;

class TransferPacket extends DataPacket{
	const NETWORK_ID = Info::TRANSFER_PACKET;

	/** @var UUID */
	public $uuid;
	public $clientHash;

	public function encode(){
		$this->reset();
		$this->putUUID($this->uuid);
		$this->putString($this->clientHash);
	}

	public function decode(){
		$this->uuid = $this->getUUID();
		$this->clientHash = $this->getString();
	}
}