<?php



namespace pocketmine\event\player;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

class PlayerGlassBottleEvent extends PlayerEvent implements Cancellable{

    public static $handlerList = null;

    /** @var Block */
    private $target;
    /** @var Item */
    private $item;

    /**
     * @param Player $Player
     * @param Block  $target
     * @param Item   $itemInHand
     */
    public function __construct(Player $Player, Block $target, Item $itemInHand){
        $this->player = $Player;
        $this->target = $target;
        $this->item = $itemInHand;
    }
    
    /**
     * @return Item
     */
    public function getItem(){
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item){
        $this->item = $item;
    }

    /**
     * @return Block
     */
    public function getBlock(){
        return $this->target;
    }

	/**
	 * @return EventName
	 */
	public function getName(){
		return "PlayerGlassBottleEvent";
	}

}