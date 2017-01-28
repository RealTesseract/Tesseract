<?php



namespace pocketmine\item;


class DragonsBreath extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::DRAGONS_BREATH, 0, $count, "Dragon's Breath");
	}

}