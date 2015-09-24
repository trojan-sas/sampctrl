<?php

// Find your project ID on your about page!!! Example: https://revctrl.com/IrresistibleDev/SF-CNR/about
$projectId = 2; 

// If you want to change what each revision type is (maybe put your own language), you can change it here:
$revisionTypes = [
	'addition' 		=> "added\t", 
	'removal'		=> "removed", 
	'change'		=> "changed", 
	'fix'			=> "fixed\t"
];

// Fetch project information
$jsonData = json_decode(file_get_contents("https://www.revctrl.com/api/projects/" . $projectId), true);

// Check if project information is there
if ($jsonData)
{
	// Fetch only the latest changelog part of the request
	$latestChangelog = $jsonData['latest_changelog'];

	// This variable will fundamentally style your dialog ($changelogString)
	$changelogString = "{FFFFFF}Here are latest changes for the most recent update " . $latestChangelog['version']  . ", rolled out on " . $latestChangelog['updated_at'] . ".\n\n";
	
	// This variable only stores the recent revisions just so they are seperated from old.
	$latestRevisionsString = null;

	// Loop through all revisions
	foreach ($latestChangelog['revisions'] as $key) {
		// Format revision
		$revisionString = $revisionTypes[$key['type']] . "{FFFFFF}\t" . html_entity_decode(strip_tags($key['revision'])) . "\n";

		if ($key['is_recent']) {
			$latestRevisionsString .= "{00B33C}" . $revisionString; // List recent revisions seperately for users
		} else {
			$changelogString .= "{C0C0C0}" . $revisionString; // Lump up all the old revisions together.
		}
	}

	// List all recent revisions seperately
	if (is_null($latestRevisionsString) == false) {
		$changelogString .= "\nA few revisions were also recently added within the past 24 hours!\n\n" . $latestRevisionsString;
	}

	echo $changelogString . "\nPlease make sure to follow " . $jsonData['codename'] . " on {C0C0C0}www.revctrl.com/" . $jsonData['creator'] . "/" . $jsonData['codename'] . "{FFFFFF} to stay always up to date!";
} else {
	echo "Latest project information could not be found. Please double check your RevCTRL project ID.";
}
