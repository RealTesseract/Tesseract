<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class IronDoor extends Door{

	protected $id = self::IRON_DOOR_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Iron Door Block";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness() {
		return 5;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::IRON_DOOR, 0, 1],
			];
		}else{
			return [];
		}
	}

	public function onActivate(Item $item, Player $player = null){
		if($player instanceof Player) return true;
		else return parent::onActivate($item, $player);
	}
}