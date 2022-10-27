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
$sortBuilder = \Budgegeria\IntlSort\Builder::create('de_DE');
````

it is the same as if you're injecting the factory of the basic comparator like this:

```php
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE', new \Budgegeria\IntlSort\ComparatorFactory\Standard());
```

### CallableAccess Comparator

`CallableAccess` allows you to access the values with a
[callable](https://www.php.net/manual/de/language.types.callable.php) that is provided by you in the constructor
of the factory.

#### Functions

```php
$factory = new \Budgegeria\IntlSort\ComparatorFactory\CallableAccess('strtolower');
// or
$factory = new \Budgegeria\IntlSort\ComparatorFactory\CallableAccess(fn (mixed $value) => strtolower($value));
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE', $factory);
```

#### Classes

```php
class Foo
{
    public function __invoke(mixed $value)
    {
        return 'prefix' . $value;
    }
}

$factory = new \Budgegeria\IntlSort\ComparatorFactory\CallableAccess(new Foo());
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE', $factory);
```

You can use the `CallableAccess` to handle value objects inside the callable function too.

### ValueObject Comparator

`ValueObject` is your choice if the elements you're going to sort are objects from the same type. You can compare
integer or string values of the same accessor (class method or property) that will be used for sorting all the
objects based on the builder's configuration.

```php
$factory = \Budgegeria\IntlSort\ComparatorFactory\ValueObject::createForMethodCall('methodName');
$sortBuilder = new \Budgegeria\IntlSort\Builder('de_DE', $factory);
```

### Order by method return value

If you need to order your elements of objects by the return value of a method, you'll have to provide the method
name in the `ValueObject` factory. For a class with an API like this:

```php
class Foo
{
    public function bar(): string
    {
        // return value
    }
}
```

you can sort all elements of `Foo` by the method name `Foo::bar()` when you instantiate the factory with the method
name:

```php
$factory = \Budgegeria\IntlSort\ComparatorFactory\ValueObject::createForMethodCall('bar');
```

Sorting by a method's return value only works if that method doesn't require an argument.

### Order by property value

In case your elements of objects need to be ordered by property values, you'll have to provide the property
name in the `ValueObject` factory. For a class with a property like this:

```php
class Foo
{
    public string $bar;
}
```
you can sort all elements of `Foo` by the property name `Foo::$bar` when you instantiate the factory with the property
name:

```php
$factory = \Budgegeria\IntlSort\ComparatorFactory\ValueObject::createForPropertyCall('bar');
```

The second argument is being used to mark the name in argument one as a property name. Using `false` will make the
factory use the given name as a method like mentioned before.

### SimpleCollator - A Comparator with a Collator dependency

If you have created a Comparator that only needs a Collator to be injected, you can use the SimpleCollator-Factory
instead of creating your own factory class. SimpleCollator can be used with every Comparator that has only the Collator
as constructor dependency.

```php
use Budgegeria\IntlSort\Collator\Collator;

class MyComparator implements \Budgegeria\IntlSort\Comparator\CollatorConstructor
{
    public function __construct(Collator $collator)
    {
        // ...
    }
}

$factory = new \Budgegeria\IntlSort\ComparatorFactory\SimpleCollator(MyComparator::class);
```
