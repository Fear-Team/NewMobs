<?php

namespace NewMobs\Listener;

use NewMobs\Entity\EntityManager;
use NewMobs\Entity\{Giraffe, Gorilla, Monkey};
use NewMobs\NewMobs;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{IntTag, StringTag, CompoundTag, ByteArrayTag};
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as C;

class NewMobsEventListener implements Listener{

    /** @var NewMobs */
    private $plugin;

    /**
     * NewMobsEventListener constructor.
     * @param NewMobs $plugin
     */
    public function __construct(NewMobs $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerInteractEvent $e
     */
    public function interactEvent(PlayerInteractEvent $e){
        $p = $e->getPlayer();
        $item = $e->getItem();
        $block = $e->getBlock();
        $action = $e->getAction();
        $config = $this->plugin->onSettings();
        $mobsitem = $config->get("Mobs-Item");
        $explode = explode(",", $mobsitem);
        $manager = new EntityManager($this->plugin);

        if ($action == PlayerInteractEvent::RIGHT_CLICK_BLOCK){
            if ($item->getId() == $explode[0] && $item->getDamage() == $explode[1] && $item->getLore() == ["NewMobs"]){
                $mobsname = C::clean($item->getCustomName());
                $explodename = explode(" ", $mobsname);

                switch ($explodename[0]){
                    case "Gorilla":
                        $nbt = $manager->gorillaSkin($block);
                        $npc = new Gorilla($p->getLevel(), $nbt);
                        $npc->spawnToAll();
                        break;
                    case "Monkey":
                        $nbt = $manager->monkeySkin($block);
                        $npc = new Monkey($p->getLevel(), $nbt);
                        $npc->spawnToAll();
                        break;
                    case "Giraffe":
                        $nbt = $manager->giraffeSkin($block);
                        $npc = new Giraffe($p->getLevel(), $nbt);
                        $npc->spawnToAll();
                        break;
                }

                $item->setCount(1);
                $p->getInventory()->removeItem($item);
            }
        }
    }
}
