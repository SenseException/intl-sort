# Upgrade to 2.0

## Set minimum PHP requirement to 8.0

You need to update your PHP version.

## BC break: Custom Collator class replaces intl Collator 

`Budgegeria\IntlSort\Collator`, which was extending the intl Collator class got replaced with
`Budgegeria\IntlSort\Collator\Collator`. Please adapt your code for this change.

## BC break: Added typings to classes

A lot of new type hints and return types were added with the switch to PHP 8. Please adapt
your code.

## BC break: ValueObject factory can only be instantiated with named constructors

`Budgegeria\IntlSort\ComparatorFactory\ValueObject::__construct()` is private. To create a new
instance you have to use one of the following named constructors:

`Budgegeria\IntlSort\ComparatorFactory\ValueObject::createForMethodCall($methodName)` for methods
`Budgegeria\IntlSort\ComparatorFactory\ValueObject::createForPropertyCall($propertyName)` for
properties.
