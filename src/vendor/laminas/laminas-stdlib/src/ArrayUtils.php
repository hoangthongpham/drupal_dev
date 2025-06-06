<?php // phpcs:disable WebimpressCodingStandard.NamingConventions.AbstractClass.Prefix


declare(strict_types=1);

namespace Laminas\Stdlib;

use Iterator;
use Laminas\Stdlib\ArrayUtils\MergeRemoveKey;
use Laminas\Stdlib\ArrayUtils\MergeReplaceKeyInterface;
use Traversable;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_values;
use function in_array;
use function is_array;
use function is_callable;
use function is_float;
use function is_int;
use function is_object;
use function is_scalar;
use function is_string;
use function iterator_to_array;
use function method_exists;
use function sprintf;

/**
 * Utility class for testing and manipulation of PHP arrays.
 *
 * Declared abstract, as we have no need for instantiation.
 */
abstract class ArrayUtils
{
    /**
     * Compatibility Flag for ArrayUtils::filter
     *
     * @deprecated
     */
    public const ARRAY_FILTER_USE_BOTH = 1;

    /**
     * Compatibility Flag for ArrayUtils::filter
     *
     * @deprecated
     */
    public const ARRAY_FILTER_USE_KEY = 2;

    /**
     * Test whether an array contains one or more string keys
     *
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasStringKeys(mixed $value, $allowEmpty = false)
    {
        if (! is_array($value)) {
            return false;
        }

        if (! $value) {
            return $allowEmpty;
        }

        return [] !== array_filter(array_keys($value), 'is_string');
    }

    /**
     * Test whether an array contains one or more integer keys
     *
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasIntegerKeys(mixed $value, $allowEmpty = false)
    {
        if (! is_array($value)) {
            return false;
        }

        if (! $value) {
            return $allowEmpty;
        }

        return [] !== array_filter(array_keys($value), 'is_int');
    }

    /**
     * Test whether an array contains one or more numeric keys.
     *
     * A numeric key can be one of the following:
     * - an integer 1,
     * - a string with a number '20'
     * - a string with negative number: '-1000'
     * - a float: 2.2120, -78.150999
     * - a string with float:  '4000.99999', '-10.10'
     *
     * @param  bool  $allowEmpty    Should an empty array() return true
     * @return bool
     */
    public static function hasNumericKeys(mixed $value, $allowEmpty = false)
    {
        if (! is_array($value)) {
            return false;
        }

        if (! $value) {
            return $allowEmpty;
        }

        return [] !== array_filter(array_keys($value), 'is_numeric');
    }

    /**
     * Test whether an array is a list
     *
     * A list is a collection of values assigned to continuous integer keys
     * starting at 0 and ending at count() - 1.
     *
     * For example:
     * <code>
     * $list = array('a', 'b', 'c', 'd');
     * $list = array(
     *     0 => 'foo',
     *     1 => 'bar',
     *     2 => array('foo' => 'baz'),
     * );
     * </code>
     *
     * @param  bool  $allowEmpty    Is an empty list a valid list?
     * @return bool
     */
    public static function isList(mixed $value, $allowEmpty = false)
    {
        if (! is_array($value)) {
            return false;
        }

        if (! $value) {
            return $allowEmpty;
        }

        return array_values($value) === $value;
    }

    /**
     * Test whether an array is a hash table.
     *
     * An array is a hash table if:
     *
     * 1. Contains one or more non-integer keys, or
     * 2. Integer keys are non-continuous or misaligned (not starting with 0)
     *
     * For example:
     * <code>
     * $hash = array(
     *     'foo' => 15,
     *     'bar' => false,
     * );
     * $hash = array(
     *     1995  => 'Birth of PHP',
     *     2009  => 'PHP 5.3.0',
     *     2012  => 'PHP 5.4.0',
     * );
     * $hash = array(
     *     'formElement,
     *     'options' => array( 'debug' => true ),
     * );
     * </code>
     *
     * @param  bool  $allowEmpty    Is an empty array() a valid hash table?
     * @return bool
     */
    public static function isHashTable(mixed $value, $allowEmpty = false)
    {
        if (! is_array($value)) {
            return false;
        }

        if (! $value) {
            return $allowEmpty;
        }

        return array_values($value) !== $value;
    }

    /**
     * Checks if a value exists in an array.
     *
     * Due to "foo" == 0 === TRUE with in_array when strict = false, an option
     * has been added to prevent this. When $strict = 0/false, the most secure
     * non-strict check is implemented. if $strict = -1, the default in_array
     * non-strict behaviour is used.
     *
     * @deprecated This method will be removed in version 4.0 of this component
     *
     * @param int|bool $strict
     * @return bool
     */
    public static function inArray(mixed $needle, array $haystack, $strict = false)
    {
        if ((bool) $strict === false) {
            if (is_int($needle) || is_float($needle)) {
                $needle = (string) $needle;
            }
            if (is_string($needle)) {
                foreach ($haystack as &$h) {
                    if (is_int($h) || is_float($h)) {
                        $h = (string) $h;
                    }
                }
            }
        }

        return in_array($needle, $haystack, (bool) $strict);
    }

    /**
     * Converts an iterator to an array. The $recursive flag, on by default,
     * hints whether or not you want to do so recursively.
     *
     * @template TKey
     * @template TValue
     * @param  iterable<TKey, TValue> $iterator  The array or Traversable object to convert
     * @param  bool                   $recursive Recursively check all nested structures
     * @throws Exception\InvalidArgumentException If $iterator is not an array or a Traversable object.
     * @return array<TKey, TValue>
     */
    public static function iteratorToArray($iterator, $recursive = true)
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (! is_array($iterator) && ! $iterator instanceof Traversable) {
            throw new Exception\InvalidArgumentException(__METHOD__ . ' expects an array or Traversable object');
        }

        if (! $recursive) {
            if (is_array($iterator)) {
                return $iterator;
            }

            return iterator_to_array($iterator);
        }

        if (
            is_object($iterator)
            && ! $iterator instanceof Iterator
            && method_exists($iterator, 'toArray')
        ) {
            /** @psalm-var array<TKey, TValue> $array */
            $array = $iterator->toArray();

            return $array;
        }

        $array = [];
        foreach ($iterator as $key => $value) {
            if (is_scalar($value)) {
                $array[$key] = $value;
                continue;
            }

            if ($value instanceof Traversable) {
                $array[$key] = static::iteratorToArray($value, $recursive);
                continue;
            }

            if (is_array($value)) {
                $array[$key] = static::iteratorToArray($value, $recursive);
                continue;
            }

            $array[$key] = $value;
        }

        /** @psalm-var array<TKey, TValue> $array */

        return $array;
    }

    /**
     * Merge two arrays together.
     *
     * If an integer key exists in both arrays and preserveNumericKeys is false, the value
     * from the second array will be appended to the first array. If both values are arrays, they
     * are merged together, else the value of the second array overwrites the one of the first array.
     *
     * @param  bool  $preserveNumericKeys
     * @return array
     */
    public static function merge(array $a, array $b, $preserveNumericKeys = false)
    {
        foreach ($b as $key => $value) {
            if ($value instanceof MergeReplaceKeyInterface) {
                $a[$key] = $value->getData();
            } elseif (isset($a[$key]) || array_key_exists($key, $a)) {
                if ($value instanceof MergeRemoveKey) {
                    unset($a[$key]);
                } elseif (! $preserveNumericKeys && is_int($key)) {
                    $a[] = $value;
                } elseif (is_array($value) && is_array($a[$key])) {
                    $a[$key] = static::merge($a[$key], $value, $preserveNumericKeys);
                } else {
                    $a[$key] = $value;
                }
            } else {
                if (! $value instanceof MergeRemoveKey) {
                    $a[$key] = $value;
                }
            }
        }

        return $a;
    }

    /**
     * @deprecated Since 3.2.0; use the native array_filter methods
     *
     * @param callable $callback
     * @param null|int $flag
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public static function filter(array $data, $callback, $flag = null)
    {
        if (! is_callable($callback)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Second parameter of %s must be callable',
                __METHOD__
            ));
        }

        return array_filter($data, $callback, $flag ?? 0);
    }
}
