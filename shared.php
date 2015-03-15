<!doctype html>
<head>
<style type="text/css">
.accord ul, .accord ul li {
	list-style-type: none;
}

.accord ul li {
	display: inline-block;
	min-width: 200px;
}
.accord ul li a {
	color: #6E440A;
	text-decoration: none;
}

.accord ul li:nth-child(odd) {
	background-color: #f2f2f2;
}

.accord ul li a:hover {
	color: #523205;
	text-decoration: underline;
}

.accord ul li span {
	color: red;
	margin-left: 10%;
	cursor: pointer;	
}

.pl-20 {
	padding-left: 3%;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		// Add 'expand' class to 'li' tags having 'ul' tag inside them and initially hiding content 
		$('.accord ul li:has(ul)').addClass('expand').find('ul').hide();
		// Add '<span>[ + ]</span>' after anchor inside 'li' tags those have 'expand' class
		$('.accord ul li.expand>a').after('<span>[ + ]</span>');
		
		// Change [ - ] with [ + ] and  'collapse' class with 'expand' and sliding content upward
		$('.accord ul').on('click', 'li.collapse span ', function (e) {
			$(this).text('[ + ]').parent().addClass('expand').removeClass('collapse').find('>ul').slideUp();
			e.stopImmediatePropagation();
		});

		// Change [ + ] with [ - ] and 'expand' class with 'collapse' class and sliding content downward
		$('.accord ul').on('click', 'li.expand span', function (e) {
			$(this).text('[ - ]').parent().addClass('collapse').removeClass('expand').find('>ul').slideDown();
			e.stopImmediatePropagation();
		});
		
		// Preventing rest of handlers from being execute
		$('.accord ul').on('click', 'li.collapse li:not(.collapse)', function (e) {
			e.stopImmediatePropagation();
		});		
	});
</script>
</head><body>
<?php
$world = 'C:\AT\Instances\Viper7sRR\saves\New World-';

include 'PHP-NBT-Decoder-Encoder/nbt.class.php';

$nbt = new NBT();

function printNBT($nbt, $recursing = false) {
	if(!$recursing) echo '<div class="accord"><ul>';
	echo '<li><a href="#">' . ($nbt['name'] ?: ($recursing ? 'NULL' : 'Root')) . '</a>';
	
	if(in_array($nbt['type'], array(7, 10, 11))) {
		echo '<ul>';
		foreach($nbt['value'] as $child) {
			if(is_array($child)) {
				printNBT($child, true);
			} else {
				echo '<li>';
				print_r($child);
				echo '</li>';
			}
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
	if(!$recursing) echo '</ul></div>';
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
		} elseif(is_array($child) && count($child)) {
			printNBT($child, true);
		} else {
			echo '<li>';
			if(is_array($child)) echo 'NULL'; else print_r($child);
			echo '</li>';
		}
	}
	echo '</ul>';
}