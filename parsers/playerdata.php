<?php
if($input['name']) {
	$names = json_decode(file_get_contents("{$world}/../whitelist.json"));

	foreach($names as $elem) {
		if($input['name'] == $elem->name) {
			$data = $nbt->loadFile("{$world}/playerdata/{$elem->uuid}.dat");
			break;
		}
	}

	if(isset($data))
		printNBT($data);
	else
		echo "That user was not found";
} else {
	$names = json_decode(file_get_contents("{$world}/../whitelist.json"));
	echo '<ul>';
	foreach($names as $elem) {
		if(file_exists("{$world}/playerdata/{$elem->uuid}.dat")) {
			echo "<li><a href=\"?edit=playerdata&name={$elem->name}\">{$elem->name}</a></li>";
		}
	}
	echo '</ul>';
}
