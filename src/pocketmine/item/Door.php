<?php


 
 namespace pocketmine\item;
 
 abstract class Door extends Item{
	public function getMaxStackSize() : int {
		return 64;
	}
}