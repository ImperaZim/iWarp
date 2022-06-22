<?php

namespace iWarp;

use pocketmine\ {
 Server,
 Utils\Config,
 player\Player,
 Plugin\plugin,
 Plugin\pluginbase,
 Utils\TextFormat as C,
};

class Loader extends pluginbase {

 public static $instance = null;

 public static function getInstance() : Loader {
  return self::$instance;
 }

 public function onEnable() : void {
  self::$instance = $this;
  $this->loadWorlds();
  $this->getWarpEvents();
  $this->registerCommands();
  $this->getConfig()->get("command.permission");
  $this->getLogger()->info(C::GREEN . "Plugin iWarp ativado!");
 }

 public function onDisable() : void {
  self::$instance = $this;
  $this->getLogger()->info(C::GREEN . "Plugin iWarp desativado!");
 }
 
 public function registerCommands() {
  $map = $this->getServer()->getCommandMap();
		$map->register("warp", new Commands\WarpCommand($this));   
 }
 
 public function getWarpEvents() {
  return new Eventos\WarpEvents();
 }
 
 public function getProcessedTags($message, $warp = null) {
  $tags = ["{warp}", "{warps}", "{prefix}"];
  $processed = [$warp, $warp, "§l§bWARP§r"];
  $message = str_replace($tags, $processed, $message);
  return $message;
 }
 
 public function loadWorlds(){
  $levelNamesArray = scandir($this->getServer()->getDataPath() . "worlds/");
  foreach($levelNamesArray as $levelName){
   if($levelName === "." || $levelName === ".."){continue;}
   $this->getServer()->getWorldManager()->loadWorld($levelName);
  } $levels = $this->getServer()->getWorldManager()->getWorlds(); 
 }  

}
