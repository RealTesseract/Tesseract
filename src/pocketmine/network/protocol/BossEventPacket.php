<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class BossEventPacket extends DataPacket{

	const NETWORK_ID = Info::BOSS_EVENT_PACKET;

  	public $eid;
	public $type;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putUnsignedVarInt($this->type);
	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "BossEventPacket";
	}

}
