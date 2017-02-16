<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class PoweredRepeater extends Solid {
	protected $id = self::POWERED_REPEATER_BLOCK;

	const ACTION_ACTIVATE = "Repeater Activate";
	const ACTION_DEACTIVATE = "Repeater Deactivate";

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Powered Repeater";
	}

	public function canBeActivated() : bool{
		return true;
	}

	public function getDrops(Item $item) : array{
		return [
			[Item::REPEATER, 0, 1]
		];
	}
}
