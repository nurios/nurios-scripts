<?php
namespace Core;
class Controller
{
  private $__type;
  public $__blockedTypes = array();
  public $__excludeUri = array();
  public $requests;


  function __construct(){
    $this->requests = explode('/',$_SERVER['REQUEST_URI']);
    ini_set("expose_php","off");

    $model_libs = scandir(MODEL_FOLDER);

    foreach($model_libs as $lib){
      if($lib != ".." && $lib != "." && !in_array($lib,$this->__excludeUri)){
        require_once MODEL_FOLDER.$lib;
      }
    }

    $url = explode('/',$_SERVER['REQUEST_URI']);
    $this->appName = $url[1];
    $type = explode(".",$url[2]);
    $this->action = $type[0];
    $this->actionType = $type[1];
  }

  function getHelper($name){
    include(CORE_FOLDER.'helpers/'.$name.'.php');
  }

}
?>
