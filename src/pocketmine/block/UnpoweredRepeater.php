<?php



namespace pocketmine\block;

use pocketmine\item\Item;

class UnpoweredRepeater extends PoweredRepeater{
	protected $id = self::UNPOWERED_REPEATER_BLOCK;

	public function getName() : string{
		return "Unpowered Repeater";
	}

	public function onBreak(Item $item){
		$this->getLevel()->setBlock($this, new Air(), true);
	}
}