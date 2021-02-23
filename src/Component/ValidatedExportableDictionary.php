<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Component;

use ArrayIterator;
use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Exportable\Exception\InvalidValuesException;
use GrizzIt\Exportable\Common\ExportableComponentInterface;

class ValidatedExportableDictionary extends ArrayIterator implements ExportableComponentInterface
{
    /**
     * Contains the validator for the object.
     *
     * @var ValidatorInterface|null
     */
    private ?ValidatorInterface $validator;

    /**
     * Constructor.
     *
     * @param ValidatorInterface|null $validator
     * @param array $values
     */
    public function __construct(
        ?ValidatorInterface $validator,
        array $values = []
    ) {
        parent::__construct($values);
        $this->validator = $validator;
    }

    /**
     * Exports the object to a public facing definition.
     *
     * @return mixed
     */
    public function export(): mixed
    {
        $values = $this->exportChildren($this->getArrayCopy());
        if (
            $this->validator !== null &&
            !$this->validator->__invoke($values)
        ) {
            throw new InvalidValuesException($values);
        }

        return $values;
    }

    /**
     * Exports all children exportable components.
     *
     * @param mixed $values
     *
     * @return mixed
     */
    private function exportChildren(mixed $values): mixed
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $values[$key] = $this->exportChildren($value);
            }
        }

        if ($values instanceof ExportableComponentInterface) {
            return $values->export();
        }

        return $values;
    }
}
