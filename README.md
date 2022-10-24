# intl-sort

A wrapper library for PHP Intl to sort values/objects based on rules of locales.

This library wraps the Collator class of the PHP Intl extension and offers a more fluid API without constant juggling
for you to sort your values or objects by country/locale specific standards.

[![Latest Stable Version](https://poser.pugx.org/senseexception/intl-sort/v/stable)](https://packagist.org/packages/senseexception/intl-sort)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/senseexception/intl-sort.svg)](https://packagist.org/packages/senseexception/intl-sort)
![Tests](https://github.com/SenseException/intl-sort/workflows/Tests/badge.svg)
![Static Analysis](https://github.com/SenseException/intl-sort/workflows/Static%20Analysis/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SenseException/intl-sort/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SenseException/intl-sort/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/SenseException/intl-sort/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SenseException/intl-sort/?branch=master)
[![License](https://poser.pugx.org/senseexception/intl-sort/license)](https://packagist.org/packages/senseexception/intl-sort)

### Why using this library?

PHP functions like `sort()` work most of the time when it comes to sort values,
but they don't return useful results when a country or language specific order of values is
needed like e.g. words with umlauts or other accents.

This library wraps the `Collator` class of the PHP Intl extension and offers a builder pattern
API to create a `Sorter` to sort values or value objects by the rules of a locale. You also can
implement your own sorting logic.

## Installation

You can install this with [Composer](https://getcomposer.org/).

```
composer require senseexception/intl-sort
```

### Examples

While PHP's own sort functions don't order the elements in a way that is expected in different
countries, intl-sort will sort them with the help of the Intl-extension appropriate for the
countries in your international project.

#### Ascending order

```php
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE');
$sorter = $sortBuilder->getSorter();

$sortedArray = $sorter->sort(['a', 'g', 'A', 'ß', 'ä', 'j', 'z']);

var_dump($sortedArray); // [0 => 'a', 2 => 'A', 4 => 'ä', 1 => 'g', 5 => 'j', 3 => 'ß', 6 => 'z'];
```

#### Descending order

```php
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE');
$sorter = $sortBuilder->orderByDesc()->getSorter();

$sortedArray = $sorter->sort(['a', 'g', 'A', 'ß', 'ä', 'j', 'z']);

var_dump($sortedArray); // [0 => 'z', 1 => 'ß', 2 => 'j', 3 => 'g', 4 => 'ä', 5 => 'A', 6 => 'a',];
```

#### Order by keys

```php
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE');
$sorter = $sortBuilder->orderByKeys()->getSorter();

$sortedArray = $sorter->sort(['g' => 1, 'A' => 2, 'ß' => 3, 'ä' => 4, 'z' => 5]);

var_dump($sortedArray); // ['A' => 2, 'ä' => 4, 'g' => 1, 'ß' => 3, 'z' => 5];
```

```php
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE');
$sorter = $sortBuilder->orderByKeys()->orderByDesc()->getSorter();

$sortedArray = $sorter->sort(['g' => 1, 'A' => 2, 'ß' => 3, 'ä' => 4, 'z' => 5]);

var_dump($sortedArray); // ['z' => 5, 'ß' => 3, 'g' => 1, 'ä' => 4, 'A' => 2,];
```

There are also more configuration possibilities in the builder like setting strength,
lower case first / upper case first or special french collation. Read more about
it in the [documentation](https://senseexception.github.io/intl-sort).

## Does it affect [GDPR](https://www.eugdpr.org/) somehow?

intl-sort itself uses the locale only for the purposes to sort values with the help of the
PHP Intl extension.
