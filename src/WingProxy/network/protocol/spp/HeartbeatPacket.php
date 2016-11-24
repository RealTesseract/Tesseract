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

class HeartbeatPacket extends DataPacket{
	const NETWORK_ID = Info::HEARTBEAT_PACKET;

	public $tps;
	public $load;
	public $upTime;

	public function encode(){
		$this->reset();
		$this->putFloat($this->tps);
		$this->putFloat($this->load);
		$this->putLong($this->upTime);
	}

	public function decode(){
		$this->tps = $this->getFloat();
		$this->load = $this->getFloat();
		$this->upTime = $this->getLong();
	}
}