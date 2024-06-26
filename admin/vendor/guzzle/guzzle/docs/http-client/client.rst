======================
The Guzzle HTTP client
======================

Guzzle gives PHP developers complete control over HTTP requests while utilizing HTTP/1.1 best practices. Guzzle's HTTP
functionality is a robust framework built on top of the `PHP libcurl bindings <http://www.php.net/curl>`_.

The three main parts of the Guzzle HTTP client are:

+--------------+-------------------------------------------------------------------------------------------------------+
| Clients      | ``Guzzle\Http\Client`` (creates and sends requests, associates a response with a request)             |
+--------------+-------------------------------------------------------------------------------------------------------+
| Requests     | ``Guzzle\Http\Message\Request`` (requests with no body),                                              |
|              | ``Guzzle\Http\Message\EntityEnclosingRequest`` (requests with a body)                                 |
+--------------+-------------------------------------------------------------------------------------------------------+
| Responses    | ``Guzzle\Http\Message\Response``                                                                      |
+--------------+-------------------------------------------------------------------------------------------------------+

Creating a Client
-----------------

Clients create requests, send requests, and set responses on a request object. When instantiating a client object,
you can pass an optional "base URL" and optional array of configuration options. A base URL is a
:doc:`URI template <uri-templates>` that contains the URL of a remote server. When creating requests with a relative
URL, the base URL of a client will be merged into the request's URL.

.. code-block:: php

    use Guzzle\Http\Client;

    // Create a client and provide a base URL
    $client = new Client('https://api.github.com');

    $request = $client->get('/user');
    $request->setAuth('user', 'pass');
    echo $request->getUrl();
    // >>> https://api.github.com/user

    // You must send a request in order for the transfer to occur
    $response = $request->send();

    echo $response->getBody();
    // >>> {"type":"User", ...

    echo $response->getHeader('Content-Length');
    // >>> 792

    $data = $response->json();
    echo $data['type'];
    // >>> User

Base URLs
~~~~~~~~~

Notice that the URL provided to the client's ``get()`` method is relative. Relative URLs will always merge into the
base URL of the client. There are a few rules that control how the URLs are merged.

.. tip::

    Guzzle follows `RFC 3986 <http://tools.ietf.org/html/rfc3986#section-5.2>`_ when merging base URLs and
    relative URLs.

In the above example, we passed ``/user`` to the ``get()`` method of the client. This is a relative URL, so it will
merge into the base URL of the client-- resulting in the derived URL of ``https://api.github.com/users``.

``/user`` is a relative URL but uses an absolute path because it contains the leading slash. Absolute paths will
overwrite any existing path of the base URL. If an absolute path is provided (e.g. ``/path/to/something``), then the
path specified in the base URL of the client will be replaced with the absolute path, and the query string provided
by the relative URL will replace the query string of the base URL.

Omitting the leading slash and using relative paths will add to the path of the base URL of the client. So using a
client base URL of ``https://api.twitter.com/v1.1`` and creating a GET request with ``statuses/user_timeline.json``
will result in a URL of ``https://api.twitter.com/v1.1/statuses/user_timeline.json``. If a relative path and a query
string are provided, then the relative path will be appended to the base URL path, and the query string provided will
be merged into the query string of the base URL.

If an absolute URL is provided (e.g. ``http://httpbin.org/ip``), then the request will completely use the absolute URL
as-is without merging in any of the URL parts specified in the base URL.

Configuration options
~~~~~~~~~~~~~~~~~~~~~

The second argument of the client's constructor is an array of configuration data. This can include URI template data
or special options that alter the client's behavior:

+-------------------------------+-------------------------------------------------------------------------------------+
| ``request.options``           | Associative array of :ref:`Request options <request-options>` to apply to every     |
|                               | request created by the client.                                                      |
+-------------------------------+-------------------------------------------------------------------------------------+
| ``redirect.disable``          | Disable HTTP redirects for every request created by the client.                     |
+-------------------------------+-------------------------------------------------------------------------------------+
| ``curl.options``              | Associative array of cURL options to apply to every request created by the client.  |
|                               | if either the key or value of an entry in the array is a string, Guzzle will        |
|                               | attempt to find a matching defined cURL constant automatically (e.g.                |
|                               | "CURLOPT_PROXY" will be converted to the constant ``CURLOPT_PROXY``).               |
+-------------------------------+-------------------------------------------------------------------------------------+
| ``ssl.certificate_authority`` | Set to true to use the Guzzle bundled SSL certificate bundle (this is used by       |
|                               | default, 'system' to use the bundle on your system, a string pointing to a file to  |
|                               | use a specific certificate file, a string pointing to a directory to use multiple   |
|                               | certificates, or ``false`` to disable SSL validation (not recommended).             |
|                               |                                                                                     |
|                               | When using  Guzzle inside of a phar file, the bundled SSL certificate will be       |
|                               | extracted to your system's temp folder, and each time a client is created an MD5    |
|                               | check will be performed to ensure the integrity of the certificate.                 |
+-------------------------------+-------------------------------------------------------------------------------------+
| ``command.params``            | When using a ``Guzzle\Service\Client`` object, this is an associative array of      |
|                               | default options to set on each command created by the client.                       |
+-------------------------------+-------------------------------------------------------------------------------------+

Here's an example showing how to set various configuration options, including default headers to send with each request,
default query string parameters to add to each request, a default auth scheme for each request, and a proxy to use for
each request. Values can be injected into the client's base URL using variables from the configuration array.

.. code-block:: php

    use Guzzle\Http\Client;

    $client = new Client('https://api.twitter.com/{version}', array(
        'version'        => 'v1.1',
        'request.options' => array(
            'headers' => array('Foo' => 'Bar'),
            'query'   => array('testing' => '123'),
            'auth'    => array('username', 'password', 'Basic|Digest|NTLM|Any'),
            'proxy'   => 'tcp://localhost:80'
        )
    ));

Setting a custom User-Agent
~~~~~~~~~~~~~~~~~~~~~~~~~~~

The default Guzzle User-Agent header is ``Guzzle/<Guzzle_Version> curl/<curl_version> PHP/<PHP_VERSION>``. You can
customize the User-Agent header of a client by calling the ``setUserAgent()`` method of a Client object.

.. code-block:: php

    // Completely override the default User-Agent
    $client->setUserA