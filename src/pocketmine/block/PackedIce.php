<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;


class PackedIce extends Solid {

	protected $id = self::PACKED_ICE;

	public function __construct() {

	}

	public function getName() : string{
		return "Packed Ice";
	}

	public function getHardness() {
		return 0.5;
	}

	public function getToolType() {
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item) : array {
		if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0){
			return [
				[Item::PACKED_ICE, 0, 1],
			];
		}else{
			return [];
		}
	}
} 
