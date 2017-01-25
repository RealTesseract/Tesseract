<?php



namespace pocketmine\resourcepacks;

class ResourcePackInfoEntry{
	protected $packId; //UUID
	protected $version;
	protected $packSize;

	public function __construct(string $packId, string $version, $packSize){
		$this->packId = $packId;
		$this->version = $version;
		$this->packSize = $packSize;
	}

	public function getPackId() : string{
		return $this->packId;
	}

	public function getVersion() : string{
		return $this->version;
	}

	public function getPackSize(){
		return $this->packSize;
	}

}