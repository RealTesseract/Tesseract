<?php



namespace pocketmine\block;

class IronTrapdoor extends Trapdoor {
	protected $id = self::IRON_TRAPDOOR;

	public function getName() : string{
		return "Iron Trapdoor";
	}

	public function getHardness() {
		return 5;
	}

	public function getResistance(){
		return 25;
	}

}