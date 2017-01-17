<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\enchantment\enchantment;

class Wheat extends Crops{

	protected $id = self::WHEAT_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Wheat Block";
	}

	public function getDrops(Item $item) : array {
		$drops = [];
		if($this->meta >= 0x07){
			$fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
			$fortunel = $fortunel > 3 ? 3 : $fortunel;
			$drops[] = [Item::WHEAT, 0, 1];
			$drops[] = [Item::WHEAT_SEEDS, 0, mt_rand(0, 3 + $fortunel)];
		}else{
			$drops[] = [Item::WHEAT_SEEDS, 0, 1];
		}

		return $drops;
	}
}
