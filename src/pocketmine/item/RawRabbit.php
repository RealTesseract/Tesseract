<?php


 
namespace pocketmine\item;

class RawRabbit extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_RABBIT, $meta, $count, "Raw Rabbit");
	}
	
	public function getFoodRestore() : int{
		return 3;
	}

	public function getSaturationRestore() : float{
		return 1.8;
	}

}

