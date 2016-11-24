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

class FastPlayerListPacket extends DataPacket{
	const NETWORK_ID = Info::FAST_PLAYER_LIST_PACKET;

	const TYPE_ADD = 0;
	const TYPE_REMOVE = 1;

	/** @var UUID */
	public $sendTo;
	//REMOVE: UUID, ADD: UUID, entity id, name
	/** @var array[] */
	public $entries = [];
	public $type;

	/*public function clean(){
		$this->entries = [];
		return parent::clean();
	}*/

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putUUID($this->sendTo);
		$this->putByte($this->type);
		$this->putInt(count($this->entries));
		foreach($this->entries as $d){
			if($this->type === self::TYPE_ADD){
				$this->putUUID($d[0]);
				$this->putLong($d[1]);
				$this->putString($d[2]);
			}else{
				$this->putUUID($d[0]);
			}
		}
	}

}
