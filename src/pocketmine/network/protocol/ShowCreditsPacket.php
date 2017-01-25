<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class ShowCreditsPacket extends DataPacket{

	const NETWORK_ID = Info::SHOW_CREDITS_PACKET;

	public $eid;
	public $type;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putVarInt($this->type);
	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "ShowCreditsPacket";
	}

}