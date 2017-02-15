<?php



namespace pocketmine\item;

class SplashPotion extends Item{
	
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPLASH_POTION, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getMaxStackSize() : int{
		return 1;
	}
	
	public function getNameByMeta(int $meta){
		return "Splash ".Potion::getNameByMeta($meta);
	}

	
}