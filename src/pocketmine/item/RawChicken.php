<?php


namespace pocketmine\item;

use pocketmine\entity\Effect;

class RawChicken extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::RAW_CHICKEN, $meta, $count, "Raw Chicken");
	}

	public function getFoodRestore() : int{
		return 2;
	}

	public function getSaturationRestore() : float{
		return 1.2;
	}
	
	public function getAdditionalEffects() : array{
		$chance = mt_rand(0, 100);
		if($chance >= 70){
			return [Effect::getEffect(Effect::HUNGER)->setDuration(30 * 20)];
		}else{
			return [];
		}
	}
}

