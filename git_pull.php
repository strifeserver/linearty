<?php
// Git Pull

$command = 'git pull';

// Execute the Git command
$output = array();
$returnCode = 0;
exec($command, $output, $returnCode);

// Output the results
echo "Git Pull:\n";
echo "Output: " . implode("\n", $output) . "\n";
echo "Return Code: " . $returnCode . "\n";
?>
