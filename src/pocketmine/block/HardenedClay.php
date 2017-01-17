<?php


namespace pocketmine\block;


use pocketmine\item\Tool;

class HardenedClay extends Solid{

	protected $id = self::HARDENED_CLAY;

	public function __construct(){

	}

	public function getName() : string{
		return "Hardened Clay";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness() {
		return 1.25;
	}
}