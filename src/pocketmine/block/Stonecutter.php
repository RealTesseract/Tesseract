<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

//TODO: check orientation
class Stonecutter extends Solid{

	protected $id = self::STONECUTTER;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Stonecutter";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::STONECUTTER, 0, 1],
			];
		}else{
			return [];
		}
	}
}