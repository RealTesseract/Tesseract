<?php


namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerToggleGlideEvent extends PlayerEvent implements Cancellable{

	public static $handlerList = null;
	/** @var bool */
	protected $isGliding;
	public function __construct(Player $player, $isGliding){
		$this->player = $player;
		$this->isGliding = (bool) $isGliding;
	}
	public function isGliding(){
		return $this->isGliding;
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "PlayerToggleGlideEvent";
	}

}
