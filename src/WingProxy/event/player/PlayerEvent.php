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
 
namespace WingProxy\event\player;

use WingProxy\event\Event;

abstract class PlayerEvent extends Event{
	/** @var \WingProxy\Player */
	protected $player;

	public function getPlayer(){
		return $this->player;
	}
}