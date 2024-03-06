<?php

namespace Tests\Unit;

use App\Http\Controllers\PostController;
use Exception;
use PHPUnit\Framework\TestCase;

class PostControllerTest extends TestCase {

    public function test_that_order_footnotes_throws_exception() {
        $text = "Your text with footnotes here. For example, this[^1] and then this[^3]. [^1]: Note 1";
        $this->expectException(Exception::class);
        PostController::order_footnotes($text);
    }

    public function test_that_order_footnotes_orders_references() {
        $input = "Your text with footnotes here. For example, this[^1] and then this[^3]. [^1]: Note 1 [^3]: note 2";
        $actual = PostController::order_footnotes($input);
        $expected = "Your text with footnotes here. For example, this[^1] and then this[^2]. [^1]: Note 1 [^2]: note 2";

        $this->assertEquals($expected, $actual);
    }
}
