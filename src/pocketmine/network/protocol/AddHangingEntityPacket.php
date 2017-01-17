<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class AddHangingEntityPacket extends DataPacket{
	const NETWORK_ID = Info::ADD_HANGING_ENTITY_PACKET;

	public $entityUniqueId;
	public $entityRuntimeId;
	public $x;
	public $y;
	public $z;
	public $unknown;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->entityUniqueId);
		$this->putEntityId($this->entityRuntimeId);
		$this->putBlockCoords($this->x, $this->y, $this->z);
		$this->putVarInt($this->unknown);
	}

}