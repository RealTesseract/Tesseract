<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class FullChunkDataPacket extends DataPacket{
	const NETWORK_ID = Info::FULL_CHUNK_DATA_PACKET;

	public $chunkX;
	public $chunkZ;
	public $data;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putVarInt($this->chunkX);
		$this->putVarInt($this->chunkZ);
		$this->putString($this->data);
	}

}
