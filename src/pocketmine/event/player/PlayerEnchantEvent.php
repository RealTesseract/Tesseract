<?php				
/*		
 *		
 *    _______                                _		
 *   |__   __|                              | |		
 *      | | ___  ___ ___  ___ _ __ __ _  ___| |_		
 *      | |/ _ \/ __/ __|/ _ \  __/ _` |/ __| __|		
 *      | |  __/\__ \__ \  __/ | | (_| | (__| |_		
 *      |_|\___||___/___/\___|_|  \__,_|\___|\__|		
 *		
 *		
 * This program is free software: you can redistribute it and/or modify		
 * it under the terms of the GNU Lesser General Public License as published by		
 * the Free Software Foundation, either version 3 of the License, or		
 * (at your option) any later version.		
 *		
 * @author Tesseract Team	& LinuxLogo	
 * @link http://www.github.com/TesseractTeam/Tesseract		
 * 		
 *		
 */

namespace pocketmine\event\player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\event\Cancellable;

class PlayerEnchantEvent extends PlayerEvent {
	
	public static $handlerList = null;
    
	private $enchantment;
	
	/**
	 * @param Item $item
	 */
	public function __construct(Item $item, Enchantment $enchantment){
		$this->item = $item;
        $this->enchantment = $enchantment;
		$this->player = null;
		
	}
	
	/**
	 * @return Enchantment
	 */
	public function getEnchantment() {
	return $this->enchantment;
	}
    
	public function getItem() {
		return $this->item;
	}
}
