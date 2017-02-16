<?php

namespace pocketmine\command\defaults;

use pocketmine\network\protocol\TransferPacket;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\Player;

class TransferCommand extends VanillaCommand{
	
    public function __construct($name){
        parent::__construct(
        $name,
        "%pocketmine.command.transfer.description",
        "%pocketmine.command.transfer.usage",
        ["transfer"]
        );
        $this->setPermission("pocketmine.command.transfer");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args){

        if(!$sender instanceof Player){

            $sender->sendMessage("Run command in-game");
            return;
        }
        if(!isset($args[0]) || !isset($args[1])){

            $sender->sendMessage("Please provide a ip and port. /transferserver <ip> <port>");
            return;
        }

        $sender->sendMessage("Transferring you to $args[0]".":".$args[1]);
        $pk = new TransferPacket();
        $pk->address = $args[0];
        $pk->port = $args[1];
        $sender->dataPacket($pk);
}
    }