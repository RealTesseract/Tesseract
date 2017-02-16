<?php



namespace pocketmine\item;

use pocketmine\block\Block;

class Repeater extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Block::UNPOWERED_REPEATER_BLOCK);
		parent::__construct(self::REPEATER, $meta, $count, "Repeater");
	}
}