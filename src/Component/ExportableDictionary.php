<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Component;

use GrizzIt\Exportable\Exception\UnexpectedTypeException;
use GrizzIt\Exportable\Common\ExportableComponentInterface;

class ExportableDictionary implements ExportableComponentInterface
{
    /**
     * Contains the items registered to the exportable component.
     *
     * @var ExportableComponentInterface[]
     */
    private $items = [];

    /**
     * Whether or not the type of the input should be restricted.
     *
     * @var string|null
     */
    private $restrict;

    /**
     * Constructor.
     *
     * @param string|null $restrict
     */
    public function __construct(?string $restrict)
    {
        $this->restrict = $restrict;
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
     * Retrieves a registered item.
     *
     * @param string $key
     *
     * @return ExportableComponentInterface
     */
    public function getItem(string $key): ExportableComponentInterface
    {
        return $this->items[$key];
    }

    /**
     * Checks whether an item is registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasItem(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Remove an item from the component.
     *
     * @param string $key
     *
     * @return void
     */
    public function removeItem(string $key): void
    {
        unset($this->items[$key]);
    }

    /**
     * Sets an exportable item on the component.
     *
     * @param string $key
     * @param ExportableComponentInterface $item
     *
     * @return void
     */
    public function setItem(
        string $key,
        ExportableComponentInterface $item
    ): void {
        if ($this->restrictInput($item)) {
            $this->items[$key] = $item;
        }
    }

    /**
     * Exports the object to a public facing definition.
     *
     * @return mixed
     */
    public function export()
    {
        $export = [];
        foreach ($this->items as $key => $item) {
            $export[$key] = $item->export();
        }

        return $export;
    }
}
