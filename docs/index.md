## Intl-Sort - A PHP sorting library that handles internationalized data

This library wraps the `Collator` class of the PHP Intl extension and offers a builder pattern
API to create a `Sorter` to sort internationalized values or objects according to local conventions. You can also
implement your own sorting logic.

### Basic usage

In its simplest form you create a `Budgegeria\IntlSort\Builder` instance and fetch a
sorter object, that will sort your array elements.

```php
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
$sorter = $sortBuilder->getSorter();

$sortedArray = $sorter->sort(['a', 'g', 'A', 'ß', 'ä', 'j', 'z']);

var_dump($sortedArray); // [0 => 'a', 2 => 'A', 4 => 'ä', 1 => 'g', 5 => 'j', 3 => 'ß', 6 => 'z'];
```

Because it internally uses the [Collator](https://www.php.net/manual/en/class.collator.php)
class of the PHP Intl extension, it already sorts the elements respective to the region of
the given locale. In the example above the array-elements are ordered by German rules, where
the umlaut `ä` is placed after `a` and `A` instead at the end of the array.

#### Ascending and descending order of array elements

The builder pattern allows you to configure the returned sorter object and influence how
it should sort your arrays. By default, it will return a sorter object with ascending order but
it also offers to use a descending order with one further builder method.

```php
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
$sorter = $sortBuilder->orderByDesc()->getSorter();

$sortedArray = $sorter->sort(['a', 'g', 'A', 'ß', 'ä', 'j', 'z']);

var_dump($sortedArray); // [0 => 'z', 1 => 'ß', 2 => 'j', 3 => 'g', 4 => 'ä', 5 => 'A', 6 => 'a',];
```

Another way to sort an array is to order the elements by their keys for the given locale.

```php
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
$sorter = $sortBuilder->orderByKeys()->getSorter();

$sortedArray = $sorter->sort(['g' => 1, 'A' => 2, 'ß' => 3, 'ä' => 4, 'z' => 5]);

var_dump($sortedArray); // ['A' => 2, 'ä' => 4, 'g' => 1, 'ß' => 3, 'z' => 5];
```

The previously learned methods can now be combined for further configuration of the sorter to
match your wished sorting result. In this example we can create a sorter that will sort the
elements descending by keys:

```php
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
$sorter = $sortBuilder->orderByKeys()->orderByDesc()->getSorter();

$sortedArray = $sorter->sort(['g' => 1, 'A' => 2, 'ß' => 3, 'ä' => 4, 'z' => 5]);

var_dump($sortedArray); // ['z' => 5, 'ß' => 3, 'g' => 1, 'ä' => 4, 'A' => 2,];
```

The `Budgegeria\IntlSort\Builder` class is capable of more collation configurations of `Collator`
for the sorter like _strength_, _case first_ or _normalization mode_ and you find a list of its methods
in the [documentation section for the sorter builder configuration](sorter-builder.md).

#### Comparator

The builder can also return a `Comparator` instance instead of a sorter that can be used to compare
two different values based on the region information of the given locale. This is an internationalized
version of `strcmp()` of PHP, that follows the [configuration](sorter-builder.md) that was given
through the builder.

```php
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
$comparator = $sortBuilder->getComparator();

$result = $comparator->compare('z', 'ä');

var_dump($result); // 1
```

The comparator returns `-1` if the first argument is less than the second one. If the first argument
is greater it will return `1` and `0` if they are equal.

### Create custom sorting for non string / integer elements

Behind the scenes of intl-sort is the `Comparator`, which is the core part handling the sorting of elements inside
the `Sorter`-instances. It was created to order string or integer values by local conventions.
Luckily intl-sort allows you to create and  use your own `Comparator` to work with your project's data, in case
no one of the [provided comparators and factories](factory.md) fit to your needs.

[Read more about how to create and use a custom `Comparator`](custom-comparator.md).
