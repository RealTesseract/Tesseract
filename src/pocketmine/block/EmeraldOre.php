<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\item\enchantment\enchantment;

class EmeraldOre extends Solid{

	protected $id = self::EMERALD_ORE;

	public function __construct(){

	}

	public function getName() : string{
		return "Emerald Ore";
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getHardness() {
		return 3;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 4){
			if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0){
				return [
					[Item::EMERALD_ORE, 0, 1],
				];
			}else{
				$fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
				$fortunel = $fortunel > 3 ? 3 : $fortunel;
				$times = [1,1,2,3,4];
				$time = $times[mt_rand(0, $fortunel + 1)];
				return [
					[Item::EMERALD, 0, $time],
				];
			}
		}else{
			return [];
		}
	}
}
