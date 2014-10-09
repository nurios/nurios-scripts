<?php
class PublicData
{
  public static function image($filename,$type){
    header("Content-type: image/$type");
    return file_get_contents(PUBLIC_FOLDER.$filename);
  }

  public static function text($filename,$type){
    header("Content-type: text/$type");
    return file_get_contents(PUBLIC_FOLDER.$filename);
  }
}
?>
