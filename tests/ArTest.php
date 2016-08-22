<?php

namespace eznio\ar\tests;

use eznio\ar\Ar;

class ArTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider arrayGetDataProvider
     * @param array $array
     * @param mixed $path
     * @param mixed $sampler
     */
    public function shouldReturnRightArrayGetValues($array, $path, $sampler)
    {
        $result = Ar::get($array, $path);

        $this->assertEquals($sampler, $result);
    }

    public static function arrayGetDataProvider()
    {
        return [
            [
                ['a' => 'b', 'c' => 'd', 'e' => 'f'],
                'c',
                'd'
            ],
            [
                ['a' => 'b', 'c' => 'd', 'e' => 'f'],
                'g',
                null
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                'a.b.c',
                'd'
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                'a.b',
                ['c' => 'd']
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                'a',
                ['b' => ['c' => 'd']]
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                '',
                null
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                '.b.c',
                null
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                'a.c',
                null
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                null,
                null
            ],
            [
                ['a' => ['b' => ['c' => 'd']]],
                'totallyWrongPath',
                null
            ],
            [
                null,
                'a',
                null
            ]
        ];
    }

    /**
     * @test
     * @dataProvider arrayMapDataProvider
     * @param array $arrayToMap
     * @param callable $mapperCallback
     * @param mixed $sampler
     */
    public function shouldReturnRightArrayMapValues($arrayToMap, $mapperCallback, $sampler)
    {
        $result = Ar::map($arrayToMap, $mapperCallback);

        $this->assertEquals($sampler, $result);
    }

    public static function arrayMapDataProvider()
    {
        return [
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                function ($item) {
                    return $item * 2;
                },
                ['a' => 2, 'b' => 4, 'c' => 6],
            ],
            [
                ['a' => 1, 'b' => 2, 'c' => 3],
                function ($item, $itemId) {
                    return ['x' . $itemId => $item * 2];
                },
                ['xa' => 2, 'xb' => 4, 'xc' => 6],
            ]

        ];
    }
}
