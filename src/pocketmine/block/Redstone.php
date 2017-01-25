<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Redstone extends RedstoneSource{

	protected $id = self::REDSTONE_BLOCK;

	public function __construct(){

	}

	public function getBoundingBox() {
		return Block::getBoundingBox();
	}

	public function canBeFlowedInto(){
		return false;
	}

	public function isSolid(){
		return true;
	}

	public function isActivated(Block $from = null){
		return true;
	}

	public function getHardness() {
		return 5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName() : string{
		return "Block of Redstone";
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::REDSTONE_BLOCK, 0, 1],
			];
		}else{
			return [];
		}
	}
}
