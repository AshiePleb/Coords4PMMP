<?php

declare(strict_types=1);

namespace Coords4PMMP;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat;

class ShowDisplayTask extends Task{
	private $player;
	private $mode;
	private $precision;

	public function __construct(Player $player, string $mode = "popup", int $precision = 1){
		$this->player = $player;
		$this->mode = $mode;
		$this->precision = $precision;
	}

	public function onRun(int $currentTick) : void{
		assert(!$this->player->isClosed());
		$location = TextFormat::BLUE . Utils::getFormattedCoords($this->precision, $this->player->getX(), $this->player->getY(), $this->player->getZ());

		switch($this->mode){
			case "tip":
				$this->player->sendTip($location);
				break;
			case "popup":
				$this->player->sendPopup($location);
				break;
			default:
				break;
		}
	}

}
