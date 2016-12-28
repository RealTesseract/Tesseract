<?php

namespace pocketmine\block;

use pocketmine\Server;

use pocketmine\Player;

use pocketmine\item\Armor;

# use pocketmine\item\elytra; NOTE: Should I seperate it?

class Elytra extends Armor {

public function __construct($meta = 0, $count = 1){
	
  parent::__construct(444, $meta, $count, "Elytra");
	
  }
	public function getArmorTier(){
		return false;
	}
	public function getArmorType(){
		return Armor::TYPE_CHESTPLATE;
	}
	public function getMaxDurability(){
		return false; //SOMEONE HELP HERE! IDK WHAT TO DO!
	}
	public function getArmorValue(){
		return 0;
	}
	public function isChestplate(){
		return true;
	}
}
