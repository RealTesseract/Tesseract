<?php

namespace pocketmine\block;
use pocketmine\item\Item;
use pocketmine\item\Tool;
class DragonEgg extends Solid{
	protected $id = self::DRAGON_EGG;
	public function __construct(){
	}
	public function getName(){
		return "Dragon Egg";
	}
	public function getHardness(){
		return -1;
	}
	
	public function getResistance(){
		return 18000000;
	}
	public function isBreakable(Item $item){
		return false;
	}
}
