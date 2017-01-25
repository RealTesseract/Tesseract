<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class PlayerFallPacket extends DataPacket{

	const NETWORK_ID = Info::PLAYER_FALL_PACKET;

	public $unknown; //betting this is fall distance, but let's make sure first

	public function decode(){
		$this->unknown = $this->getLFloat();
	}

	public function encode(){

	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "PlayerFallPacket";
	}

}
