<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$deploy = shell_exec('cd ~/www/dance-rush.ru && git pull origin master');

print_r($deploy);
print 'ok';