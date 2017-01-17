<?php


namespace pocketmine\item;

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;

interface FoodSource{
	public function getResidue();
	
	public function getFoodRestore() : int;

	public function getSaturationRestore() : float;

	/**
	 * @return Effect[]
	 */
	public function getAdditionalEffects() : array;
	
	
}
