<?php



namespace pocketmine\item;

class RawPorkchop extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_PORKCHOP, $meta, $count, "Raw Porkchop");
	}
	
	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 0.6;
	}

}

