<?php



namespace pocketmine\block;

class RedstoneLamp extends Solid{
	protected $id = self::REDSTONE_LAMP;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 0;
	}

	public function getName() : string{
		return "Redstone Lamp";
	}
}
