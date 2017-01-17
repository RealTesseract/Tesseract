<?php


namespace pocketmine\item;


class ShulkerShell extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SHULKER_SHELL, 0, $count, "Shulker Shell");
	}

}