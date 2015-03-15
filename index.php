<?php
include 'shared.php';

$defaults = array('edit' => '', 'uuid' => '');
$input = array_intersect_key($_GET, $defaults) + $defaults;
list($first, $rest) = explode('/', $input['edit'], 2) + array('','');

if(file_exists($parser = "parsers/{$first}.php")) {
	include $parser;
} else {
	$parsers = glob('parsers/*.php');
	echo '<ul>';
	foreach($parsers as $parser) {
		$name = basename($parser, '.php');
		echo "<li><a href=\"?edit={$name}\">{$name}</a></li>";
	}
	echo '</ul>';
}