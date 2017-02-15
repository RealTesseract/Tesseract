<?php



namespace pocketmine\tile;

use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\{ByteTag, CompoundTag, IntTag, StringTag};

class Skull extends Spawnable{

	const TYPE_SKELETON = 0;
	const TYPE_WITHER = 1;
	const TYPE_ZOMBIE = 2;
	const TYPE_HUMAN = 3;
	const TYPE_CREEPER = 4;
	const TYPE_DRAGON = 5;

	public function __construct(Chunk $chunk, CompoundTag $nbt){
		if(!isset($nbt->SkullType) or !($nbt->SkullType instanceof ByteTag)){
			$nbt->SkullType = new ByteTag("SkullType", self::TYPE_SKELETON);
		}
		if(!isset($nbt->Rot) or !($nbt->Rot instanceof ByteTag)) {
			$nbt->Rot = new ByteTag("Rot", 0);
		}
		parent::__construct($chunk, $nbt);
	}

	public function setType(int $type){
		if($type >= 0 && $type <= 4){
			$this->namedtag->SkullType = new ByteTag("SkullType", $type);
			$this->onChanged();
			return true;
		}
		return false;
	}

	public function getType() {
		return $this->namedtag["SkullType"];
	}

	public function saveNBT(){
		parent::saveNBT();
		unset($this->namedtag->Creator);
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::SKULL),
			$this->namedtag->SkullType,
			$this->namedtag->Rot,
			new IntTag("x", (int)$this->x),
			new IntTag("y", (int)$this->y),
			new IntTag("z", (int)$this->z),
		]);
	}
}
