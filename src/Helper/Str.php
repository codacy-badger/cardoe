<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Helper;

use RuntimeException;
use function array_merge;
use function array_rand;
use function count;
use function count_chars;
use function explode;
use function implode;
use function is_array;
use function ltrim;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function mt_rand;
use function pathinfo;
use function preg_match_all;
use function preg_quote;
use function preg_replace;
use function range;
use function rtrim;
use function str_split;
use function strlen;
use function strrev;
use function substr;
use function substr_compare;
use function substr_count;
use function trim;
use const DIRECTORY_SEPARATOR;
use const PATHINFO_FILENAME;

/**
 * Cardoe\Helper\Str
 *
 * This class offers quick string functions throughout the framework
 */
class Str
{
    const RANDOM_ALNUM    = 0;
    const RANDOM_ALPHA    = 1;
    const RANDOM_DISTINCT = 5;
    const RANDOM_HEXDEC   = 2;
    const RANDOM_NOZERO   = 4;
    const RANDOM_NUMERIC  = 3;

    /**
     * Concatenates strings using the separator only once without duplication in
     * places concatenation
     *
     * @param string $separator
     * @param mixed  ...$arguments
     *
     * @return string
     * @throws Exception
     */
    final public static function concat(string $separator, ...$arguments): string
    {
        if (count($arguments) < 2) {
            throw new Exception('concat needs at least three parameters');
        }

        $first     = Arr::first($arguments);
        $last      = Arr::last($arguments);
        $prefix    = '';
        $suffix    = '';
        $data      = [];

        if (true === self::startsWith($first, $separator)) {
            $prefix = $separator;
        }

        if (true === self::endsWith($last, $separator)) {
            $suffix = $separator;
        }


        foreach ($arguments as $argument) {
            $data[] = rtrim(ltrim($argument, $separator), $separator);
        }

        return $prefix . implode($separator, $data) . $suffix;
    }

    /**
     * Returns number of vowels in provided string. Uses a regular expression
     * to count the number of vowels (A, E, I, O, U) in a string.
     *
     * @param string $text
     *
     * @return int
     */
    final public static function countVowels(string $text): int
    {
        preg_match_all('/[aeiou]/i', $text, $matches);

        return count($matches[0]);
    }

    /**
     * Decapitalizes the first letter of the string and then adds it with rest
     * of the string. Omit the upperRest parameter to keep the rest of the
     * string intact, or set it to true to convert to uppercase.
     *
     * @param string $text
     * @param bool   $upperRest
     * @param string $encoding
     *
     * @return string
     */
    final public static function decapitalize(
        string $text,
        bool $upperRest = false,
        string $encoding = 'UTF-8'
    ): string {
        $substr = mb_substr($text, 1);

        if (true === $upperRest) {
            $suffix = mb_strtoupper($substr, $encoding);
        } else {
            $suffix = $substr;
        }

        return mb_strtolower(mb_substr($text, 0, 1), $encoding) . $suffix;
    }

    /**
     * Accepts a file name (without extension) and returns a calculated
     * directory structure with the filename in the end
     *
     * @param string $file
     *
     * @return string
     */
    final public static function dirFromFile(string $file): string
    {
        $name  = pathinfo($file, PATHINFO_FILENAME);
        $start = substr($name, 0, -2);

        if (!$start) {
            $start = substr($name, 0, 1);
        }

        return implode('/', str_split($start, 2)) . '/';
    }

    /**
     * Accepts a directory name and ensures that it ends with
     * DIRECTORY_SEPARATOR
     *
     * @param string $directory
     *
     * @return string
     */
    final public static function dirSeparator(string $directory): string
    {
        return rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Generates random text in accordance with the template
     *
     * @param string $text
     * @param string $leftDelimiter
     * @param string $rightDelimiter
     * @param string $separator
     *
     * @return string
     */
    final public static function dynamic(
        string $text,
        string $leftDelimiter = '{',
        string $rightDelimiter = '}',
        string $separator = '|'
    ): string {
        if (substr_count($text, $leftDelimiter) !== substr_count($text, $rightDelimiter)) {
            throw new RuntimeException(
                "Syntax error in string '" . $text . "'"
            );
        }

        $ldS     = preg_quote($leftDelimiter);
        $rdS     = preg_quote($rightDelimiter);
        $pattern = '/' . $ldS . '([^' . $ldS . $rdS . ']+)' . $rdS . '/';
        $matches = [];

        if (!preg_match_all($pattern, $text, $matches, 2)) {
            return $text;
        }

        if (true === is_array($matches)) {
            foreach ($matches as $match) {
                if (true !== isset($match[0]) || true !== isset($match[1])) {
                    continue;
                }

                $words = explode($separator, $match[1]);
                $word  = $words[array_rand($words)];
                $sub   = preg_quote($match[0], $separator);
                $text  = preg_replace('/' . $sub . '/', $word, $text, 1);
            }
        }

        return $text;
    }

    /**
     * Check if a string ends with a given string
     *
     * @param string $haystack
     * @param string $needle
     * @param bool   $ignoreCase
     *
     * @return bool
     */
    final public static function endsWith(
        string $haystack,
        string $needle,
        bool $ignoreCase = true
    ): bool {
        if ('' === $haystack) {
            return false;
        }

        return substr_compare(
            $haystack,
            $needle,
            -strlen($needle),
            strlen($needle),
            $ignoreCase
        ) === 0;
    }

    /**
     * Returns the first string there is between the strings from the
     * parameter start and end.
     *
     * @param string $text
     * @param string $start
     * @param string $end
     *
     * @return string
     */
    final public static function firstBetween(
        string $text,
        string $start,
        string $end
    ): string {
        return trim(
            mb_strstr(
                mb_strstr($text, $start),
                $end,
                true
            ),
            $start . $end
        );
    }

    /**
     * Makes an underscored or dashed phrase human-readable
     *
     * @param string $text
     *
     * @return string
     */
    final public static function humanize(string $text): string
    {
        return preg_replace('#[_-]+#', ' ', trim($text));
    }

    /**
     * Lets you determine whether or not a string includes another string.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    final public static function includes(string $haystack, string $needle): bool
    {
        return (bool) mb_strpos($haystack, $needle);
    }

    /**
     * Adds a number to a string or increment that number if it already is
     * defined
     *
     * @param string $text
     * @param string $separator
     *
     * @return string
     */
    final public static function increment(string $text, string $separator = '_'): string
    {
        $parts  = explode($separator, $text);
        $number = 1;

        if (true === isset($parts[1])) {
            $number = ((int) $parts[1]) + 1;
        }

        return $parts[0] . $separator . $number;
    }

    /**
     * Compare two strings and returns true if both strings are anagram,
     * false otherwise.
     *
     * @param string $first
     * @param string $second
     *
     * @return bool
     */
    final public static function isAnagram(string $first, string $second): bool
    {
        return count_chars($first, 1) === count_chars($second, 1);
    }

    /**
     * Returns true if the given string is lower case, false otherwise.
     *
     * @param string $text
     * @param string $encoding
     *
     * @return bool
     */
    final public static function isLower(string $text, string $encoding = 'UTF-8'): bool
    {
        return $text === mb_strtolower($text, $encoding);
    }

    /**
     * Returns true if the given string is a palindrome, false otherwise.
     *
     * @param string $text
     *
     * @return bool
     */
    final public static function isPalindrome(string $text): bool
    {
        return strrev($text) === $text;
    }

    /**
     * Returns true if the given string is upper case, false otherwise.
     *
     * @param string text
     * @param string encoding
     *
     * @return bool
     */
    final public static function isUpper(string $text, string $encoding = 'UTF-8'): bool
    {
        return $text === mb_strtoupper($text, $encoding);
    }

    /**
     * Lowercases a string, this function makes use of the mbstring extension if
     * available
     *
     * <code>
     * echo Cardoe\Helper\Str::lower('HELLO'); // hello
     * </code>
     *
     * @param string $text
     * @param string $encoding
     *
     * @return string
     */
    final public static function lower(string $text, string $encoding = 'UTF-8'): string
    {
        return mb_strtolower($text, $encoding);
    }

    /**
     * Generates a random string based on the given type. Type is one of the
     * RANDOM_* constants
     *
     * <code>
     * use Cardoe\Helper\Str;
     *
     * echo Str::random(Str::RANDOM_ALNUM); // 'aloiwkqz'
     * </code>
     *
     * @param int $type
     * @param int $length
     *
     * @return string
     */
    final public static function random(int $type = 0, int $length = 8): string
    {
        $text = '';

        switch ($type) {

            case Str::RANDOM_ALPHA:
                $pool = array_merge(range('a', 'z'), range('A', 'Z'));
                break;

            case Str::RANDOM_HEXDEC:
                $pool = array_merge(range(0, 9), range('a', 'f'));
                break;

            case Str::RANDOM_NUMERIC:
                $pool = range(0, 9);
                break;

            case Str::RANDOM_NOZERO:
                $pool = range(1, 9);
                break;

            case Str::RANDOM_DISTINCT:
                $pool = str_split('2345679ACDEFHJKLMNPRSTUVWXYZ');
                break;

            default:
                // Default type \Cardoe\Text::RANDOM_ALNUM
                $pool = array_merge(
                    range(0, 9),
                    range('a', 'z'),
                    range('A', 'Z')
                );

                break;
        }

        $end = count($pool) - 1;

        while (strlen($text) < $length) {
            $text .= $pool[mt_rand(0, $end)];
        }

        return $text;
    }

    /**
     * Reduces multiple slashes in a string to single slashes
     *
     * <code>
     * // foo/bar/baz
     * echo Cardoe\Helper\Str::reduceSlashes('foo//bar/baz');
     *
     * // http://foo.bar/baz/buz
     * echo Cardoe\Helper\Str::reduceSlashes('http://foo.bar///baz/buz');
     * </code>
     *
     * @param string $text
     *
     * @return string
     */
    final public static function reduceSlashes(string $text): string
    {
        return preg_replace('#(?<!:)//+#', '/', $text);
    }

    /**
     * Check if a string starts with a given string
     *
     * @param string $haystack
     * @param string $needle
     * @param bool   $ignoreCase
     *
     * @return bool
     */
    final public static function startsWith(
        string $haystack,
        string $needle,
        bool $ignoreCase = true
    ): bool {
        if ('' === $haystack) {
            return false;
        }

        return substr_compare(
            $haystack,
            $needle,
            0,
            strlen($needle),
            $ignoreCase
        ) === 0;
    }

    /**
     * Makes a phrase underscored instead of spaced
     *
     * <code>
     * use Cardoe\Helper\Str;
     *
     * echo Str::underscore('look behind');     // 'look_behind'
     * echo Str::underscore('Awesome Cardoe'); // 'Awesome_Cardoe'
     * </code>
     *
     * @param string $text
     *
     * @return string
     */
    final public static function underscore(string $text): string
    {
        return preg_replace('#\s+#', '_', trim($text));
    }

    /**
     * Uppercases a string, this function makes use of the mbstring extension if
     * available
     *
     * <code>
     * echo Cardoe\Helper\Str::upper('hello'); // HELLO
     * </code>
     *
     * @param string $text
     * @param string $encoding
     *
     * @return string
     */
    final public static function upper(string $text, string $encoding = 'UTF-8'): string
    {
        return mb_strtoupper($text, $encoding);
    }
}
