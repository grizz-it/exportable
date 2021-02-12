# GrizzIT Exportable - Using the exporters

This package provides an interface for exportable objects. It also adds a few
basic implementations which can be used to validate simple data objects.

The interface that is provided is the
[ExportableComponentInterface](../../src/Common/ExportableComponentInterface.php).

## Exportable components

The provided exportable components in this package are:

### [ExportableDictionary](../../src/Component/ExportableDictionary.php)

This exportable component uses logic to fill an associative array type object
with information, which is verified on input. It expects the values to be
exportable components as well.

### [ExportableList](../../src/Component/ExportableList.php)

This exportable component uses logic to fill a numeric array type object
with information, which is verified on input. It expects the values to be
exportable components as well.

### [ValidatedExportableDictionary](../../src/Component/ValidatedExportableDictionary.php)

This exportable component uses logic to fill a numeric array type object
with information, which is verified on export. The values are free form, but
become part of an array. The validators from the package `grizz-it/validator`
can be used to construct a validator for the dictionary. If exportable
components are found during the export, these will be invoked as well.

## Further reading

[Back to usage index](index.md)
