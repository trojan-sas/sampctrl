<?php

$projectId = 1; // Find your project ID on your about page!!! Example: https://revctrl.com/IrresistibleDev/SF-CNR/about

$jsonData = json_decode(file_get_contents("https://www.revctrl.com/api/projects/" . $projectId), true);

if ($jsonData) {
	$latestChangelog = $jsonData['latest_changelog'];

	$changesetString = "{FFFFFF}Here are latest changes for the most recent update " . $latestChangelog['version']  . ", rolled out on " . $latestChangelog['updated_at'] . ".\n\n";

	foreach ($latestChangelog['revisions'] as $key) {
		// adds an extra tab to short revision types
		$extraTab = strlen($key['type']) < 7 ? "\t" : "";

		// appends revision after revision
		$changesetString .= "{C0C0C0}" . $key['type'] . "{FFFFFF}\t" . $extraTab . html_entity_decode(strip_tags($key['revision'])) . "\n";
	}

	$changesetString .= "\nPlease make sure to follow " . $jsonData['codename'] . " on {C0C0C0}www.revctrl.com/" . $jsonData['creator'] . "/" . $jsonData['codename'] . "{FFFFFF} to stay always up to date!";

	echo $changesetString;
}
