<?php
require '../vendor/autoload.php';

echo 'String to int: ' . x('12test')->int() . PHP_EOL . '<br>';
echo 'Array to int: ' . x([1, 2, 3, 4])->int() . PHP_EOL . '<br>';
echo 'Array to object: ' . print_r(x([1, 2, 3, 4])->object(), true) . PHP_EOL . '<br>';
echo 'URL endcode: ' . x('https://test.com/')->urlEncode() . PHP_EOL . '<br>';
echo 'HTML entities: ' . x('<div>test</div>')->htmlEntityEncode() . PHP_EOL . '<br>';
