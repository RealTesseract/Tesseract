<?php


 
namespace pocketmine\block;

class RedSandstone extends Sandstone{
	protected $id = Block::RED_SANDSTONE;
	
	public function getName() : string{
		static $names = [
			0 => "Red Sandstone",
			1 => "Chiseled Red Sandstone",
			2 => "Smooth Red Sandstone",
			3 => "",
		];
		return $names[$this->meta & 0x03];
	}
}