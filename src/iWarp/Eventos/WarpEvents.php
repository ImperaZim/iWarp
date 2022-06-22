<?php

namespace iWarp\Eventos;

use iWarp\Loader;
use pocketmine\utils\Config;

use iWarp\Eventos\WarpEvents\{
 WarpTeleport,
 WarpCreation, 
 WarpDelete,
 WarpList,
};

class WarpEvents {
 
 public function __construct() {
  $plugin = Loader::getInstance(); 
  $config = new Config($plugin->getDataFolder() . "warps.yml"); 
  return $config;
  }
 
 public function create($player, $warp, $world, $position, $permission = null, $path = "") {
  return new WarpCreation($player, $warp, $world, $position, $permission, $path);
 }
 
 public function delete($player, $warp) { 
  return new WarpDelete($player, $warp); 
 }
 
 public function teleport($player, $warp) { 
  return new WarpTeleport($player, $warp); 
 }
 
 public function list($player) { return new WarpList($player); }
 
}
