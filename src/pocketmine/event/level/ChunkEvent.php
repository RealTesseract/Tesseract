<?php



/**
 * Level related events
 */
namespace pocketmine\event\level;

use pocketmine\level\format\Chunk;

abstract class ChunkEvent extends LevelEvent{

	/** @var Chunk */
	private $chunk;

	/**
	 * @param Chunk $chunk
	 */
	public function __construct(Chunk $chunk){
		parent::__construct($chunk->getProvider()->getLevel());
		$this->chunk = $chunk;
	}

	/**
	 * @return Chunk
	 */
	public function getChunk(){
		return $this->chunk;
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "ChunkEvent";
	}

}