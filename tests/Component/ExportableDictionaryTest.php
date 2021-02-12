<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Tests\Component;

use PHPUnit\Framework\TestCase;
use GrizzIt\Exportable\Component\ExportableDictionary;
use GrizzIt\Exportable\Exception\UnexpectedTypeException;
use GrizzIt\Exportable\Common\ExportableComponentInterface;

/**
 * @coversDefaultClass \GrizzIt\Exportable\Component\ExportableDictionary
 * @covers \GrizzIt\Exportable\Exception\UnexpectedTypeException
 */
class ExportableDictionaryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::restrictInput
     * @covers ::getItems
     * @covers ::getItem
     * @covers ::hasItem
     * @covers ::removeItem
     * @covers ::setItem
     * @covers ::export
     */
    public function testComponent(): void
    {
        $testObject = $this->createMock(ExportableComponentInterface::class);

        $testObject->expects(static::once())
            ->method('export')
            ->willReturn('bar');

        $subject = new ExportableDictionary(null);
        $this->assertEquals([], $subject->getItems());
        $this->assertEquals(false, $subject->hasItem('foo'));

        $subject->setItem('foo', $testObject);

        $this->assertEquals(true, $subject->hasItem('foo'));
        $this->assertEquals($testObject, $subject->getItem('foo'));

        $this->assertEquals(['foo' => 'bar'], $subject->export());

        $this->assertEquals(['foo' => $testObject], $subject->getItems());
        $subject->removeItem('foo');
        $this->assertEquals([], $subject->getItems());
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::restrictInput
     * @covers ::setItem
     */
    public function testComponentFailure(): void
    {
        $testObject = $this->createMock(ExportableComponentInterface::class);
        $subject = new ExportableDictionary(ExportableDictionary::class);

        $this->expectException(UnexpectedTypeException::class);
        $subject->setItem('foo', $testObject);
    }
}
