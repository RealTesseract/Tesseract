<?php



namespace pocketmine\item;

class Melon extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MELON, $meta, $count, "Melon");
	}

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}
}

