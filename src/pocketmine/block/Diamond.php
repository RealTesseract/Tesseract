<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Diamond extends Solid{

	protected $id = self::DIAMOND_BLOCK;

	public function __construct(){

	}

	public function getHardness() {
		return 5;
	}

	public function getName() : string{
		return "Diamond Block";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 4){
			return [
				[Item::DIAMOND_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}