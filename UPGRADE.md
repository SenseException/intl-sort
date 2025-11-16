# Upgrade to 3.1

## Drop support of PHP 8.2

You need to update your PHP version.

# Upgrade to 3.0

## Drop support of PHP 8.1

You need to update your PHP version.

## The following classes are removed

* `Budgegeria\IntlSort\Comparator\ValueObject`
* `Budgegeria\IntlSort\ComparatorFactory\ValueObject`
* `Budgegeria\IntlSort\ComparatorFactory\SimpleCollator`
* `Budgegeria\IntlSort\Comparator\CollatorConstructor`

## The comparator factory constructor argument of the Builder class is mandatory now

Either use the standard comparator

``` php
$builder = new Builder('en_US', new Standard());
```

or the already existing static method

``` php
$builder = Builder::create('en_US');
```

# Upgrade to 2.1

## New Builder config: Omitting array keys on sorted values

* The methods `Builder::keepKeys()` and `Builder::omitKeys()` were added.
* New sorter class `Omit` added.

## The following classes are deprecated and will be removed in 3.0

* `Budgegeria\IntlSort\Comparator\ValueObject` (use `Budgegeria\IntlSort\Comparator\CallableAccess`)
* `Budgegeria\IntlSort\ComparatorFactory\ValueObject` (use `Budgegeria\IntlSort\ComparatorFactory\CallableAccess`)
* `Budgegeria\IntlSort\ComparatorFactory\SimpleCollator` (use `Budgegeria\IntlSort\ComparatorFactory\CallableAccess`)

## The following interface is deprecated and will be removed in 3.0

* `Budgegeria\IntlSort\Comparator\CollatorConstructor`

# Upgrade to 2.0

## Set minimum PHP requirement to 8.0

You need to update your PHP version.

## BC break: Custom Collator class replaces intl Collator 

`Budgegeria\IntlSort\Collator`, which was extending the intl Collator class got replaced with
`Budgegeria\IntlSort\Collator\Collator`. Please adapt your code for this change.

## BC break: Added typings to classes

A lot of new type hints and return types were added with the switch to PHP 8. Please adapt
your code.

## New comparator and factory: CallableAccess

CallableAccess allows to use callables for accessing values to sort:

`Budgegeria\IntlSort\Comparator\CallableAccess`
`Budgegeria\IntlSort\ComparatorFactory\CallableAccess`
