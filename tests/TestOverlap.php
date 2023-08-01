<?php

require 'app/Overlap.php';

use PHPUnit\Framework\TestCase;

class TestOverlap extends TestCase
{
    protected Overlap $app;

    public function setUp(): void
    {
        $this->app = new Overlap();
    }

    public function testGetOverlap_WithLeftOverlap(): void
    {
        $range1 = [1, 5];
        $range2 = [5, 10];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 5, 'Overlapping end:' => 5], $answer);
    }

    public function testGetOverlap_WithRightOverlap(): void
    {
        $range1 = [5, 1];
        $range2 = [10, 5];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 5, 'Overlapping end:' => 5], $answer);
    }

    public function testGetOverlap_WithReversedRanges(): void
    {
        $range1 = [5, 1];
        $range2 = [5, 1];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 1, 'Overlapping end:' => 5], $answer);
    }

    public function testGetOverlap_WithNoOverlap(): void
    {
        $range1 = [1, 10];
        $range2 = [20, 30];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }

    public function testGetOverlap_WithAdjacentRanges(): void
    {
        $range1 = [0, 1];
        $range2 = [1, 0];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 0, 'Overlapping end:' => 1], $answer);
    }

    public function testGetOverlap_WithIdenticalRanges(): void
    {
        $range1 = [0, 1];
        $range2 = [0, 1];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 0, 'Overlapping end:' => 1], $answer);
    }

    public function testGetOverlap_WithPartialOverlap(): void
    {
        $range1 = [-1, 5];
        $range2 = [0, 1];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 0, 'Overlapping end:' => 1], $answer);
    }

    public function testNoOverlapWithSameValues(): void
    {
        $range1 = [5, 5];
        $range2 = [5, 5];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 5, 'Overlapping end:' => 5], $answer);
    }

    public function testNoOverlap(): void
    {
        $range1 = [10, 20];
        $range2 = [30, 40];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }

    public function testNegativeRanges(): void
    {
        $range1 = [-10, -5];
        $range2 = [-8, -3];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => -8, 'Overlapping end:' => -5], $answer);
    }

    public function testMixedPositiveAndNegativeRanges(): void
    {
        $range1 = [-10, -5];
        $range2 = [3, 7];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }

    public function testZeroRange(): void
    {
        $range1 = [0, 0];
        $range2 = [0, 0];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 0, 'Overlapping end:' => 0], $answer);
    }

    public function testLargeRanges(): void
    {
        $range1 = [PHP_INT_MIN, PHP_INT_MAX];
        $range2 = [0, PHP_INT_MAX];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 0, 'Overlapping end:' => PHP_INT_MAX], $answer);
    }
    public function testGetOverlap_WithFloatNumbers(): void
    {
        $range1 = [0.5, 3.2];
        $range2 = [2.8, 4.6];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 2.8, 'Overlapping end:' => 3.2], $answer);
    }

    public function testGetOverlap_WithFloatAndIntegerNumbers(): void
    {
        $range1 = [1, 5];
        $range2 = [2.5, 6];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 2.5, 'Overlapping end:' => 5], $answer);
    }

    public function testGetOverlap_WithNegativeFloatNumbers(): void
    {
        $range1 = [-3.5, -1.2];
        $range2 = [-2.8, -1.5];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => -2.8, 'Overlapping end:' => -1.5], $answer);
    }

    public function testGetOverlap_WithNoOverlap_FloatNumbers(): void
    {
        $range1 = [1.1, 2.2];
        $range2 = [3.3, 4.4];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }
    public function testGetOverlap_WithMultipleValuesInRanges1(): void
    {
        $range1 = [1, 5, 7, 9];
        $range2 = [3, 8];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 3, 'Overlapping end:' => 8], $answer);
    }

    public function testGetOverlap_WithMultipleValuesInRanges2(): void
    {
        $range1 = [1, 2, 3, 4];
        $range2 = [2.5, 3.5];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 2.5, 'Overlapping end:' => 3.5], $answer);
    }

    public function testGetOverlap_WithNoOverlap_MultipleValuesInRanges(): void
    {
        $range1 = [1, 3, 5, 7];
        $range2 = [8, 10];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }

    public function testGetOverlap_WithFloatNumbers_MultipleValuesInRanges(): void
    {
        $range1 = [0.5, 1.5, 3.3, 4.2];
        $range2 = [1, 3, 2.7, 4];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 1, 'Overlapping end:' => 4], $answer);
    }
    public function testGetOverlap_WithLargeFloatNumbers1(): void
    {
        $range1 = [1e12, 2e12];
        $range2 = [1.5e12, 2.5e12];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 1.5e12, 'Overlapping end:' => 2e12], $answer);
    }

    public function testGetOverlap_WithLargeFloatNumbers2(): void
    {
        $range1 = [1.23456789e15, 1.23456790e15, 1.23456791e15];
        $range2 = [1.23456791e15, 1.23456795e15];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Overlapping start:' => 1.23456791e15, 'Overlapping end:' => 1.23456791e15], $answer);
    }


    public function testGetOverlap_WithLargeFloatNumbers_NoOverlap(): void
    {
        $range1 = [1e18, 2e18, 3e18];
        $range2 = [4e18, 5e18];
        $answer = $this->app->getOverlap($range1, $range2);
        $this->assertEquals(['Message:' => 'Overlap not found.'], $answer);
    }
}