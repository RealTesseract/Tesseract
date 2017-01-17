<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class IronOre extends Solid{

	protected $id = self::IRON_ORE;

	public function __construct(){

	}

	public function getName() : string{
		return "Iron Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness() {
		return 3;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 3){
			return [
				[Item::IRON_ORE, 0, 1],
			];
		}else{
			return [];
		}
	}
}