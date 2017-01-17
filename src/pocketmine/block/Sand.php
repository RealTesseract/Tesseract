<?php


namespace pocketmine\block;


use pocketmine\item\Tool;

class Sand extends Fallable{
	
	const NORMAL = 0;
	const RED = 1;
	
	protected $id = self::SAND;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() {
		return 0.5;
	}

	public function getToolType(){
		return Tool::TYPE_SHOVEL;
	}

	public function getName() : string{
		if($this->meta === 0x01){
			return "Red Sand";
		}

		return "Sand";
	}

}