<?php
$setup = include 'config/setup.php';
$prefix = $setup['database']['prefix'] ? $setup['database']['prefix'] : '';
?>

--
-- Add active user boolean (for registration verification)
--

ALTER TABLE `<?= $prefix ?>users` ADD `active` int(1) NOT NULL DEFAULT 1;
