<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class AvailableCommandsPacket extends DataPacket{
	const NETWORK_ID = Info::AVAILABLE_COMMANDS_PACKET;

	public $commands; //JSON-encoded command data
	public $unknown;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putString($this->commands);
		$this->putString($this->unknown);
	}

}