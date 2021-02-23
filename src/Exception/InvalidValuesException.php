<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Exception;

use Exception;

class InvalidValuesException extends Exception
{
    /**
     * Constructor.
     *
     * @param mixed $values
     */
    public function __construct(mixed $values)
    {
        parent::__construct(
            'Could not validate values before export:' . print_r($values, true)
        );
    }
}
