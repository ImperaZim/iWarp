<?php

namespace iWarp\Eventos\WarpEvents;

use iWarp\Loader;
use pocketmine\utils\Config;

class WarpList {

 public function __construct($user) {
  $player = $user;
  $plugin = Loader::getInstance();
  $config = new Config($plugin->getDataFolder() . "warps.yml");
  $config = $config->getAll();
  
  $message = $plugin->getConfig(); 
  
  $warps = "";
  foreach ($config as $warp => $name){
   $name = ", §b{$warp}§7"; $warps .= "$name";
  }
  $warps = substr($warps, 2);
  
  if(count($config) <= 0) {
   $player->sendMessage($plugin->getProcessedTags($message->get("command.list.nowarps"), $warps)); 
   return;
  }
  
  $player->sendMessage($plugin->getProcessedTags($message->get("command.list.warps"), $warps)); 
  
 }

} 
