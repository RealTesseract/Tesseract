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

class ConnectPacket extends DataPacket{
	const NETWORK_ID = Info::CONNECT_PACKET;

	public $protocol = Info::CURRENT_PROTOCOL;
	public $maxPlayers;
	public $isMainServer;
	public $description;
	public $password;

	public function encode(){
		$this->reset();
		$this->putInt($this->protocol);
		$this->putInt($this->maxPlayers);
		$this->putByte($this->isMainServer ? 1 : 0);
		$this->putString($this->description);
		$this->putString($this->password);
	}

	public function decode(){
		$this->protocol = $this->getInt();
		$this->maxPlayers = $this->getInt();
		$this->isMainServer = ($this->getByte() == 1) ? true : false;
		$this->description = $this->getString();
		$this->password = $this->getString();
	}

}