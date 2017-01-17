<?php


namespace pocketmine\item;


class BeetrootSoup extends Food{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BEETROOT_SOUP, 0, $count, "Beetroot Soup");
	}
	
	public function getMaxStackSize() : int{
		return 1;
	}
	
	public function getFoodRestore() : int{
		return 6;
	}

	public function getSaturationRestore() : float{
		return 7.2;
	}
	
	public function getResidue(){
		return Item::get(Item::BOWL);
	}

	
}