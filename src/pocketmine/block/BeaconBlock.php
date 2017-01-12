<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Pocketmine Team
 * @link http://www.pocketmine.net
 * 
 *
*/

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\block\Solid;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Tile;
use pocketmine\math\Vector3;

 class BeaconBlock extends Transparent implements SolidLight{
 
 	protected $id = self::BEACON_BLOCK;
 
 	public function __construct($meta = 0){
 		$this->meta = $meta;
 	}
 
 	public function canBeActivated() : bool{
 		return false;
 	}
 
 	public function getName(){
 		return "Beacon";
 	}
 
 	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
 		$this->getLevel()->setBlock($this, $this, true, true);
 		$nbt = new CompoundTag("", [
 			new StringTag("id", Tile::BEACON),
 			new IntTag("x", $block->x),
 			new IntTag("y", $block->y),
 			new IntTag("z", $block->z)
 		]);
 		$pot = Tile::createTile(Tile::BEACON, $this->getLevel()->getChunk($this->x >> 4, $this->z >> 4), $nbt);
 		return true;
 	}
 }
