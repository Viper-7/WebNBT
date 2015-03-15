<?php
$world = 'C:\AT\Instances\Viper7sRR\saves\New World-';

include 'PHP-NBT-Decoder-Encoder/nbt.class.php';

$nbt = new NBT();

function printNBT($nbt, $recursing = false) {
	if(!$recursing) echo '<ul>';
	echo '<li>' . ($nbt['name'] ?: 'NULL') . '(' . $nbt['type'] . ')';
	
	if(in_array($nbt['type'], array(7, 10, 11))) {
		echo '<ul>';
		foreach($nbt['value'] as $element) {
			printNBT($element, true);
		}
		echo '</ul>';
	} elseif($nbt['type'] == 9) {
		if(count($nbt['value'])) {
			if(isset($nbt['value'][0])) {
				printList($nbt['value']);
			}
		}
	} else {
		echo ' : ';
		print_r($nbt['value']);
	}
	
	echo '</li>';
	if(!$recursing) echo '</ul>';
}

function printList($list) {
	echo '<ul>';
	foreach($list as $child) {
		if(isset($child[0])) {
			echo '<li>';
			if(isset($child[0]['name']) && $child[0]['name'] == 'V') {
				echo $child[0]['value'] . ':' . $child[1]['value'];
			} elseif(isset($child[0]['name']) && $child[0]['name'] == 'ModVersion') {
				echo $child[1]['value'] . ':' . $child[0]['value'];
			} else {
				printList($child);
			}
			echo '</li>';
		} else {
			printNBT($child);
		}
	}
	echo '</ul>';
}