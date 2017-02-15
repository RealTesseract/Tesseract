<?php


 
namespace pocketmine\tile;

use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BeaconDelayedCheckTask extends Task {
	
	private $pos;
	private $levelId;
	
	public function __construct(Vector3 $pos, $levelId) {
		$this->pos = $pos;
		$this->levelId = $levelId;
	}
	
	public function onRun($currentTick) {
		$level = Server::getInstance()->getLevel($this->levelId);
		if (!Server::getInstance()->isLevelLoaded($level->getName()) || !$level->isChunkLoaded($this->pos->x >> 4, $this->pos->z >> 4)) return;
		$tile = $level->getTile($this->pos);
		if ($tile instanceof Beacon) {
			$tile->scheduleUpdate();
		}
	}
}