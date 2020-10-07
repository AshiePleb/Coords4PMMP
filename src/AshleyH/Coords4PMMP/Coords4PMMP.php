<?php

declare(strict_types=1);

namespace AshleyH\Coords4PMMP;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\TaskHandler;
use pocketmine\utils\TextFormat;

class Coords4PMMP extends PluginBase implements Listener{
	private $tasks = [];
	private $refreshRate = 1;
	private $mode = "popup";

	private $precision = 1;

	public function onEnable() : void{
	$this->getLogger()->info("Successfully enabled!");
	$this->getLogger()->info("Was created and maintained by Ashley H, please report any bugs/issues to https://github.com/AshleyHunter01/Coords4PMMP/issues");
		if($this->refreshRate < 1){
			$this->refreshRate = 1;
		}

		if($this->mode !== "popup"){
			$this->mode = "popup";
		}
		if($this->precision < 0){
			$this->precision = 1;
		}

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onDisable() : void{
	$this->getLogger()->info("Successfully disabled!");
	$this->getLogger()->info("Was created and maintained by Ashley H, please report any bugs to https://github.com/AshleyHunter01/Coords4PMMP/issues");
		$this->tasks = [];
	}

	public function onCommand(CommandSender $sender, Command $command, string $aliasUsed, array $args) : bool{
		if($command->getName() === "coords"){
			if(!($sender instanceof Player)){
				$sender->sendMessage("[Coords4PMMP] This command can only be used in-game!");

				return true;
			}

			if(!isset($this->tasks[$sender->getName()])){
				$this->tasks[$sender->getName()] = $this->getScheduler()->scheduleRepeatingTask(new ShowDisplayTask($sender, $this->mode, $this->precision), $this->refreshRate);
				$sender->sendMessage(TextFormat::GREEN . "[Coords4PMMP] Successfully enabled!");
			}else{
				$this->stopDisplay($sender->getName());
				$sender->sendMessage(TextFormat::RED . "[Coords4PMMP] Successfully disabled!");
			}

			return true;
		}

		return false;
	}

	private function stopDisplay(string $playerFor) : void{
		if(isset($this->tasks[$playerFor])){
			$this->getScheduler()->cancelTask($this->tasks[$playerFor]->getTaskId());
			unset($this->tasks[$playerFor]);
		}
	}

	public function onPlayerQuit(PlayerQuitEvent $event) : void{
		$this->stopDisplay($event->getPlayer()->getName());
	}
}
