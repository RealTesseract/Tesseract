<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class WoodStairs extends Stair{

	protected $id = self::WOOD_STAIRS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Wood Stairs";
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getDrops(Item $item) : array {
		return [
			[$this->id, 0, 1],
		];
	}

	public function getBurnChance() : int{
		return 5;
	}

	public function getBurnAbility() : int{
		return 20;
	}

	public function getHardness() {
		return 2;
	}
}