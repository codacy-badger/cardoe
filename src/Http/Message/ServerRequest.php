<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Http\Message;

use Cardoe\Collection\Collection;
use Cardoe\Http\Message\Exception\InvalidArgumentException;
use Cardoe\Http\Message\Stream\Input;
use Cardoe\Http\Message\Traits\CommonTrait;
use Cardoe\Http\Message\Traits\MessageTrait;
use Cardoe\Http\Message\Traits\RequestTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;
use function is_array;
use function is_object;

/**
 * Representation of an incoming, server-side HTTP request.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - HTTP method
 * - URI
 * - Headers
 * - Message body
 *
 * Additionally, it encapsulates all data as it has arrived at the
 * application from the CGI and/or PHP environment, including:
 *
 * - The values represented in _SERVER.
 * - Any cookies provided (generally via _COOKIE)
 * - Query string arguments (generally via _GET, or as parsed via parse_str())
 * - Upload files, if any (as represented by _FILES)
 * - Deserialized body parameters (generally from _POST)
 *
 * _SERVER values MUST be treated as immutable, as they represent application
 * state at the time of request; as such, no methods are provided to allow
 * modification of those values. The other values provide such methods, as they
 * can be restored from _SERVER or the request body, and may need treatment
 * during the application (e.g., body parameters may be deserialized based on
 * content type).
 *
 * Additionally, this interface recognizes the utility of introspecting a
 * request to derive and match additional parameters (e.g., via URI path
 * matching, decrypting cookie values, deserializing non-form-encoded body
 * content, matching authorization headers to users, etc). These parameters
 * are stored in an 'attributes' property.
 *
 * Requests are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return an instance that contains the changed state.
 */
class ServerRequest implements ServerRequestInterface
{
    use CommonTrait;
    use MessageTrait;
    use RequestTrait;

    /**
     * @var Collection
     */
    private $attributes;

    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The data MUST be compatible with the structure of the $_COOKIE
     * superglobal.
     *
     * @var array
     */
    private $cookieParams = [];

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @var mixed
     */
    private $parsedBody;

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from
     * `getUri()->getQuery()` or from the `QUERY_STRING` server param.
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @var array
     */
    private $serverParams = [];

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Psr\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @var array
     */
    private $uploadedFiles = [];

    /**
     * ServerRequest constructor.
     *
     * @param string                      $method
     * @param UriInterface|string|null    $uri
     * @param array                       $serverParams
     * @param StreamInterface|string      $body
     * @param array                       $headers
     * @param array                       $cookies
     * @param array                       $queryParams
     * @param array                       $uploadFiles
     * @param StreamInterface|string|null $parsedBody
     * @param string                      $protocol
     */
    public function __construct(
        string $method = 'GET',
        $uri = null,
        array $serverParams = [],
        $body = 'php://input',
        $headers = [],
        array $cookies = [],
        array $queryParams = [],
        array $uploadFiles = [],
        $parsedBody = null,
        string $protocol = '1.1'
    ) {

        if ('php://input' === $body) {
            $body = new Input();
        }

        $this->checkUploadedFiles($uploadFiles);

        $this->protocolVersion = $this->processProtocol($protocol);
        $this->method          = $this->processMethod($method);
        $this->headers         = $this->processHeaders($headers);
        $this->uri             = $this->processUri($uri);
        $this->body            = $this->processBody($body, 'w+b');
        $this->uploadedFiles   = $uploadFiles;
        $this->parsedBody      = $parsedBody;
        $this->serverParams    = $serverParams;
        $this->cookieParams    = $cookies;
        $this->queryParams     = $queryParams;
        $this->attributes      = new Collection();
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * Retrieves a single derived request attribute as described in
     * getAttributes(). If the attribute has not been previously set, returns
     * the default value as provided.
     *
     * This method obviates the need for a hasAttribute() method, as it allows
     * specifying a default value to return if the attribute is not found.
     *
     * @param string $name
     * @param null   $defaultValue
     *
     * @return mixed
     */
    public function getAttribute($name, $defaultValue = null)
    {
        return $this->attributes->get($name, $defaultValue);
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * The request 'attributes' may be used to allow injection of any
     * parameters derived from the request: e.g., the results of path
     * match operations; the results of decrypting cookies; the results of
     * deserializing non-form-encoded message bodies; etc. Attributes
     * will be application and request specific, and CAN be mutable.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes->toArray();
    }

    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The data MUST be compatible with the structure of the $_COOKIE
     * superglobal.
     *
     * @return array
     */
    public function getCookieParams()
    {
        return $this->cookieParams;
    }

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from
     * `getUri()->getQuery()` or from the `QUERY_STRING` server param.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @return null|array|object The deserialized body parameters, if any.
     *     These will typically be an array or object.
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @return array
     */
    public function getServerParams()
    {
        return $this->serverParams;
    }

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Psr\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @return array An array tree of UploadedFileInterface instances; an empty
     *     array MUST be returned if no data is present.
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated attribute.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ServerRequest
     */
    public function withAttribute($name, $value): ServerRequest
    {
        $attributes = clone $this->attributes;

        $attributes->set($name, $value);

        return $this->cloneInstance($attributes, 'attributes');
    }

    /**
     * Return an instance with the specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated cookie values.
     *
     * @param array $cookies
     *
     * @return ServerRequest
     */
    public function withCookieParams(array $cookies): ServerRequest
    {
        return $this->cloneInstance($cookies, 'cookieParams');
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or
     * objects, or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array|object|null $data
     *
     * @return ServerRequest
     * @throws InvalidArgumentException if an unsupported argument type is
     *     provided.
     *
     */
    public function withParsedBody($data): ServerRequest
    {
        return $this->cloneInstance($data, 'parsedBody');
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated query string arguments.
     *
     * @param array $query
     *
     * @return ServerRequest
     */
    public function withQueryParams(array $query): ServerRequest
    {
        return $this->cloneInstance($query, 'queryParams');
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array $uploadedFiles
     *
     * @return ServerRequest
     * @throws InvalidArgumentException if an invalid structure is provided.
     *
     */
    public function withUploadedFiles(array $uploadedFiles): ServerRequest
    {
        $this->checkUploadedFiles($uploadedFiles);

        return $this->cloneInstance($uploadedFiles, 'uploadedFiles');
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the attribute.
     *
     * @param string $name
     *
     * @return ServerRequest
     */
    public function withoutAttribute($name): ServerRequest
    {
        $attributes = clone $this->attributes;
        $attributes->remove($name);

        return $this->cloneInstance($attributes, 'attributes');
    }

    /**
     * Checks the uploaded files
     *
     * @param array $files
     */
    private function checkUploadedFiles(array $files): void
    {
        foreach ($files as $file) {
            if (true === is_array($file)) {
                $this->checkUploadedFiles($file);
            } else {
                if (!(true === is_object($file) &&
                    $file instanceof UploadedFileInterface)) {
                    throw new InvalidArgumentException(
                        'Invalid uploaded file'
                    );
                }
            }

        }
    }
}
