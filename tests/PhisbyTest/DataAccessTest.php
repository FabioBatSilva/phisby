<?php

namespace PhisbyTest;

use Phisby\DataAccess;

class DataAccessTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [
                [
                    'foo' => 'bar'
                ],
                '.',
                ['foo' => 'bar']
            ],

            [
                [
                    'foo' => 'bar'
                ],
                'foo',
                'bar'
            ],

            [
                [
                    'foo' => [
                        'bar' => 'foobar'
                    ]
                ],
                'foo.bar',
                'foobar'
            ],

            [
                [
                    'foo' => [
                        'bar' => [0, 1, 2]
                    ]
                ],
                'foo.bar[1]',
                1
            ],

            [
                [
                    'foo' => [
                        'bar' => [
                            ['foo' => 'bar'],
                            ['bar' => 'foo']
                        ]
                    ]
                ],
                'foo.bar[1].bar',
                'foo'
            ],

            [
                [
                    'foo' => [
                        'bar' => [
                            ['foo' => 'bar', 'bar' => [1,2,3]],
                            ['foo' => 'bar', 'bar' => [4,5,6]]
                        ]
                    ]
                ],
                'foo.bar[0].bar',
                [1,2,3]
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetData($data, $path, $expected)
    {
        $instance = new DataAccess($data);
        $actual   = $instance->get($path);

        $this->assertEquals($expected, $actual);
    }

    public function dataProviderOutOfBoundsException()
    {
        return [
            [
                [],
                'bar',
                'bar'
            ],

            [
                [
                    'foo' => []
                ],
                'foo.bar',
                'foo.bar'
            ],

            [
                [
                    'foo' => [
                        'bar' => [0]
                    ]
                ],
                'foo.bar[3]',
                'foo.bar[3]',
            ],

            [
                [
                    'foo' => [
                        'bar' => []
                    ]
                ],
                'foo.bar[0].bar',
                'foo.bar[0]',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderOutOfBoundsException
     */
    public function testOutOfBoundsException($data, $path, $context)
    {
        $instance = new DataAccess($data);

        try {
            $instance->get($path);
            $this->fail('fail to throw OutOfBoundsException');
        } catch (\OutOfBoundsException $e) {
            $this->assertEquals("Undefined index at '$context'", $e->getMessage());
        }
    }
}
