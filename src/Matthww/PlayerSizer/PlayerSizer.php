<?php

namespace Matthww\PlayerSizer;

use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class PlayerSizer extends PluginBase implements Listener{
	const MAX_SIZE = 20;

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		if(strtolower($command->getName()) == "size"){
			if(isset($args[0])){
				if(isset($args[0]) && isset($args[1])){
					if($sender->hasPermission("playersizer.other")){
						if(is_numeric($args[1])){
							if(($player = $this->getServer()->getPlayer($args[0])) instanceof Player){
								if($args[1] <= self::MAX_SIZE){
									$player->setScale($args[1]);
									$sender->sendMessage(TF::GOLD."Resized ".TF::WHITE.$player->getDisplayName().TF::GOLD." to ".TF::YELLOW.$args[1]);
									return true;
								}else{
									$sender->sendMessage(TF::RED."The maximum size is ".TF::YELLOW.self::MAX_SIZE.TF::RED."!");
								}
							}else{
								$sender->sendMessage(TF::RED."Player '".$args[1]."' not found");
							}
						}
					}else{
						$sender->sendMessage(TF::RED."You have no permission to set the size of other players!");
					}
				}else{
					if($sender->hasPermission("playersize.use")){
						if($sender instanceof Player){
							if(is_numeric($args[0])){
								if($args[1] <= self::MAX_SIZE){
									$sender->setScale($args[0]);
									$sender->sendMessage(TF::GOLD."Resized to ".TF::YELLOW.$args[0]);
								}else{
									$sender->sendMessage(TF::RED."The maximum size is ".TF::YELLOW.self::MAX_SIZE.TF::RED."!");
								}
							}
						}
					}else{
						$sender->sendMessage(TF::RED."You have no permission to set the size of yourself!");
					}
				}
			}else{
				return false;
			}
		}
		return true;
	}
}