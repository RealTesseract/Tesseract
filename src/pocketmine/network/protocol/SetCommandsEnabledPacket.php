<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class SetCommandsEnabledPacket extends DataPacket{
	const NETWORK_ID = Info::SET_COMMANDS_ENABLED_PACKET;
	
	public $enabled;
	
	public function decode(){
	
	}
	
	public function encode(){
		$this->reset();
		$this->putBool($this->enabled);
	}

}