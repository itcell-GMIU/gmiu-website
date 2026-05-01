<?php
// Set the vCard file path
$vcardFile = 'contact_v_card.vcf';

// Set the appropriate headers
header('Content-Type: text/vcard');
header('Content-Disposition: attachment; filename="contact_v_card.vcf"');
header('Content-Length: ' . filesize($vcardFile));

// Output the vCard file
readfile($vcardFile);
?>