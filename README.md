# Xcapher

A library to escape any value written in PHP

## Description

The goal of this class is to make it easy to escape or transform a variable into another type to either enforce, check or change it.

### Example

```php
echo x('12test')->int(); //12
echo x([1, 2])->int(); //1
echo print_r(x([1, 2])->object(), true); //stdClass Object ( [0] => 1 [1] => 2 )
echo x('https://test.com/')->urlEncode(); //https%3A%2F%2Ftest.com%2F
echo x('<div>test</div>')->htmlEntityEncode(); //&lt;div&gt;test&lt;/div&gt;
```
