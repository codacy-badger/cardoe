<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by Zend Diactoros
 * @link    https://github.com/zendframework/zend-diactoros
 * @license https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md
 */

declare(strict_types=1);

namespace Phalcon\Http\Message;

use Phalcon\Helper\Arr;
use Phalcon\Helper\Str;
use Phalcon\Http\Message\Exception\InvalidArgumentException;
use Psr\Http\Message\UriInterface;

use function array_keys;
use function explode;
use function implode;
use function ltrim;
use function parse_url;
use function preg_replace;
use function rawurlencode;
use function strpos;
use function strtolower;

/**
 * PSR-7 Uri
 *
 * @property string   $fragment
 * @property string   $host
 * @property string   $pass
 * @property string   $path
 * @property int|null $port
 * @property string   $query
 * @property string   $scheme
 * @property string   $user
 */
final class Uri extends AbstractCommon implements UriInterface
{
    /**
     * Returns the fragment of the URL
     *
     * @return string
     */
    protected $fragment = "";

    /**
     * Retrieve the host component of the URI.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
     *
     * @return string
     */
    protected $host = "";

    /**
     * @var string
     */
    protected $pass = "";

    /**
     * Returns the path of the URL
     *
     * @return string
     */
    protected $path = "";

    /**
     * Retrieve the port component of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard
     * port used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @return int|null
     */
    protected $port = null;

    /**
     * Returns the query of the URL
     *
     * @return string
     */
    protected $query = "";

    /**
     * Retrieve the scheme component of the URI.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ":" character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     *
     * @return string
     */
    protected $scheme = "https";

    /**
     * @var string
     */
    protected $user = "";

    /**
     * Uri constructor.
     *
     * @param string $uri
     */
    public function __construct(string $uri = '')
    {
        if ('' !== $uri) {
            $urlParts = parse_url($uri);

            if (false === $urlParts) {
                $urlParts = [];
            }

            $this->fragment = $this->filterFragment(
                Arr::get($urlParts, 'fragment', '')
            );
            $this->host     = strtolower(
                Arr::get($urlParts, 'host', '')
            );
            $this->pass     = rawurlencode(
                Arr::get($urlParts, 'pass', '')
            );
            $this->path     = $this->filterPath(
                Arr::get($urlParts, 'path', '')
            );
            $this->port     = $this->filterPort(
                Arr::get($urlParts, 'port', null)
            );
            $this->query    = $this->filterQuery(
                Arr::get($urlParts, 'query', '')
            );
            $this->scheme   = $this->filterScheme(
                Arr::get($urlParts, 'scheme', '')
            );
            $this->user     = rawurlencode(
                Arr::get($urlParts, 'user', '')
            );
        }
    }

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters
     *
     * @return string
     */
    public function __toString(): string
    {
        $authority = $this->getAuthority();
        $path      = $this->path;

        /**
         * The path can be concatenated without delimiters. But there are two
         * cases where the path has to be adjusted to make the URI reference
         * valid as PHP does not allow to throw an exception in __toString():
         *   - If the path is rootless and an authority is present, the path
         *     MUST be prefixed by "/".
         *   - If the path is starting with more than one "/" and no authority
         *     is present, the starting slashes MUST be reduced to one.
         */
        if (
            "" !== $path &&
            true !== Str::startsWith($path, "/") &&
            "" !== $authority
        ) {
            $path = "/" . $path;
        }

        return $this->checkValue($this->scheme, "", ":")
            . $this->checkValue($authority, "//")
            . $path
            . $this->checkValue($this->query, "?")
            . $this->checkValue($this->fragment, "#");
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @return string
     */
    public function getAuthority(): string
    {
        /**
         * If no authority information is present, this method MUST return an
         * empty string.
         */
        if ("" === $this->host) {
            return "";
        }

        $authority = $this->host;
        $userInfo  = $this->getUserInfo();

        /**
         * The authority syntax of the URI is:
         *
         * [user-info@]host[:port]
         */
        if ("" !== $userInfo) {
            $authority = $userInfo . "@" . $authority;
        }

        /**
         * If the port component is not set or is the standard port for the
         * current scheme, it SHOULD NOT be included.
         */
        if (null !== $this->port) {
            $authority .= ":" . $this->port;
        }

        return $authority;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @return string The URI user information, in "username[:password]" format.
     */
    public function getUserInfo(): string
    {
        if (true !== empty($this->pass)) {
            return $this->user . ":" . $this->pass;
        }

        return $this->user;
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified URI fragment.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment
     *
     * @return Uri
     */
    public function withFragment($fragment): Uri
    {
        $this->checkStringParameter($fragment);

        $fragment = $this->filterFragment($fragment);

        return $this->cloneInstance($fragment, "fragment");
    }

    /**
     * Return an instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If an HTTP path is intended to be host-relative rather than path-relative
     * then it must begin with a slash ("/"). HTTP paths not starting with a
     * slash are assumed to be relative to some base path known to the
     * application or consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid paths.
     */
    public function withPath($path): Uri
    {
        $this->checkStringParameter($path);

        if (
            false !== strpos($path, "?") ||
            false !== strpos($path, "#")
        ) {
            throw new InvalidArgumentException(
                "Path cannot contain a query string or fragment"
            );
        }

        $path = $this->filterPath($path);

        return $this->cloneInstance($path, "path");
    }

    /**
     * Return an instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified port.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param int|null $port
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid ports.
     */
    public function withPort($port): Uri
    {
        if (null !== $port) {
            $port = $this->filterPort($port);

            if (null !== $port && ($port < 1 || $port > 65535)) {
                throw new InvalidArgumentException(
                    "Method expects valid port (1-65535)"
                );
            }
        }

        return $this->cloneInstance($port, "port");
    }

    /**
     * Return an instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified query string.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid query strings.
     */
    public function withQuery($query): Uri
    {
        $this->checkStringParameter($query);

        if (false !== strpos($query, "#")) {
            throw new InvalidArgumentException(
                "Query cannot contain a query fragment"
            );
        }

        $query = $this->filterQuery($query);

        return $this->cloneInstance($query, "query");
    }

    /**
     * Return an instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified scheme.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid schemes.
     * @throws InvalidArgumentException for unsupported schemes.
     */
    public function withScheme($scheme): Uri
    {
        $this->checkStringParameter($scheme);

        $scheme = $this->filterScheme($scheme);

        return $this->processWith($scheme, "scheme");
    }

    /**
     * Return an instance with the specified user information.
     *
     * @param string      $user
     * @param string|null $password
     *
     * @return Uri
     */
    public function withUserInfo($user, $password = null): Uri
    {
        $this->checkStringParameter($user);

        if (null !== $password) {
            $this->checkStringParameter($user);
        }

        $user = rawurlencode($user);

        if (null !== $password) {
            $password = rawurlencode($password);
        }

        /**
         * Immutable - need to send a new object back
         */
        $newInstance       = $this->cloneInstance($user, "user");
        $newInstance->pass = $password;

        return $newInstance;
    }

    /**
     * Return an instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified host.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host
     *
     * @return Uri
     * @throws InvalidArgumentException for invalid hostnames.
     *
     */
    public function withHost($host): Uri
    {
        return $this->processWith($host, "host");
    }

    /**
     * @return string
     */
    public function getFragment(): string
    {
        return $this->fragment;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * If the value passed is empty it returns it prefixed and suffixed with
     * the passed parameters
     *
     * @param string $value
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    private function checkValue(
        string $value,
        string $prefix = "",
        string $suffix = ""
    ): string {
        if ("" !== $value) {
            $value = $prefix . $value . $suffix;
        }

        return $value;
    }

    /**
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     *
     * @param string $fragment
     *
     * @return string
     */
    private function filterFragment(string $fragment): string
    {
        return rawurlencode($fragment);
    }

    /**
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     *
     * @param string $path
     *
     * @return string The URI path.
     */
    private function filterPath(string $path): string
    {
        if ("" === $path || true !== Str::startsWith($path, "/")) {
            return $path;
        }

        $parts = explode("/", $path);
        foreach ($parts as $key => $element) {
            $parts[$key] = rawurlencode($element);
        }

        $path = implode("/", $parts);

        return "/" . ltrim($path, "/");
    }

    /**
     * Checks the port. If it is a standard one (80,443) then it returns null
     *
     * @param int|null $port
     *
     * @return int|null
     */
    private function filterPort($port): ?int
    {
        $ports = [
            80  => 1,
            443 => 1
        ];

        if (null !== $port) {
            $port = (int) $port;
            if (isset($ports[$port])) {
                $port = null;
            }
        }

        return $port;
    }

    /**
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @param string $query
     *
     * @return string The URI query string.
     */
    private function filterQuery(string $query): string
    {
        if ("" === $query) {
            return "";
        }

        $query = ltrim($query, "?");
        $parts = explode("&", $query);

        foreach ($parts as $index => $part) {
            $split = $this->splitQueryValue($part);
            if (null === $split[1]) {
                $parts[$index] = rawurlencode($split[0]);
                continue;
            }

            $parts[$index] = rawurlencode($split[0]) . "=" . rawurlencode($split[1]);
        }

        return implode("&", $parts);
    }

    /**
     * Filters the passed scheme - only allowed schemes
     *
     * @param string $scheme
     *
     * @return string
     */
    private function filterScheme(string $scheme): string
    {
        $filtered = preg_replace("#:(//)?$#", "", mb_strtolower($scheme));
        $schemes  = [
            "http"  => 1,
            "https" => 1
        ];

        if ("" === $filtered) {
            return "";
        }

        if (!isset($schemes[$filtered])) {
            throw new InvalidArgumentException(
                "Unsupported scheme [" . $filtered . "]. " .
                "Scheme must be one of [" .
                implode(", ", array_keys($schemes)) . "]"
            );
        }

        return $scheme;
    }

    /**
     * @param string $element
     *
     * @return array
     */
    private function splitQueryValue(string $element): array
    {
        $data = explode("=", $element, 2);
        if (!isset($data[1])) {
            $data[] = null;
        }

        return $data;
    }
}
