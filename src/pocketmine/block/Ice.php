<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;


class Ice extends Transparent{

	protected $id = self::ICE;

	public function __construct(){

	}

	public function getName() : string{
		return "Ice";
	}

	public function getHardness() {
		return 0.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function onBreak(Item $item){
		if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) === 0){
			$this->getLevel()->setBlock($this, new Water(), true);
		}
		return true;
	}

	public function getDrops(Item $item) : array {
		if($item->getEnchantmentLevel(Enchantment::TYPE_MINING_SILK_TOUCH) > 0){
			return [
				[Item::ICE, 0, 1],
			];
		}else{
			return [];
		}
	}
}
