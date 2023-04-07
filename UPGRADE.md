# Upgrade to 2.1

## The following classes are deprecated and will be removed in 3.0

* `Budgegeria\IntlSort\Comparator\ValueObject` (use `Budgegeria\IntlSort\Comparator\CallableAccess`)
* `Budgegeria\IntlSort\ComparatorFactory\ValueObject` (use `Budgegeria\IntlSort\ComparatorFactory\CallableAccess`)
* `Budgegeria\IntlSort\ComparatorFactory\SimpleCollator` (use `Budgegeria\IntlSort\ComparatorFactory\CallableAccess`)

## The following interface is deprecated and will be removed in 3.0

* `\Budgegeria\IntlSort\Comparator\CollatorConstructor`

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
