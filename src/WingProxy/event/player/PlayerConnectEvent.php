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

use WingProxy\Player;

class PlayerConnectEvent extends PlayerEvent{
	public static $handlerList = null;

	/** @var bool */
	private $firstTime;

	public function __construct(Player $player, bool $firstTime = true){
		$this->player = $player;
		$this->firstTime = $firstTime;
	}

	/**
	 * Gets if the player is first time login
	 *
	 * @return bool
	 */
	public function isFirstTime() : bool{
		return $this->firstTime;
	}
}