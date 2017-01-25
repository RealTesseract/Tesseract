<?php



namespace pocketmine\event\player;

use pocketmine\entity\Human;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerExhaustEvent extends PlayerEvent implements Cancellable{

	public static $handlerList = null;

	const CAUSE_ATTACK = 1;
	const CAUSE_DAMAGE = 2;
	const CAUSE_MINING = 3;
	const CAUSE_HEALTH_REGEN = 4;
	const CAUSE_POTION = 5;
	const CAUSE_WALKING = 6;
	const CAUSE_SNEAKING = 7;
	const CAUSE_SWIMMING = 8;
	const CAUSE_JUMPING = 10;
	const CAUSE_CUSTOM = 11;

	const CAUSE_FLAG_SPRINT = 0x10000;

	/** @var float */
	private $amount;

	public function __construct(Human $human, float $amount, int $cause){
		$this->player = $human;
		$this->amount = $amount;
	}

	/**
	 * @return Human|Player
	 */
	public function getPlayer(){
		return $this->player;
	}

	public function getAmount() : float{
		return $this->amount;
	}

	public function setAmount(float $amount){
		$this->amount = $amount;
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "PlayerExhaustEvent";
	}

}
