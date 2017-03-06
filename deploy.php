<?php

$deploy = shell_exec('cd ~/www/dance-rush.ru && git reset --hard && git pull origin master 2>&1');

print_r($deploy);