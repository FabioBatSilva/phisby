# Phisby

[![Build Status](https://travis-ci.org/FabioBatSilva/phisby.svg)](https://travis-ci.org/FabioBatSilva/phisby)
[![Coverage Status](https://coveralls.io/repos/FabioBatSilva/phisby/badge.svg?branch=master&service=github)](https://coveralls.io/github/FabioBatSilva/phisby?branch=master)

A REST API testing framework inspired by frisby-js, written in PHP


## Installation

Run the following `composer` command:

```console
$ composer require "phisby/phisby"
```

## Basic Usage.

```php

use Phisby\Phisby

$frisby = new Phisby();

$frisby
    ->get('http://localhost/api/1.0/users/3.json')
    ->expectStatus(200)
    ->expectJSONTypes('.', [
        'id'        => 'integer',
        'username'  => 'string',
        'is_admin'  => 'boolean'
    ])
    ->expectJSON('.',[
        'id'        => 3,
        'username'  => 'johndoe',
        'is_admin'  => false
    ])
    ->send();

```


## PHPUnit test case.

```php

use Phisby\PhisbyTestCase;

class PhisbyTest extends PhisbyTestCase
{
    public function testGithubSearch()
    {
        $this->phisby
            ->get('https://api.github.com/search/repositories?q=doctrine+language:php&sort=stars&order=desc&per_page=1')
            ->expectStatus(200)
            ->expectHeaders([
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->expectJSONTypes('.', [
                'total_count'        => 'integer',
                'incomplete_results' => 'boolean',
                'items'              => 'array'
            ])
            ->expectJSONTypes('items[0]', [
                'id'      => 'integer',
                'name'    => 'string',
                'private' => 'boolean'
            ])
            ->expectJSON('items[0]',[
                'id'    => 597887,
                'name'  => 'doctrine2'
            ])->send();
    }
}

```
