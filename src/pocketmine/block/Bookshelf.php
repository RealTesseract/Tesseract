<?php


namespace pocketmine\block;


use pocketmine\item\Item;
use pocketmine\item\Tool;

class Bookshelf extends Solid{

	protected $id = self::BOOKSHELF;

	public function __construct(){

	}

	public function getName() : string{
		return "Bookshelf";
	}

	public function getHardness() {
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getBurnChance() : int{
		return 30;
	}

	public function getBurnAbility() : int{
		return 20;
	}

	public function getDrops(Item $item) : array{
		return [
			[Item::BOOK, 0, 3]
		];
	}

}