<?php
if($input['uuid']) {
	$data = $nbt->loadFile("{$world}/playerdata/{$input['uuid']}.dat");

	printNBT($data);
} else {
	$names = json_decode(file_get_contents("{$world}/../whitelist.json"));
	echo '<ul>';
	foreach($names as $elem) {
		echo "<li><a href=\"?edit=playerdata&uuid={$elem->uuid}\">{$elem->name}</a></li>";
	}
}
