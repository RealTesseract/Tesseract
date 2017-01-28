<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class Netherrack extends Solid{

	protected $id = self::NETHERRACK;

	public function __construct(){

	}

	public function getName() : string{
		return "Netherrack";
	}

	public function getHardness() {
		return 0.4;
	}

	public function getResistance(){
		return 2;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::NETHERRACK, 0, 1],
			];
		}else{
			return [];
		}
	}
}