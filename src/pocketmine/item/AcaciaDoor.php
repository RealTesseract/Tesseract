<?php


namespace pocketmine\item;

use pocketmine\block\Block;

class AcaciaDoor extends Door{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::ACACIA_DOOR_BLOCK);
		parent::__construct(self::ACACIA_DOOR, 0, $count, "Acacia Door");
	}
}