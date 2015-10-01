============
Expectations
============


Expectation methods are used before the ``send`` method call to generate phpunit assertions.
These helpers make testing API response bodies and headers easy with minimal time and effort.


.. expect-status:

-----------------------------
expectStatus(int $statusCode)
-----------------------------

Assert that HTTP Status code equals expectation

.. code-block:: php

    <?php

    $frisby->create()
        ->get('https://api.github.com/users/FabioBatSilva')
        ->expectStatus(200)
        ->send();


.. expect-headers:

-----------------------------
expectHeaders(array $headers)
-----------------------------

Assert the HTTP response headers

.. code-block:: php

    <?php

    $frisby->create()
        ->get('https://api.github.com/users/FabioBatSilva')
        ->expectHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])
        ->send();


.. expect-json:

-------------------------------------
expectJSON(string $path, array $data)
-------------------------------------

Tests that response JSON body contains the provided keys/values in the response.

.. code-block:: php

    <?php

    $frisby->create()
        ->get('https://api.github.com/users/FabioBatSilva')
        ->expectJSON('.', [
            'id'     => 588172,
            'login'  => 'FabioBatSilva'
        ])
        ->send();


.. expect-json-types:

------------------------------------------
expectJSONTypes(string $path, array $types)
-------------------------------------------

Tests that response JSON body contains the provided keys/values types.

.. code-block:: php

    <?php

    $frisby->create()
        ->get('https://api.github.com/users/FabioBatSilva')
        ->expectJSONTypes('.', [
            'id'     => 'integer',
            'login'  => 'string'
        ])
        ->send();


.. expect-json-path:

-----------------------------------------------
Using Paths with expectJSON and expectJSONTypes
-----------------------------------------------

Both expectJSON and expectJSONTypes accept a path as the first parameter.
The path parameter can be a nested path separated by periods, like ``args.foo.mypath``,
a simple path like ``results`` or ``.`` to test the whole JSON.

.. code-block:: php

    <?php

    $frisby->create()
        ->get('http://httpbin.org/get?foo=bar&bar=baz')
        ->expectJSON('args', [
            'bar' => 'foo',
            'foo' => 'bar'
        ])
        ->expectJSONTypes('args', [
            'bar' => 'string',
            'foo' => 'string'
        ])
        ->send();
