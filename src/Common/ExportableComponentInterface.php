<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Exportable\Common;

interface ExportableComponentInterface
{
    /**
     * Exports the object to a public facing definition.
     *
     * @return mixed
     */
    public function export(): mixed;
}
