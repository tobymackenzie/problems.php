<?php
class MontyHallGame{
	protected $doorCount = 3;
	protected $hostDoorCount = 1;
	protected $carDoor;
	protected $playerDoor;
	protected $newPlayerDoor;
	protected $hostDoors = Array();

	protected $switchedFromCar;
	protected $switchedToCar;
	public function __construct($opts = Array()){
		//--opts
		if(isset($opts['doorCount'])){
			$this->doorCount = $opts['doorCount'];
		}
		if(isset($opts['hostDoorCount'])){
			$this->hostDoorCount = $opts['hostDoorCount'];
		}

		//--game
		//---put car behind door
		$this->carDoor = mt_rand(1,$this->doorCount);
		//---player selects door
		$this->playerDoor = mt_rand(1,$this->doorCount);
		//---host selects door(s)
		$randModifier = ($this->carDoor === $this->playerDoor) ? $this->doorCount - 1 : $this->doorCount - 2;
		for($i = 0; $i < $this->hostDoorCount; ++$i){
			$this->hostDoors[$i] = mt_rand(1, $randModifier);
			if($this->hostDoors[$i] === $this->playerDoor){
				++$this->hostDoors[$i];
			}
			while($this->hostDoors[$i] === $this->playerDoor || $this->hostDoors[$i] === $this->carDoor){
				++$this->hostDoors[$i];
			}
		}
		//---determine if player switch would move away from car
		$this->switchedFromCar = ($this->carDoor === $this->playerDoor);
		//---determine if player switch would move to car
		$this->newPlayerDoor = mt_rand(1, $this->doorCount - 2);
		while($this->newPlayerDoor === $this->playerDoor || in_array($this->newPlayerDoor, $this->hostDoors)){
			++$this->newPlayerDoor;
		}
		$this->switchedToCar = ($this->newPlayerDoor === $this->carDoor);
	}
	public function getSwitchedFromCar(){
		return $this->switchedFromCar;
	}
	public function getSwitchedToCar(){
		return $this->switchedToCar;
	}
}
