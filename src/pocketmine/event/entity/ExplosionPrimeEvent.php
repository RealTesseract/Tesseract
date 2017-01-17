<?php



namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

/**
 * Called when a entity decides to explode
 */
class ExplosionPrimeEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	protected $force;
	private $blockBreaking;
	private $dropItem;

	/**
	 * @param Entity $entity
	 * @param float  $force
	 * @param bool   $dropItem
	 */
	public function __construct(Entity $entity, $force, bool $dropItem){
		$this->entity = $entity;
		$this->force = $force;
		$this->blockBreaking = true;
		$this->dropItem = $dropItem;
	}

	public function setDropItem(bool $dropItem){
		$this->dropItem = $dropItem;
	}

	public function dropItem() : bool{
		return $this->dropItem;
	}

	/**
	 * @return float
	 */
	public function getForce(){
		return $this->force;
	}

	public function setForce($force){
		$this->force = (float) $force;
	}

	/**
	 * @return bool
	 */
	public function isBlockBreaking(){
		return $this->blockBreaking;
	}

	/**
	 * @param bool $affectsBlocks
	 */
	public function setBlockBreaking($affectsBlocks){
		$this->blockBreaking = (bool) $affectsBlocks;
	}

}