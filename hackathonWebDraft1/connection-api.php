<?php

$api= 'https://api.openweathermap.org/data/2.5/weather?id=1643084&appid=7d8ac3ece9ff8234482cfb57bcbbfa16';

$data = json_decode( file_get_contents($api),true);