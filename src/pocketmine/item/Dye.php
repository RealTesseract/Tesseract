<?php


namespace pocketmine\item;

use pocketmine\block\Block;

class Dye extends Item{
	const BLACK = 0;
	const RED = 1;
	const GREEN = 2;
	const BROWN = 3; const COCOA_BEANS = 3;
	const BLUE = 4; const LAPIS_LAZULI = 4;
	const PURPLE = 5;
	const CYAN = 6;
	const SILVER = 7; const LIGHT_GRAY = 7;
	const GRAY = 8;
	const PINK = 9;
	const LIME = 10;
	const YELLOW = 11;
	const LIGHT_BLUE = 12;
	const MAGENTA = 13;
	const ORANGE = 14;
	const WHITE = 15; const BONE_MEAL = 15;

	public function __construct($meta = 0, $count = 1) {
		if ($meta === 3) {
			$this->block = Block::get(Item::COCOA_BLOCK);
			parent::__construct(self::DYE, 3, $count, "Cocoa Beans");
		} else {
			parent::__construct(self::DYE, $meta, $count, $this->getNameByMeta($meta));
		}
	}

	public function getNameByMeta(int $meta) : string{
		switch($meta){
			case self::BLACK:
				return "Ink Sac";
			case self::RED:
				return "Rose Red";
			case self::GREEN:
				return "Cactus Green";
			case self::BROWN:
				return "Cocoa Beans";
			case self::BLUE:
				return "Lapis Lazuli";
			case self::PURPLE:
				return "Purple Dye";
			case self::CYAN:
				return "Cyan Dye";
			case self::SILVER:
				return "Light Gray Dye";
			case self::GRAY:
				return "Gray Dye";
			case self::PINK:
				return "Pink Dye";
			case self::LIME:
				return "Lime Dye";
			case self::YELLOW:
				return "Dandelion Yellow";
			case self::LIGHT_BLUE:
				return "Light Blue Dye";
			case self::MAGENTA:
				return "Magenta Dye";
			case self::ORANGE:
				return "Orange Dye";
			case self::WHITE:
				return "Bone Meal";
			default:
				return "Dye";
		}
	}
}
