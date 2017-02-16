<?php



namespace pocketmine\item;

use pocketmine\entity\Effect;


interface FoodSource{
	public function getResidue();
	
	public function getFoodRestore() : int;

	public function getSaturationRestore() : float;

	/**
	 * @return Effect[]
	 */
	public function getAdditionalEffects() : array;
	
	
}
