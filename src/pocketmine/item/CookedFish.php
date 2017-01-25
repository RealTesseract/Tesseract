<?php



namespace pocketmine\item;

class CookedFish extends Fish{
	public function __construct($meta = 0, $count = 1){
		Food::__construct(self::COOKED_FISH, $meta, $count, $meta === self::FISH_SALMON ? "Cooked Salmon" : "Cooked Fish");
	}

	public function getFoodRestore() : int{
		return $this->meta === self::FISH_SALMON ? 6 : 5;
	}

	public function getSaturationRestore() : float{
		return $this->meta === self::FISH_SALMON ? 9.6 : 6;
	}
}
