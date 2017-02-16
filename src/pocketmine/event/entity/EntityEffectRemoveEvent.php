<?php



namespace pocketmine\event\entity;

use pocketmine\entity\Entity;

use pocketmine\event\Cancellable;
use pocketmine\entity\Effect;

class EntityEffectRemoveEvent extends EntityEvent implements Cancellable{

	public static $handlerList = null;

	/** @var Effect */
	protected $effect;

	public function __construct(Entity $entity, int $effect){
		$this->entity = $entity;
		$this->effect = $effect;
	}

	/**
	 * @return Effect
	 */
	public function getEffect(){
		return $this->effect;
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "EntityEffectRemoveEvent";
	}

}
