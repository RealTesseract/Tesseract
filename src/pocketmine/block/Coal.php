<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Coal extends Solid{

	protected $id = self::COAL_BLOCK;

	public function __construct(){

	}

	public function getHardness() {
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getBurnChance() : int{
		return 5;
	}

	public function getBurnAbility() : int{
		return 5;
	}

	public function getName() : string{
		return "Coal Block";
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::COAL_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}