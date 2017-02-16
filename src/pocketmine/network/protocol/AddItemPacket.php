<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class AddItemPacket extends DataPacket{

	const NETWORK_ID = Info::ADD_ITEM_PACKET;

	public $item;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putSlot($this->item);
	}

	/**
	 * @return AddItemPacket
	 */
	public function getName(){
		return "AddItemPacket";
	}

}