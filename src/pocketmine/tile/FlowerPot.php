<?php



namespace pocketmine\tile;

use pocketmine\item\Item;
use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;

class FlowerPot extends Spawnable{

	public function __construct(Chunk $chunk, CompoundTag $nbt){
		if(!isset($nbt->item) or !($nbt->item instanceof ShortTag)){
			$nbt->item = new ShortTag("item", 0);
		}
		if(!isset($nbt->mData) or !($nbt->mData instanceof IntTag)){
			$nbt->mData = new IntTag("mData", 0);
		}
		parent::__construct($chunk, $nbt);
	}

	public function getItem() : Item{
		return Item::get((int) ($this->namedtag["item"] ?? 0), (int) ($this->namedtag["mData"] ?? 0));
	}

	public function setItem(Item $item){
		$this->namedtag["item"] = $item->getId();
		$this->namedtag["mData"] = $item->getDamage();
		$this->onChanged();
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::FLOWER_POT),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z),
			$this->namedtag->item,
			$this->namedtag->mData
		]);
	}
}
