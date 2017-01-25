<?php



namespace pocketmine\item;


class ChorusFruit extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::CHORUS_FRUIT, 0, $count, "Chorus Fruit");
	}

	public function getFoodRestore() : int{
		return 4;
	}

	public function getSaturationRestore() : float{
		return 2.4;
	}

}