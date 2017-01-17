<?php


namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\enchantment\enchantment;

class Snow extends Solid{

	protected $id = self::SNOW_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() {
		return 0.2;
	}

	public function getName() : string{
		return "Snow Block";
	}
	
	public function getDrops(Item $item) : array {
		if($item->isShovel() !== false){
			if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0){
				return [
					[Item::SNOW_BLOCK, 0, 1],
				];
			}else{
				return [
					[Item::SNOWBALL, 0, 4],
				];
			}
		}else{
			return [];
		}
	}
}
