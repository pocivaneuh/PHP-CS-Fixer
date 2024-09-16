<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\Tests\Fixer\Basic;

use PhpCsFixer\Tests\Test\AbstractFixerTestCase;

/**
 * @internal
 *
 * @covers \PhpCsFixer\Fixer\Basic\BreakLineFixer
 */
final class BreakLineFixerTest extends AbstractFixerTestCase
{
    /**
     * @dataProvider provideFixCases
     */
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }

    public static function provideFixCases()
    {
        // Array
        yield 'array' => [
            <<<'PHP'
            <?php

            $short = [
                $elem1,
                foobar(),
                $elem2,
            ];

            $long = array(
                $elem1,
                foobar(),
                $elem2,
            );

            $partial = [
                $elem1,

                foobar(),
                $elem2,
            ];

            PHP,
            <<<'PHP'
            <?php

            $short = [$elem1, foobar(), $elem2];

            $long = array($elem1, foobar(), $elem2);

            $partial = [
                $elem1,
                foobar(), $elem2];

            PHP,
        ];

        // // Attributes
        // yield 'attributes' => [
        //     <<<'PHP'
        //     <?php

        //     #[MyAttribute(
        //         foo: 'bar',
        //         magic: 42,
        //     )]
        //     class FooBar
        //     {
        //         #[Attr(
        //             foo: 'bar',
        //         )]
        //         private Property $property;

        //         #[Attr(
        //             foo: 'bar',
        //         )]
        //         private const CONSTANT = 42;

        //         #[Attr(
        //             foo: 'bar',
        //         )]
        //         public function foo(
        //             #[Attr(
        //                 foo: 'bar',
        //             )]
        //             #[Attr(
        //                 foo: 'bar',
        //             )]
        //             Param $param,
        //         )
        //         {
        //         }

        //         public function bar(#[Attr(
        //             foo: 'bar',
        //         )] #[Attr(
        //             foo: 'bar',
        //         )] Param $param1)
        //         {
        //         }
        //     }
        //     PHP,
        //     <<<'PHP'
        //     <?php

        //     #[MyAttribute(foo: 'bar', magic: 42)]
        //     class FooBar
        //     {
        //         #[Attr(foo: 'bar')]
        //         private Property $property;

        //         #[Attr(foo: 'bar')]
        //         private const CONSTANT = 42;

        //         #[Attr(foo: 'bar')]
        //         public function foo(
        //             #[Attr(foo: 'bar')]
        //             #[Attr(foo: 'bar')]
        //             Param $param,
        //         )
        //         {
        //         }

        //         public function bar(#[Attr(foo: 'bar')] #[Attr(foo: 'bar')] Param $param1)
        //         {
        //         }
        //     }
        //     PHP,
        // ];

        // yield 'attribute declaration' => [
        //     <<<'PHP'
        //     <?php

        //     #[Attribute(
        //         Attribute::TARGET_ALL,
        //     )]
        //     class FooBar
        //     {
        //     }
        //     PHP,
        //     <<<'PHP'
        //     <?php

        //     #[Attribute(Attribute::TARGET_ALL)]
        //     class FooBar
        //     {
        //     }
        //     PHP,
        // ];

        // // Function declarations
        // yield 'function declarations' => [
        //     <<<'PHP'
        //     <?php

        //     function test(
        //         Parameter $param1,
        //         Parameter $param2,
        //     ) {}
        //     PHP,
        //     <<<'PHP'
        //     <?php

        //     function test(Parameter $param1, Parameter $param2) {}
        //     PHP,
        // ];

        // yield 'method declarations' => [
        //     <<<'PHP'
        //     <?php

        //     class FooBar
        //     {
        //         public function foo(
        //             #[Attr(foo: 'bar')]
        //             #[Attr(foo: 'bar')]
        //             Param $param1,
        //             Param $param2,
        //         )
        //         {
        //         }

        //         public function bar(
        //             Param $param1,
        //             Param $param2,
        //         )
        //         {
        //         }
        //     }
        //     PHP,
        //     <<<'PHP'
        //     <?php

        //     class FooBar
        //     {
        //         public function foo(#[Attr(foo: 'bar')] #[Attr(foo: 'bar')] Param $param1, Param $param2)
        //         {
        //         }

        //         public function bar(Param $param1, Param $param2)
        //         {
        //         }
        //     }
        //     PHP,
        // ];

        // // Function calls
        // yield 'function calls' => [
        //     <<<'PHP'
        //     <?php

        //     bar(
        //         $param1,
        //         $param2,
        //     );

        //     Foo::bar(
        //         $param1,
        //         $param2,
        //     );

        //     $foo = new Foo(
        //         $param1,
        //         $param2,
        //     );
        //     $foo->bar(
        //         $param1,
        //         $param2,
        //     );

        //     $func = function (
        //         $param1,
        //         $param2,
        //     ) use (
        //         $var1,
        //         $var2,
        //     ) {
        //     };

        //     $arrowFunc = function (
        //         $param1,
        //         $param2,
        //     ) use (
        //         $var1,
        //         $var2,
        //     ) {
        //     };
        //     PHP,
        //     <<<'PHP'
        //     <?php

        //     bar($param1, $param2);

        //     Foo::bar($param1, $param2);

        //     $foo = new Foo($param1, $param2);
        //     $foo->bar($param1, $param2);

        //     $func = function ($param1, $param2) use ($var1, $var2) {
        //     };

        //     $arrowFunc = function ($param1, $param2) use ($var1, $var2) {
        //     };
        //     PHP,
        // ];
    }
}
