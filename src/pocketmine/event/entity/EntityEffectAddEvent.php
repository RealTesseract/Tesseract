<?php



namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\Event;
use pocketmine\event\Cancellable;
use pocketmine\entity\Effect;

class EntityEffectAddEvent extends EntityEvent implements Cancellable{

	public static $handlerList = null;

	/** @var Effect */
	protected $effect;

	public function __construct(Entity $entity, Effect $effect){
		$this->entity = $entity;
		$this->effect = $effect;
	}

	/**
	 * @return Effect
	 */
	public function getEffect(){
		return $this->effect;
	}
}
