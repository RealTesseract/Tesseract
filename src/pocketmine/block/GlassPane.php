<?php


namespace pocketmine\block;


use pocketmine\item\Item;
use pocketmine\item\enchantment\enchantment;

class GlassPane extends Thin{

	protected $id = self::GLASS_PANE;

	public function __construct(){

	}

	public function getName() : string{
		return "Glass Pane";
	}

	public function getHardness() {
		return 0.3;
	}

	public function getDrops(Item $item) : array {
		if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0){
			return [
				[Item::GLASS_PANE, 0, 1],
			];
		}else{
			return [];
		}
	}
}
