<?php


 
namespace pocketmine\item;

class RawMutton extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_MUTTON, $meta, $count, "Raw Mutton");
	}
	
	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}

}

