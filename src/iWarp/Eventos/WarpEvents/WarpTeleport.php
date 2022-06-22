<?php

namespace iWarp\Eventos\WarpEvents;

use iWarp\Loader;
use pocketmine\Utils\Config;
use pocketmine\world\Position;

class WarpTeleport {

 private $warp;

 public function __construct($player, $warp) {
  $plugin = Loader::getInstance();
  $data = $plugin->getDataFolder();
  $config = new Config($data . "warps.yml");
  $warps = $config->getAll();
  
  $message = $plugin->getConfig();
  
  if(isset($warps[$warp])){
   $world = $plugin->getServer()->getWorldManager()->getWorldByName($warps[$warp]["world"]);
   $plugin->getServer()->getWorldManager()->loadWorld($warps[$warp]["world"]); 
   $x = (int)$warps[$warp]["position"]["PosX"]; 
   $y = (int)$warps[$warp]["position"]["PosY"]; 
   $z = (int)$warps[$warp]["position"]["PosZ"];
   $permission = $warps[$warp]["permission"];
   $permissiable = $warps[$warp]["permission"];
   
   if($player->hasPermission($permission) == true){
    $permission = "true";
   }else{
    $permission = "false";
    if($permissiable == null){
     $permission = "true";
    }
    if($plugin->getServer()->isOp($player->getName()) == true ){
     $permission = "true";
    }
   }
   
   if($permission == "true"){
    $player->teleport(new Position($x, $y, $z, $world));
    $player->sendMessage($plugin->getProcessedTags($message->get("command.teleport.sucess"), $warp));
   }else{
    $player->sendMessage($plugin->getProcessedTags($message->get("command.teleport.nopermission"), $warp));
   }
  }else{
   $player->sendMessage($plugin->getProcessedTags($message->get("command.teleport.unknow"), $warp));
  }
 }
 
}
