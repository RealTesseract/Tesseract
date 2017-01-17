<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ResourcePackClientResponsePacket extends DataPacket{
	const NETWORK_ID = Info::RESOURCE_PACK_CLIENT_RESPONSE_PACKET;

	public $unknownByte;
	public $unknownShort;

	public function decode(){
		$this->unknownByte = $this->getByte();
		$this->unknownShort = $this->getShort();
	}

	public function encode(){

	}

}