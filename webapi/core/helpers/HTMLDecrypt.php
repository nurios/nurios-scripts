<?php
class HTMLDecrypt
{
  public $array;
  private $dom;
  private $data;
  private $target;

  function __construct($target){
    $this->target = $target;
    $this->data = file_get_contents($target);
    $this->dom = new DOMDocument();
    $this->dom->loadHTML($this->data);
  }

  public function getTag($tag){
    return $this->dom->getElementsByTagName($tag);
  }

  public function compile($for){
    if(@isset($for)){
      switch($for){
        case 'spider':
          $this->_tags();
          $this->_urls();
          $this->_title();
          break;
        case 'content':
          $this->_headers();
          $this->_parags();
          $this->_divs();
          $this->_title();
          break;
      }
    }else{
      $this->_tags();
      $this->_urls();
      $this->_headers();
      $this->_parags();
      $this->_divs();
      $this->_title();
    }
  }

  public function _urls(){
    $a = $this->getTag('a');
    foreach($a as $b){
      if($b->getAttribute('href')!="" || $b->getAttribute('href')!=null){
        $testDomain = explode("/",$b->getAttribute('href'));
        if(!$testDomain[0]){
          $this->array['url'][] = $this->target.$b->getAttribute('href');
        }else{
          $this->array['url'][] = $b->getAttribute('href');
        }
      }
    }
  }

  public function _headers(){
    for($i=0;$i<=10;$i++){
      $h = $this->getTag('h'.$i);
      foreach($h as $header){
        $this->array['h'.$i][] = $header->textContent;
      }
    }

    /*
    $h1 = $this->getTag('h1');
    foreach($h1 as $b){
      $this->array['h1'][] = $b->textContent;
      //var_dump($b);
    }*/
  }

  public function _parags(){
    $p = $this->getTag('p');
    foreach($p as $b){
      $this->array['p'][] = $b->textContent;
    }
  }

  public function _divs(){
    $div = $this->getTag('div');
    foreach($div as $b){
      if($b->getAttribute('id')){
        $this->array['div'][$b->getAttribute('id')] = $b->textContent;
      }else if($b->getAttribute('class')){
        $this->array['div'][$b->getAttribute('class')] = $b->textContent;
      }

    }
  }

  public function _tags(){
    $meta = $this->getTag('meta');
    foreach($meta as $m){
      if($m->getAttribute('name') == "keywords"){
        $keywords = explode(",",$m->getAttribute('content'));
        foreach($keywords as $word){
          $words[] = trim($word);
        }
        $this->array['keywords'] = $words;
      }else if($m->getAttribute('name') == "description"){
        $this->array['desc'] = $m->getAttribute('content');
      }
    }
  }

  public function _title(){
    $p = $this->getTag('title');
    foreach($p as $b){
      $this->array['title'] = $b->textContent;
    }
  }

  public function toArray(){
    return $this->array;
  }

  public function toText(){
    return $this->data;
  }
}
?>
