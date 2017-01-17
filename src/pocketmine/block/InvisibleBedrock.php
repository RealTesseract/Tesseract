<?php


namespace pocketmine\block;

use pocketmine\item\Item;

class InvisibleBedrock extends Transparent{

	protected $id = self::INVISIBLE_BEDROCK;

	public function __construct(){

	}

	public function getName() : string{
		return "Invisible Bedrock";
	}

	public function getHardness() {
		return -1;
	}

	public function getResistance(){
		return 18000000;
	}

	public function isBreakable(Item $item){
		return false;
	}

}
