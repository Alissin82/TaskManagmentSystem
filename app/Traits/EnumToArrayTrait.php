<?php

namespace App\Traits;

trait EnumToArrayTrait
{
    /**
     * Returns an array of the names of the enum cases in lowercase.
     * This method uses the `names()` method to fetch all case names
     * and then converts them to lowercase.
     *
     * @return array An array containing the names of the enum cases in lowercase.
     */
    public static function lowercaseNames(): array
    {
        return array_map('strtolower', self::names());
    }

    /**
     * Returns an array of the names of the enum cases.
     * This method retrieves all enum cases and extracts their names.
     *
     * @return array An array containing the names of the enum cases.
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Returns an associative array that combines names and values of the enum cases.
     * The keys are the names of the enum cases, and the values are their corresponding values.
     *
     * @return array An associative array where the keys are case names and the values are case values.
     */
    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    /**
     * Returns an array of the values of the enum cases.
     * This method retrieves all enum cases and extracts their values.
     *
     * @return array An array containing the values of the enum cases.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
