<?php

namespace GrizzIt\Exportable\Tests\Component;

use PHPUnit\Framework\TestCase;
use GrizzIt\Exportable\Exception\InvalidValuesException;
use GrizzIt\Validator\Component\Logical\AlwaysValidator;
use GrizzIt\Exportable\Common\ExportableComponentInterface;
use GrizzIt\Exportable\Component\ValidatedExportableDictionary;

/**
 * @coversDefaultClass \GrizzIt\Exportable\Component\ValidatedExportableDictionary
 * @covers \GrizzIt\Exportable\Exception\InvalidValuesException
 */
class ValidatedExportableDictionaryTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::export
     * @covers ::exportChildren
     *
     * @return void
     */
    public function testComponent(): void
    {
        $item = $this->createMock(ExportableComponentInterface::class);
        $item->expects(static::once())
            ->method('export')
            ->willReturn('baz');

        $values = ['foo' => ['bar' => $item]];
        $subject = new ValidatedExportableDictionary(
            new AlwaysValidator(true),
            $values
        );

        $this->assertEquals(['foo' => ['bar' => 'baz']], $subject->export());
    }

    /**
     * @covers ::__construct
     * @covers ::export
     * @covers ::exportChildren
     *
     * @return void
     */
    public function testComponentFail(): void
    {
        $item = $this->createMock(ExportableComponentInterface::class);
        $item->expects(static::once())
            ->method('export')
            ->willReturn('baz');

        $values = ['foo' => ['bar' => $item]];
        $subject = new ValidatedExportableDictionary(
            new AlwaysValidator(false),
            $values
        );

        $this->expectException(InvalidValuesException::class);
        $subject->export();
    }
}
