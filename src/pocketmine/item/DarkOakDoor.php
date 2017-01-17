<?php


namespace pocketmine\item;

use pocketmine\block\Block;

class DarkOakDoor extends Door{
	public function __construct($meta = 0, $count = 1){
		$this->block = Block::get(Item::DARK_OAK_DOOR_BLOCK);
		parent::__construct(self::DARK_OAK_DOOR, 0, $count, "Dark Oak Door");
	}
}