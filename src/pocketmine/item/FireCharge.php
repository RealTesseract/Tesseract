<?php

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\Fire;
use pocketmine\block\Solid;
use pocketmine\level\Level;
use pocketmine\Player;

class FireCharge extends Item
{
    public function __construct($meta = 0, $count = 1)
    {
        parent::__construct(self::FIRE_CHARGE, $meta, $count, "Fire Charge");
    }

    public function canBeActivated() : bool{
        return true;
    }

    public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz)
    {
        if ($block->getId() === self::AIR and ($target instanceof Solid)) {
            $level->setBlock($block, new Fire(), true);
            $this->useOn($block);
            return true;
        }
        return false;
    }

    public function useOn($object)
    {
        if ($object instanceof Block) {
            $this->count--;
            return true;
        } else return false;
    }
}