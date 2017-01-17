<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class AcaciaDoor extends Door{

	protected $id = self::ACACIA_DOOR_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Acacia Door Block";
	}

	public function canBeActivated() : bool {
		return true;
	}

	public function getHardness() {
		return 3;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getDrops(Item $item) : array {
		return [
			[Item::ACACIA_DOOR, 0, 1],
		];
	}
}