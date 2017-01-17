<?php


namespace pocketmine\block;

class AcaciaWoodStairs extends WoodStairs{

	protected $id = self::ACACIA_WOOD_STAIRS;

	public function getName() : string{
		return "Acacia Wood Stairs";
	}
}