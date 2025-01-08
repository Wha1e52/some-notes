<?php

    use PHPUnit\Framework\TestCase;

    class ExceptionTest extends TestCase
    {
        /**
         * @throws Exception
         */
        public function testException() {
            $this->expectException(Exception::class);
            throw new Exception();
        }

        /**
         * @throws Exception
         */
        public function testException2() {
            $this->expectExceptionCode(10);
            throw new Exception('err', 10);
        }

        /**
         * @throws Exception
         */
        public function testException3() {
            $this->expectExceptionMessage('err');
            throw new Exception('err');
        }

        /**
         * @throws Exception
         */
        public function testExceptio4() {
            $this->expectExceptionMessageMatches('/^\d+$/');
            throw new Exception('123');
        }

    }