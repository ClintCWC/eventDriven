<?php
by clint
free to use however you like, relys on jquery to work nicely.
//usage debug (array/object/str/variable/etc);
//usage debug ($array/object , 'strname'); $name of variable only need for clarity
$config['debug'] - true;
function debug($item, $item_name = '' ,$return = false){
	global $config;
	global $debug_count;
	$size = 0;
	try {$size = round((strlen(serialize($item))/1024),2).'kb';}catch (Exception $e) {}
	//try {$size = round((mb_strlen(serialize($item))/1024),2).'kb';}catch (Exception $e) {}
	
	if (!isset($debug_count)){
		$debug_count = 0;
		
		echo '
<script>
	if(!window.jQuery){
		document.write(\'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"><\/script>\');
		document.write(\'<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"><\/script>\');
	}
</script>
';
		echo '<link href="templates/css/CSSloader.php?CSSfile=https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">';
		
	}
	$string = '';
	$debug_count++;
	$item_name = ' ['.$item_name.']';
	$item_class = '';
	$backtrace = debug_backtrace();
	$item_type = ' ['.gettype(($backtrace[0]['args'][0])).']';
	//echo $backtrace[0]['args'][0];
	if (isset($backtrace[0]['args'][0])){
		if (is_object($backtrace[0]['args'][0])){
			$item_class =' [class='.get_class($backtrace[0]['args'][0]).']';
		}
	}
	else{
		$item_class = 'NULL';
	}
	
	
	//print_r($backtrace);
	
	if (isset($config['debug'])){
	  if ($config['debug']){
		if ($return){
			$string = '<pre>';
			if (is_bool($item)){
				$item ? $string .= 'true' : $string .= 'false';
			}
			else{
				$string .= print_r($item,true);
			}
			$string .= '</pre>';
			return $string;
		}else{
			if ($debug_count < 2){$string.= '<div class="debug_title debug_unselected">Debug Data</div>';}	
			$string .= '<br/ class = "debug_chunk hidden"><div class="debug_chunk hidden">';	
			$string .= '<div class="debug"><b>File: '.$backtrace[0]['file'].' | Line: '.$backtrace[0]['line'].'</b></div>';
			$string .= '<div class="debug"><b>Debug Data '.$item_type.$item_class.$item_name.' '.$size.'</b></div>';
			$string .= '<div class="debug">item count: '.count((array)$item).' | depth: '.depth($item).'</div>';
			$string .= '<div class="debug">';
			$string .= '<pre>';
			if (is_bool($item)){
				$item ? $string .= 'true' : $string .= 'false';
			}
			else{
				//ob_start();
				//var_dump($item);
				//$string .= ob_get_clean();
				$string .= print_r($item,true);
			}
			$string .= '</pre>';
			$string .= '</div>';
			$string .= '</div>';
			$css = '
<style>
.debug_chunk{
		display: inline-block;
		z-index:9999;
		font-family: arial!important;
		border-left: 20px solid #ccc;
		padding:20px;
		margin-left:30px;
		margin-bottom:10px;
		background-color:#eee;
		color:black;
		position:relative;
}
.debug {
	font-family: arial!important;
	margin-bottom:5px;	
}
.debug_data, .debug{
	font-family: arial!important;
	font-size:10px;
	clear:both;
}
	
.debug_title{
	font-family: arial!important;
	border-left: 20px solid #ccc;
	background-color:#eee;
	margin:5px 5px 10px 30px;
	display: inline-block;
	cursor:pointer;
	padding:5px;
}
.debug_unselected::after{
	 content:" ˃";	
}
.debug_selected::after{
	 content:" v";	
}
.hidden{
	display:none;	
}
</style>
';
		
if ($debug_count < 2){
	echo'	
<script>
$(document).ready(function(){
	//$(\'.debug_chunk\').toggleClass(\'hidden\'); //start off hidden
	$(\'.debug_title\').on( "click", function(){
		$(this).toggleClass(\'debug_selected\');
		$(this).toggleClass(\'debug_unselected\');
		$(\'.debug_chunk\').toggleClass(\'hidden\');
	});
});
</script>
';	
}
		
			echo $css;
			echo $string;
		}}//end if debug
	}
	
}
function depth($item) {
	$array = json_decode(json_encode($item), true);
	if(!is_array($array)){return 1;}
    $max_depth = 1;
    foreach ($array as $value) {
        if (is_array($value)) {
            $depth = depth($value) + 1;
            if ($depth > $max_depth) {
                $max_depth = $depth;
            }
        }
    }
    return $max_depth;
}
?>
