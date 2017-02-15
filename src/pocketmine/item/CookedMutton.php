<?php


 
namespace pocketmine\item;

class CookedMutton extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKED_MUTTON, $meta, $count, "Cooked Mutton");
	}
	
	public function getFoodRestore() : int{
		return 6;
	}

	public function getSaturationRestore() : float{
		return 9.6;
	}

}

