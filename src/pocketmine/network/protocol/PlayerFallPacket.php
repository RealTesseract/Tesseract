<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class PlayerFallPacket extends DataPacket{

	const NETWORK_ID = Info::PLAYER_FALL_PACKET;

	public $fallDistance;

	public function decode(){
		$this->fallDistance = $this->getLFloat();
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
