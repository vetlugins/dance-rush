<?php

$deploy = shell_exec('cd ~/www/dance-rush.ru && git pull origin master');

print_r($deploy);
print 'ok';