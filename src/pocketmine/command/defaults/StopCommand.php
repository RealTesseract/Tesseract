<?php



namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;


class StopCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.stop.description",
			"%pocketmine.command.stop.usage"
		);
		$this->setPermission("pocketmine.command.stop");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		$restart = false;
		if(isset($args[0])){
			if($args[0] == 'force'){
				$restart = true;
				array_shift($args);
			}else{
				$restart = false;
			}
		}
		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.stop.start"));
		$msg = implode(" ", $args);
		$sender->getServer()->shutdown($restart, $msg);

		return true;
	}
}