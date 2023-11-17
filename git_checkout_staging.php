<?php
// Git Checkout Staging

$command = 'git checkout staging';

// Execute the Git command
$output = array();
$returnCode = 0;
exec($command, $output, $returnCode);

// Output the results
echo "Git Checkout Staging:\n";
echo "Output: " . implode("\n", $output) . "\n";
echo "Return Code: " . $returnCode . "\n";
?>
