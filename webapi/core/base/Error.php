<?php
namespace Core;
class Error extends \Exception
{
	public static function error($e,$a=array(
		'output' => 'print',
		'start' => '%start%',
		'end' => '%end%'
	)){
		switch($a['output']){
			case 'print':
				break;
		}
	}
}
?>
