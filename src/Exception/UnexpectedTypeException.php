<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Exception;

use Exception;

class UnexpectedTypeException extends Exception
{
    /**
     * Constructor.
     *
     * @param string $throwingClass
     * @param string $expect
     * @param string $actualClass
     */
    public function __construct(
        string $throwingClass,
        string $expect,
        string $actualClass
    ) {
        parent::__construct(
            $throwingClass . ' expected instance of ' . $expect . ' but got ' .
            $actualClass
        );
    }
}
