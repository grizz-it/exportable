<?php

namespace GrizzIt\Exportable\Tests\Component;

use PHPUnit\Framework\TestCase;
use GrizzIt\Exportable\Component\ExportableList;
use GrizzIt\Exportable\Exception\UnexpectedTypeException;
use GrizzIt\Exportable\Common\ExportableComponentInterface;

/**
 * @coversDefaultClass \GrizzIt\Exportable\Component\ExportableList
 * @covers \GrizzIt\Exportable\Exception\UnexpectedTypeException
 */
class ExportableListTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::restrictInputs
     * @covers ::getItems
     * @covers ::setItems
     * @covers ::addItem
     * @covers ::export
     *
     * @return void
     */
    public function testComponent(): void
    {
        $item = $this->createMock(ExportableComponentInterface::class);
        $item->expects(static::once())
            ->method('export')
            ->willReturn('foo');

        $itemTwo = $this->createMock(ExportableComponentInterface::class);
        $itemTwo->expects(static::once())
            ->method('export')
            ->willReturn('bar');

        $subject = new ExportableList(null, $item);

        $this->assertEquals([$item], $subject->getItems());
        $subject->addItem($itemTwo);
        $this->assertEquals(['foo', 'bar'], $subject->export());
        $subject->setItems($itemTwo);
        $this->assertEquals([$itemTwo], $subject->getItems());
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::restrictInput
     * @covers ::restrictInputs
     * @covers ::setItems
     */
    public function testComponentFailure(): void
    {
        $item = $this->createMock(ExportableComponentInterface::class);
        $subject = new ExportableList(
            ExportableList::class,
            new ExportableList(null)
        );
        $this->expectException(UnexpectedTypeException::class);
        $subject->setItems($item);
    }
}
