<?php

namespace Matthww\PlayerSizer;

use Matthww\PlayerInfo\Utils\SpoonDetector;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;


class PlayerSizer extends PluginBase implements Listener {

    protected $target;
    protected $scale;

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->notice("is enabled");
        SpoonDetector::printSpoon($this, 'spoon.txt');
    }

    public function onDisable() {
        $this->getLogger()->notice("is disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        if (strtolower($command->getName()) == "size") {
            if ($sender->hasPermission("playersizer.other")) {
                if (isset($args[0]) and (isset($args[1]))) {
                    if ($this->getServer()->getPlayer($args[0])) {
                        if ($args[1])
                            $this->target = $this->getServer()->getPlayer($args[0]);
                        $this->scale = $args[1];
                        if ($this->scale <= 20) {
                            $this->target->setScale($this->scale);
                            $sender->sendMessage("§6Resized §f" . $this->target->getDisplayName() . " §6to §e" . $this->scale);
                            return true;
                        } else {
                            $sender->sendMessage("§cThe maximum size is §e20§c!");
                        }
                    } else {
                        $sender->sendMessage("§c[Error] Player not found");
                    }
                } else {
                    if (!isset($args[0])) {
                        return false;
                    }
                }
            }
            if ($sender->hasPermission("playersizer.use")) {
                if (is_numeric($args[0])) {
                    if ($sender instanceof Player) {
                        $sender->setScale($args[0]);
                        $sender->sendMessage("§6Resized to §e" . $args[0]);
                        return true;
                    } else {
                        $sender->sendMessage("§c[Error] Please specify a player");
                    }
                } else {
                    $sender->sendMessage("§cYou need to type in a number!");
                }
            }
        }
        return true;
    }
}

