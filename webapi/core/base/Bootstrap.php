<?php
namespace Core;
class Bootstrap
{
  
  public $__excludeUri=array(
    'Bootstrap.php',
    'favicon.ico',
    'index.php'
  );

  function err($msg){
    echo $msg;
  }

  function __construct(){
    $this->autoLoadLibs();
    $this->__server();
  }

  function autoLoadLibs(){
    $base_libs = scandir(CORE_FOLDER.'base/');

    foreach($base_libs as $lib){
      if($lib != ".." && $lib != "." && !in_array($lib,$this->__excludeUri)){
        require_once CORE_FOLDER.'base/'.$lib;
      }
    }

    $controller_libs = scandir(CONTROLLER_FOLDER);

    foreach($controller_libs as $lib){
      if($lib != ".." && $lib != "." && !in_array($lib,$this->__excludeUri)){
        require_once CONTROLLER_FOLDER.$lib;
      }
    }
  }

  function __server(){
    $url = explode('/',$_SERVER['REQUEST_URI']);
    $app = $url[1];
    if(class_exists($app)){
      $ht = new $app();
      	$action = $url[2];
        if($action){
          $action = explode(".",$action);
          if(isset($action[1]) && !in_array($action[1],$ht->__blockedTypes)){
            switch($action[1]){
              case 'json':
                $action = $action[0];
                echo json_encode($ht->$action());
                break;
              case 'xml':
                $out = $ht->$action[0]();
                $xml = new \SimpleXMLElement('<root/>');
                if(is_array($out)){
                  array_walk_recursive($out, array ($xml, 'addChild'));
                  echo $xml->asXML();
                }else{
                  echo $ht->$action[0]();
                }
                break;
              case 'html':
                echo $ht->$action[0]();
                break;
              default:
                echo $ht->$action[0]();
                break;
            }
          return true;
        }
      }
    }else{
      $app = HOME_CONTROLLER;
      $ht = new $app();
      echo $ht->index();
     
    }
  }
}
?>
