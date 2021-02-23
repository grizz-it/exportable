<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Component;

use GrizzIt\Exportable\Exception\UnexpectedTypeException;
use GrizzIt\Exportable\Common\ExportableComponentInterface;

class ExportableList implements ExportableComponentInterface
{
    /**
     * Contains the items registered to the exportable component.
     *
     * @var ExportableComponentInterface[]
     */
    private array $items;

    /**
     * Whether or not the type of the input should be restricted.
     *
     * @var string|null
     */
    private ?string $restrict;

    /**
     * Constructor.
     *
     * @param string|null $restrict
     * @param ExportableComponentInterface ...$items
     */
    public function __construct(
        ?string $restrict,
        ExportableComponentInterface ...$items
    ) {
        $this->restrict = $restrict;
        if ($this->restrictInputs(...$items)) {
            $this->items = $items;
        }
    }

    /**
     * Restrict multiple inputs.
     *
     * @param ExportableComponentInterface ...$items
     *
     * @return bool
     */
    private function restrictInputs(
        ExportableComponentInterface ...$items
    ): bool {
        if ($this->restrict !== null) {
            foreach ($items as $item) {
                $this->restrictInput($item);
            }
        }

        return true;
    }

    /**
     * Restricts the input when it is set-up.
     *
     * @param ExportableComponentInterface $item
     *
     * @return bool
     *
     * @throws UnexpectedTypeException When the passed class is not of the correct type.
     */
    private function restrictInput(ExportableComponentInterface $item): bool
    {
        if (
            $this->restrict !== null &&
            !($item instanceof $this->restrict)
        ) {
            throw new UnexpectedTypeException(
                static::class,
                $this->restrict,
                get_class($item)
            );
        }

        return true;
    }

    /**
     * Retrieves all registered items.
     *
     * @return ExportableComponentInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Overwrites all exportable components.
     *
     * @param ExportableComponentInterface ...$items
     *
     * @return void
     */
    public function setItems(ExportableComponentInterface ...$items): void
    {
        if ($this->restrictInputs(...$items)) {
            $this->items = $items;
        }
    }

    /**
     * Adds an exportable item to the list.
     *
     * @param ExportableComponentInterface $item
     *
     * @return void
     */
    public function addItem(ExportableComponentInterface $item): void
    {
        if ($this->restrictInput($item)) {
            $this->items[] = $item;
        }
    }

    /**
     * Exports the object to a public facing definition.
     *
     * @return mixed
     */
    public function export(): mixed
    {
        $export = [];
        foreach ($this->items as $item) {
            $export[] = $item->export();
        }

        return $export;
    }
}
