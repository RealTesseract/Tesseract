<?php


namespace pocketmine\block;

class WetSponge extends Solid{

	protected $id = self::WetSponge;
	public function __construct(){
	}
	public function getResistance(){
		return 3;
	}
	public function getHardness(){
		return 0.6;
	}
	public function getName(){
		return "Wet Sponge";
	}
}
