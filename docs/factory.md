## Provided Comparators and Factories

intl-sort provides different comparators that can handle most of your needed
sorting cases, so you don't have to rely on creating your own
[custom comparator](custom-comparator.md) for every requirement. This is a
list of the provided comparators and their factories that come with intl-sort.
These can be used for the [sorter builder](sorter-builder.md) to be able
to sort different elements of your array.

### Basic Comparator

This is the basic comparator which is used if you don't inject a factory instance
into the builder's second constructor argument. It will handle simple scalar values
like integers and strings. When you use

```php
$sortBuilder = Budgegeria\IntlSort\Builder::create('de_DE');
````

it is the same as if you're injecting the factory of the basic comparator like this:

```php
$sortBuilder = new Budgegeria\IntlSort\Builder('de_DE', new Budgegeria\IntlSort\ComparatorFactory\Standard());
```

### CallableAccess Comparator

`CallableAccess` allows you to access the values with a
[callable](https://www.php.net/manual/de/language.types.callable.php) that is provided by you in the constructor
of the factory.

#### Functions

```php
$factory = new Budgegeria\IntlSort\ComparatorFactory\CallableAccess('strtolower');
// or
$factory = new Budgegeria\IntlSort\ComparatorFactory\CallableAccess(fn (mixed $value) => strtolower($value));
$sortBuilder = new Budgegeria\IntlSort\Builder('de_DE', $factory);
```

#### Classes

```php
class Foo
{
    public function __invoke(mixed $value)
    {
        return strtolower($value);
    }
}

$factory = new Budgegeria\IntlSort\ComparatorFactory\CallableAccess(new Foo());
$sortBuilder = new Budgegeria\IntlSort\Builder('de_DE', $factory);
```

You can use the `CallableAccess` to handle value objects inside the callable function too.
