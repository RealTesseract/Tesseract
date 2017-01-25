<?php



namespace pocketmine\block;

use pocketmine\level\Level;

class StillLava extends Lava{

	protected $id = self::STILL_LAVA;

	public function onUpdate($type){
		if($type !== Level::BLOCK_UPDATE_SCHEDULED){
			return parent::onUpdate($type);
		}
		return false;
	}

	public function getName() : string{
		return "Still Lava";
	}

}
