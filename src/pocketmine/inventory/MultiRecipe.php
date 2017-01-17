<?php


namespace pocketmine\inventory;

use pocketmine\utils\UUID;

class MultiRecipe{

	private $uuid;

	public function __construct(UUID $uuid){
		$this->uuid = $uuid;
	}

}