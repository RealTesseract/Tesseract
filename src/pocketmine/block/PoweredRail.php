<?php



namespace pocketmine\block;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;

class PoweredRail extends Solid{

	protected $id = self::POWERED_RAIL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "PoweredRail";
	}
}