<?php



namespace pocketmine\block;

class ActivatorRail extends Solid {

    protected $id = self::ACTIVATOR_RAIL;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function getName() : string {
        return "Activator Rail";
    }
}
