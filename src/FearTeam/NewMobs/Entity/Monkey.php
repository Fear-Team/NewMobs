<?php

namespace FearTeam\NewMobs\Entity;

use FearTeam\NewMobs\Main;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\item\Item;
use pocketmine\math\Vector3;

class Monkey extends Human{

    /** @var float */
    public $height = 1.8;

    /** @var float */
    public $width = 0.6;

    /** @var int */
    public $tick = 0;

    /**
     * @param Skin $skin
     */
    public function setSkin(Skin $skin) : void{
        parent::setSkin(new Skin($skin->getSkinId(), $skin->getSkinData(), '', 'geometry.monkey', file_get_contents(Main::getInstance()->getDataFolder() . "Mobs/Geometry/Monkey.json")));
    }

    /**
     * @return array
     */
    public function getDrops(): array{
        $config = Main::getInstance()->onSettings();
        $item = [];

        foreach ($config->getNested("Monkey.Drops") as $dropsitem){
            $explode = explode(",", $dropsitem);
            $id = $explode[0];
            $meta = $explode[1];
            $count  = $explode[2];
            $item[] = Item::get($id, $meta, $count);
        }

        return $item;
    }

    /**
     * @return float
     */
    public function getSpeed(){
        return 1.0;
    }

    /**
     * @param int $currentTick
     * @return bool
     */
    public function onUpdate(int $currentTick): bool{
        $this->tick++;
        $speed = $this->getSpeed() * 0.15;

        if ($this->tick >= 40 && $this->tick <= 49) {
            $this->move($this->motion->x, $this->motion->y, $this->motion->z);
        }
        if ($this->tick == 50){
            $rand = mt_rand(0, 1);
            switch ($rand){
                case 0:
                    $this->yaw = $this->yaw / 90;
                    $this->lookAt(new Vector3($this->x, $this->y, $this->z));
                    $this->motion->x = $speed * ($this->motion->x + 5);
                    break;
                case 1:
                    $this->yaw = $this->yaw * 90;
                    $this->lookAt(new Vector3($this->motion->x, $this->motion->y, $this->motion->z));
                    $this->motion->x = $speed * ($this->motion->x - 5);
                    break;
            }
            $this->tick = 0;
        }
        $this->updateMovement();
        return parent::onUpdate($currentTick);
    }
}
