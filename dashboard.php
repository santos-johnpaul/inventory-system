<?php
// Include the template content
ob_start();
include ('template.php');
$templateContent = ob_get_clean();

// Echo the entire HTML content of the template
echo $templateContent;

// Additional content specific to the current page goes here
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">

</div>
</div>
</body>
</html>