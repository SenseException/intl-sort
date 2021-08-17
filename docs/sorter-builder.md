## Sorter builder configuration

The sorter builder `Budgegeria\IntlSort\Builder` allows to adapt the sorting behaviour 
additional to local conventions. The effects may differ between the supported locales.
You can [read more about the different concepts](http://userguide.icu-project.org/collation/concepts)
on the ICU homepage.

### Case First

Case First allows setting upper case or lower case letters to be first in the order of elements.

* **lowerCaseFirst()** - lower case letters come before upper case.
* **upperCaseFirst()** - upper case letters come before lower case.
* **removeCaseFirst()** - Remove the configured Case First and returns to the default behaviour
  for the given locale.
  
### Numeric Collation

The Numeric Collation enables how numeric values should be ordered.

* **enableNumericCollation()** - "4" comes before "100", because 4 is a lower number than 100.
* **disableNumericCollation()** - "100" comes before "4", because of "alphabetical" reasons where 
  1 comes before 4.

### Strength

Also known as [Comparison Levels](http://userguide.icu-project.org/collation/concepts#TOC-Comparison-Levels),
a strength can influence the matching conditions between strings and how they are ordered.
This can also be used for performance improvements you don't need a stricter comparison.

* **primaryStrength()** - orders by the strongest difference ("a" < "b") and sees weaker differences
  as the same ("A" = "a", "ä" = "A").
* **secondaryStrength()** - accents in the characters are considered secondary differences 
  ("as" < "às" < "at"). A secondary difference is ignored when there is a primary difference
  anywhere in the strings.
* **tertiaryStrength()** - distinguishes upper and lower case differences in characters 
  ("ao" < "Ao" < "aò").
* **quaternaryStrength()** - when punctuation is ignored at level 1-3, an additional level can be used 
  to distinguish words with and without punctuation ("ab" < "a-b" < "aB")
* **identicalStrength()** - When all other levels are equal, the identical level is used as a tiebreaker.
  The Unicode code point values of the [Normalization Form D](http://www.unicode.org/reports/tr15/#Norm_Forms)
  of each string are compared at this level, just in case there is no difference at levels 1-4 .

[Read more at the ICU homepage](http://userguide.icu-project.org/collation/concepts#TOC-Comparison-Levels)

### Case Level

The Case Level is used when ignoring accents but not case. In such a situation,
use e.g. strength `primaryStrength()` and `enableCaseLevel()`. It can also
affect performance.

* **enableCaseLevel()** - enables the Case Level.
* **disableCaseLevel()** - disables the Case Level.

### Normalization Mode

The Normalization setting determines whether text is thoroughly normalized or not in comparison.

* **enableNormalizationMode()** - enables the Normalization Mode.
* **disableNormalizationMode()** - disables the Normalization Mode.

### French Collation

Some French dictionary ordering traditions sort strings with different accents from the back of 
the string. This attribute is automatically enabled for the Canadian French locale (fr_CA).
Enabling it increases the string comparison performance cost, but not sort key length.

* **enableFrenchCollation()** - enables the French collation (e.g "cote" < "côte" < "coté" < "côté").
* **disableFrenchCollation()** - disables the French collation. (e.g "cote" < "coté" < "côte" < "côté").

### Alternate Handling

The Alternate attribute is used to control the handling of the so called variable characters in the UCA: whitespace,
punctuation and symbols.

* **nonIgnorableAlternateHandling()** - differences among variable characters are of the same importance
  as differences among letters.
* **shiftedAlternateHandling()** - variable characters are of only minor importance. Usually used in combination
  with `quaternaryStrength()`.

### Order By

Configures the sort order and which part of the elements are the focus for the sorting.

* **orderByAsc()** - use ascending order direction.
* **orderByDesc()** - use descending order direction.
* **orderByKeys()** - order by keys of the elements.
* **orderByValues()** - order by the values of the elements

### Null value position

Positioning of null values at the start or at the end of all elements.

* **nullFirst()** - set null values at the beginning.
* **nullLast()** - set null values at the end.
* **removeNullPosition()** - removes the null value sort config.

### getSorter()

Returns a `Sorter` instance with the given configuration. Every call creates a new instance.

### getComparator()

Returns a `Comparator` instance with the given configuration. Every call creates a new instance.

[Home](index.md)
