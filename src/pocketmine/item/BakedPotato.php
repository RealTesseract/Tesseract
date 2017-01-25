<?php



namespace pocketmine\item;

class BakedPotato extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BAKED_POTATO, $meta, $count, "Baked Potato");
	}

	public function getFoodRestore() : int{
		return 5;
	}

	public function getSaturationRestore() : float{
		return 7.2;
	}
}

