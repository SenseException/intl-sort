# Upgrade to 2.0

## Set minimum PHP requirement to 8.0

You need to update your PHP version.

## BC break: Custom Collator class replaces intl Collator 

`Budgegeria\IntlSort\Collator`, which was extending the intl Collator class got replaced with
`Budgegeria\IntlSort\Collator\Collator`. Please adapt your code for this change.

## BC break: Added typings to classes

A lot of new type hints and return types were added with the switch to PHP 8. Please adapt
your code.
