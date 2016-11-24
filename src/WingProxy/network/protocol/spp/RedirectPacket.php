<?php

/*
 __          ___             _____                     
 \ \        / (_)           |  __ \                    
  \ \  /\  / / _ _ __   __ _| |__) | __ _____  ___   _ 
   \ \/  \/ / | | '_ \ / _` |  ___/ '__/ _ \ \/ / | | |
    \  /\  /  | | | | | (_| | |   | | | (_) >  <| |_| |
     \/  \/   |_|_| |_|\__, |_|   |_|  \___/_/\_\\__, |
                        __/ |                     __/ |
                       |___/                     |___/ 
*/		
 
namespace WingProxy\network\protocol\spp;

use pocketmine\utils\UUID;

class RedirectPacket extends DataPacket{
	const NETWORK_ID = Info::REDIRECT_PACKET;

	/** @var UUID */
	public $uuid;
	public $direct;
	public $mcpeBuffer;

	public function encode(){
		$this->reset();
		$this->putUUID($this->uuid);
		$this->putByte($this->direct ? 1 : 0);
		$this->putString($this->mcpeBuffer);
	}

	public function decode(){
		$this->uuid = $this->getUUID();
		$this->direct = ($this->getByte() == 1) ? true : false;
		$this->mcpeBuffer = $this->getString();
	}
}