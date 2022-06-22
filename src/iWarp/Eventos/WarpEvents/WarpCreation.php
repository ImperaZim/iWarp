<?php

namespace iWarp\Eventos\WarpEvents;

use iWarp\Loader;
use pocketmine\utils\Config;

class WarpCreation {

 private $warp;
 private $path;
 private $world;
 private $position;
 private $permission;

 public function __construct($player, $warp, $world, $position, $permission, $path) {
  $plugin = Loader::getInstance();
  $config = new Config($plugin->getDataFolder() . "warps.yml");
  $warps = $config->getAll();
  $data = $plugin->getDataFolder();
  
  $message = $plugin->getConfig(); 

  if (isset($warps[$warp])) {
   $player->sendMessage($plugin->getProcessedTags($message->get("command.set.haswarp"), $warp));
  } else {
   $config = new Config($data . "warps.yml", Config::YAML, [
    "$warp" => [
     "name" => "$warp",
     "world" => "$world",
     "position" => [
      "PosX" => "$position[0]", 
      "PosY" => "$position[1]", 
      "PosZ" => "$position[2]"
     ],
     "permission" => "$permission",
     "path" => "$path",
    ],
   ]);
   $config->save();
   $player->sendMessage($plugin->getProcessedTags($message->get("command.set.sucess"), $warp)); 
  }

 }

}
