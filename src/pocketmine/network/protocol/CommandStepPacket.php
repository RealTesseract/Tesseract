<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

class CommandStepPacket extends DataPacket{
	const NETWORK_ID = Info::COMMAND_STEP_PACKET;

	/**
	 * unknown (string)
	 * unknown (string)
	 * unknown (uvarint)
	 * unknown (uvarint)
	 * unknown (bool)
	 * unknown (uvarint64)
	 * unknown (string)
	 * unknown (string)
	 * https://gist.github.com/dktapps/8285b93af4ca38e0104bfeb9a6c87afd
	 */

	public $command;
	public $overload;
	public $uvarint1;
	public $uvarint2;
	public $bool;
	public $uvarint64;
	public $args; //JSON formatted command arguments
	public $string4;

	public function decode(){
		$this->command = $this->getString();
		$this->overload = $this->getString();
		$this->uvarint1 = $this->getUnsignedVarInt();
		$this->uvarint2 = $this->getUnsignedVarInt();
		$this->bool = (bool) $this->getByte();
		$this->uvarint64 = $this->getUnsignedVarInt(); //TODO: varint64
		$this->args = json_decode($this->getString());
		$this->string4 = $this->getString();
		while(!$this->feof()){
			$this->getByte(); //prevent assertion errors. TODO: find out why there are always 3 extra bytes at the end of this packet.
		}
	}

	public function encode(){

	}

}