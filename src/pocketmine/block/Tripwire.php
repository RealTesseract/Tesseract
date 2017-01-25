<?php



namespace pocketmine\block;

use pocketmine\item\Tool;

class Tripwire extends Transparent{

	protected $id = self::TRIPWIRE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Tripwire";
	}

	public function getToolType(){
		return Tool::TYPE_SHEARS;
	}

	public function getHardness(){
		return 0;
	}

	public function getResistance(){
		return 0;
	}

}
