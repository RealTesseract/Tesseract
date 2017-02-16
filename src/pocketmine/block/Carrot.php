<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\enchantment\enchantment;

class Carrot extends Crops{

	protected $id = self::CARROT_BLOCK;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Carrot Block";
	}

	public function getDrops(Item $item) : array {
		$drops = [];
		if($this->meta >= 0x07){
			$fortunel = $item->getEnchantmentLevel(Enchantment::TYPE_MINING_FORTUNE);
			$fortunel = $fortunel > 3 ? 3 : $fortunel;
			$drops[] = [Item::CARROT, 0, mt_rand(1, 4 + $fortunel)];
		}else{
			$drops[] = [Item::CARROT, 0, 1];
		}
		return $drops;
	}
}
