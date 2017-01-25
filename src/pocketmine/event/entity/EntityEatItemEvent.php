<?php



namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\item\Food;
use pocketmine\item\Item;

class EntityEatItemEvent extends EntityEatEvent{
	public function __construct(Entity $entity, Food $foodSource){
		parent::__construct($entity, $foodSource);
	}

	/**
	 * @return Item
	 */
	public function getResidue(){
		return parent::getResidue();
	}

	public function setResidue($residue){
		if(!($residue instanceof Item)){
			throw new \InvalidArgumentException("Eating an Item can only result in an Item residue");
		}
		parent::setResidue($residue);
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "EntityEatItemEvent";
	}

}
