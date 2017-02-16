<?php



namespace pocketmine\item;

class ItemString extends Item {
	public function __construct($meta = 0, $count = 1) {
		parent::__construct(self::STRING, $meta, $count, "String");
	}

}