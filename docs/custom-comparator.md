## Create a custom Comparator

The heart of the intl-sort library is the `Comparator`, which handles the comparision of
values and influences the sorting of elements. A configured and ready to use PHP Intl 
Collator is injected into the `Comparator` where you can decide which part of values
should be compared. If the default `Comparator` doesn't fit to your needs, you can
create your own one.

Let's use code examples and explain how you can implement a `Comparator` that e.g. can sort an
array of objects of the same type. We assume your objects are instances of a class named
`Product`:

```php
namespace Your\ProjectNamespace;

class Product
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
```

### Create your Comparator

Your code is providing an array of `Product`-instances, and you want to be able to order them
with the sort builder of intl-sort by their names. While the default `Comparator` can handle
string and integer, you will need one that can handle `Product`-objects and for that you have to
implement the `Budgegeria\IntlSort\Comparator\Comparable` interface. It can look like this
in an example class called `ProductNameComparator`:

```php
namespace Your\ProjectNamespace;

use Budgegeria\IntlSort\Comparator\Comparable;
use Collator;

class ProductNameComparator implements Comparable
{
    /**
     * @var Collator
     */
    private Collator $collator;

    public function __construct(Collator $collator)
    {
        $this->collator = $collator;
    }

    /**
     * {@inheritDoc}
     */
    public function compare($product, $comparativeProduct): int
    {
        // Use Product::getName() for comparision.
        return $this->collator->compare($product->getName(), $comparativeProduct->getName());
    }
}
```

Allow your `ProductNameComparator` the injection of the Intl `Collator` in the constructor, which is the instance that
contains the configuration of the sorter builder.

The comparator has to return `-1` if the compared value of the first object is less than the second one,
`1` if it's greater and `0` if both are equal. If you directly use the given `Collator` instance, its
`Collator::compare()` method will handle this for you.

Don't forget to handle errors in your class. You have to use `Budgegeria\IntlSort\Exception\IntlSortException`
in case you want to throw an exception.

This is a small example and the complexity of comparision is up to you and your domain logic.

### Create a Comparator factory

The `Budgegeria\IntlSort\Builder` is always creating a new `Comparable` instance when `Builder::getSorter()`
or `Builder::getComparator()` is called. The same goes for your `ProductNameComparator`. To be able to do that,
you also need to create a factory which is responsible for the creation of your custom comparator. It
can look like this:

```php
namespace Your\ProjectNamespace;

use Budgegeria\IntlSort\Comparator\Comparable;
use Budgegeria\IntlSort\ComparatorFactory\Factory;
use Collator;
use Your\ProjectNamespace\ProductNameComparator;

class ProductNameComparatorFactory implements Factory
{
    public function create(Collator $collator): Comparable
    {
        return new ProductNameComparator($collator);
    }
}
```

A factory has also the advantage to inject dependencies into a constructor in case your
comparator needs more than just a `Collator`.

### Get your comparator into the sorter builder

The constructor of `Budgegeria\IntlSort\Builder` has an optional second argument where you can
inject your factory instance:

```php
use Budgegeria\IntlSort\Builder;
use Your\ProjectNamespace\ProductNameComparatorFactory;
use Your\ProjectNamespace\Product;

$sortBuilder = new Builder('de_DE', new ProductNameComparatorFactory());
$sorter = $sortBuilder->getSorter();

$products = [
    new Product('shoes'),
    new Product('scarf'),
    new Product('socks'),
];

$sortedProducts = $sorter->sort($products);
```

When `$sortBuilder->getSorter()` is invoked, your factory will create and return an instance of
`ProductNameComparator` that sorts an array of `Product`-instances by the product name.

Now you can order your products with all the different possible configurations allowed by intl-sort
to the different needs of each supported country/region throughout your project
code. You can do the same with any other type of value as long as it contains unicode comparable
values.

[Home](index.md)