==============
Request Method
==============

Frisby support your basic HTTP verbs.

* get(string $url, array $options = [])
* options(string $url, array $options = [])
* head(string $url, array $options = [])
* post(string $url, array $data = [], array $options = [])
* put(string $url, array $data = [], array $options = [])
* patch(string $url, array $data = [], array $options = [])
* delete(string $url, array $data = [], array $options = [])

Every request method accepts an array of options as its last argument,
Request options control various aspects of a request including, headers, timeout settings and much more

See `GuzzleRequestOptions`_  to see all request options avaiable.


.. get-request:

-------------------------------------
get(string $url, array $options = [])
-------------------------------------

Sends a GET request

.. code-block:: php

    <?php

    $options = [
        'headers'  => [
            'Accept' => 'application/json'
        ]
    ];

    $phisby->create()
        ->get('http://httpbin.org/get?foo=bar&bar=baz', $options)
        ->expectStatus(200)
        ->send();


.. post-request:

---------------------------------------------------------
post(string $url, array $data = [], array $options = [])
---------------------------------------------------------

Sends a POST request

.. code-block:: php

    <?php

    $data = [
        'foo' => 'bar',
        'bar' => 'baz'
    ];

    $options = [
        'headers'  => [
            'Content-Type' => 'application/json'
        ]
    ];

    $phisby->create()
        ->post('http://httpbin.org/post', $data, $options)
        ->expectStatus(200)
        ->send();


.. put-request:

---------------------------------------------------------
post(string $url, array $data = [], array $options = [])
---------------------------------------------------------

Sends a POST request

.. code-block:: php

    <?php

    $data = [
        'foo' => 'bar',
        'bar' => 'baz'
    ];

    $options = [
        'headers'  => [
            'Content-Type' => 'application/json'
        ]
    ];

    $phisby->create()
        ->put('http://httpbin.org/post', $data, $options)
        ->expectStatus(200)
        ->send();


.. put-request:

---------------------------------------------------------
put(string $url, array $data = [], array $options = [])
---------------------------------------------------------

Sends a PUT request

.. code-block:: php

    <?php

    $data = [
        'foo' => 'bar',
        'bar' => 'baz'
    ];

    $options = [
        'headers'  => [
            'Content-Type' => 'application/json'
        ]
    ];

    $phisby->create()
        ->put('http://httpbin.org/put', $data, $options)
        ->expectStatus(200)
        ->send();


.. patch-request:

---------------------------------------------------------
patch(string $url, array $data = [], array $options = [])
---------------------------------------------------------

Sends a PATCH request

.. code-block:: php

    <?php

    $data = [
        'foo' => 'bar',
        'bar' => 'baz'
    ];

    $options = [
        'headers'  => [
            'Content-Type' => 'application/json'
        ]
    ];

    $phisby->create()
        ->patch('http://httpbin.org/patch', $data, $options)
        ->expectStatus(200)
        ->send();


.. _GuzzleRequestOptions: http://guzzle.readthedocs.org/en/latest/request-options.html


