======
Phisby
======


Frisby is a API testing tool for phpunit inspired by `Frisbyjs`_.
Read below for a quick overview, or check out the API documentation.

.. _install-phisby:

--------------
Install Phisby
--------------

Here is a `Composer`_ example::

    $ composer require "phisby/phisby""


------------
Basic Usage
------------

Phisby tests start by creating a phisby object :

.. code-block:: php

    <?php
    use Phisby\Phisby;

    $frisby = new Phisby();


As an optional argument ``Phisby\Phisby`` takes an instance of ``\GuzzleHttp\ClientInterface`` wich is used to all request :


.. code-block:: php

    <?php
    use Phisby\Phisby;
    use GuzzleHttp\Client;

    $uri    = 'http://localhost/api/1.0';
    $guzzle = new Client(['base_uri' => $uri]);
    $frisby = new Phisby($guzzle);

.. note::
    Please see `GuzzleRequestOptions`_  to see all request options avaiable.


------------
Write Tests
------------

Phisby tests start with one by calling one of ``get``, ``post``, ``put``, ``delete``, or ``head``, and ends with ``send`` to generate an HTTP request and assert the result.

Phisby has many built-in test helpers like :

* ``$phisby->expectStatus()`` to easily test HTTP status codes
* ``$phisby->expectHeaders()`` to test expected HTTP headers
* ``$phisby->expectJSON()`` to test expected JSON keys/values
* ``$phisby->expectJSONTypes()`` to test JSON value types

eq :

.. code-block:: php

    <?php
    use Phisby\Phisby;

    $frisby = new Phisby();

    $frisby->create()
        ->get('https://api.github.com/users/FabioBatSilva')
        ->expectStatus(200)
        ->expectHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])
        ->expectJSONTypes('.', [
            'id'    => 'integer',
            'login' => 'string',
            'url'   => 'string'
        ])
        ->expectJSON('.', [
            'id'    => '588172',
            'login' => 'FabioBatSilva',
            'url'   => 'https://api.github.com/users/FabioBatSilva',
        ])
        ->send();


-----------
Development
-----------

All development is done on Github_.
Use Issues_ to report problems or submit contributions.

.. _Github: https://github.com/FabioBatSilva/phisby
.. _Issues: https://github.com/FabioBatSilva/phisby/issues

.. _Frisbyjs: http://frisbyjs.com/
.. _Composer: https://getcomposer.org

.. _GuzzleRequestOptions: http://guzzle.readthedocs.org/en/latest/request-options.html


Contents
--------

.. toctree::
   :maxdepth: 1

   expectations
   request-method