<?php


namespace pocketmine\level\generator\hell;

use pocketmine\level\generator\biome\Biome;

class HellBiome extends Biome{

	public function getName() : string{
		return "Hell";
	}

	public function getColor(){
		return 0;
	}
}
