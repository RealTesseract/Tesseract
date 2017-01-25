<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ReplaceItemInSlotPacket extends DataPacket{

	const NETWORK_ID = Info::REPLACE_ITEM_IN_SLOT_PACKET;

	public $item;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putSlot($this->item);
	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "ReplaceItemInSlotPacket";
	}

}