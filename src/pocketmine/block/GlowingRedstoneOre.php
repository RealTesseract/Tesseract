<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;

class GlowingRedstoneOre extends RedstoneOre implements SolidLight{

	protected $id = self::GLOWING_REDSTONE_ORE;

	public function getName() : string{
		return "Glowing Redstone Ore";
	}

	public function getLightLevel(){
		return 9;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_SCHEDULED or $type === Level::BLOCK_UPDATE_RANDOM){
			$this->getLevel()->setBlock($this, Block::get(Item::REDSTONE_ORE, $this->meta), false, false);

			return Level::BLOCK_UPDATE_WEAK;
		}

		return false;
	}

}