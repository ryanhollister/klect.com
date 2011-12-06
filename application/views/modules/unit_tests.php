<?php

//$results = shell_exec()
chdir('tests');
echo nl2br(shell_exec('/Applications/MAMP/bin/php/php5.3.6/bin/phpunit'));

?>

<?php 
chdir('..');
?>