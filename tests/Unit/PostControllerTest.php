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

    public function test_that_order_references_throws_exception() {
        $input = "Your text with footnotes here r1. For example, this and then this r3. r1: Note 1";
        $this->expectException(Exception::class);
        PostController::order_references($input, 'my-slug');
    }

    public function test_that_order_references_orders_references() {
        $input = "Your text with references here r0. For example, r0: this";
        $actual = PostController::order_references($input, 'my-slug');
        $expected = 'Your text with references here <span class="referenced-statement" id="refstate1"><a href="http://localhost:8000/posts/my-slug#ref1">[1]</a></span>. For example, <span class="reference" id="ref1"><a class="reference-backref" href="http://localhost:8000/posts/my-slug#refstate1">[1]</a></span>. this';

        $this->assertEquals($expected, $actual);
    }

    public function test_that_order_references_does_nothing() {
        $input = "Your text with footnotes here. For example, this and then this.";
        $actual = PostController::order_references($input, 'my-slug');

        $this->assertEquals($input, $actual);
    }
}
