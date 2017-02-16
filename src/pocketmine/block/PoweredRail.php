<?php



namespace pocketmine\block;




class PoweredRail extends Solid{

	protected $id = self::POWERED_RAIL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "PoweredRail";
	}
}