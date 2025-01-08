<?php

    namespace tests;

    use PHPUnit\Framework\Attributes\DataProvider;
    use PHPUnit\Framework\Attributes\Depends;
    use PHPUnit\Framework\TestCase;
    function add_numbers($a, $b) {
        return $a + $b;
    };

    class CalculatorTest extends TestCase
    {
        #[DataProvider('argProvider')] public function testPositiveNumbers($a, $b) {
            $this->assertEquals($a + $b, add_numbers($a, $b));
        }

        #[Depends('testDependSomething')] public function testMixedNumbers($number) {
            $this->assertEquals($number, add_numbers(-2, 3));
        }

        public function testNegativeNumbers() {
            $this->assertEquals(-5, add_numbers(-2, -3));
        }

        public function testDependSomething() {
            $this->assertEquals(1, 1);
            return 1;
        }

        public function testZero() {
            $this->assertEquals(0, add_numbers(0, 0));
        }

        public function testOutput() {
            $this->expectOutputString('foo');
            echo 'foo';
        }

        public function testOutput2() {
            $this->expectOutputRegex('/f.+/');
            echo 'foo';
        }


        public static function argProvider() {
            return [
                [2, 3],
                [1, 2],
                [0, 0]
            ];
        }


    }
