# Regex trong PHP


## Hàm `preg_match`
```php
$pattern = "/php/i";
$string = "I love PHP programming.";
if (preg_match($pattern, $string, $matches)) {
    echo "Match found: " . $matches[0];
} else {
    echo "No match found.";
}
```

## Hàm `preg_replace`
```php
$pattern = "/cat/i";
$replacement = "dog";
$string = "The cat sat on the mat.";
$result = preg_replace($pattern, $replacement, $string);
echo $result;
```

## Hàm `preg_split`
```php
$pattern = "/[\s,]+/";
$string = "apple, banana orange,grape";
$fruits = preg_split($pattern, $string);
print_r($fruits);
```