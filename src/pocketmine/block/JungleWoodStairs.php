<?php



namespace pocketmine\block;

class JungleWoodStairs extends WoodStairs{

	protected $id = self::JUNGLE_WOOD_STAIRS;

	public function getName() : string{
		return "Jungle Wood Stairs";
	}
}