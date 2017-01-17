<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class NetherBrick extends Solid{

	protected $id = self::NETHER_BRICKS;

	public function __construct(){

	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName() : string{
		return "Nether Bricks";
	}

	public function getHardness() {
		return 2;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::NETHER_BRICKS, 0, 1],
			];
		}else{
			return [];
		}
	}
}