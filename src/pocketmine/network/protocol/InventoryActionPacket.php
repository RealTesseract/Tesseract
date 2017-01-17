<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class InventoryActionPacket extends DataPacket{
	const NETWORK_ID = Info::INVENTORY_ACTION_PACKET;

	public $unknown;
	public $item;

	public function decode(){

	}
	
	public function encode(){
		$this->putUnsignedVarInt($this->unknown);
		$this->putSlot($this->item);
	}
}