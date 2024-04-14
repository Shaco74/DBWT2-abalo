<?php

namespace Util;

use DateTime;

// This does not work, i cant import it from development seed
// _TODO: Ask teacher about this
class TimeUtil {
    /**
     * Parse a timestamp string into a formatted date string.
     *
     * @param string $timestamp The timestamp string to parse.
     * @param string $format The format of the output date string. Defaults to "Y-m-d H:i".
     * @return string The formatted date string.
     */
    public static function parseTimestamp(string $timestamp, string $format = "Y-m-d H:i"): string {
        // Explicitly specify the input date format
        $timestampAsDateTime = DateTime::createFromFormat('d.m.y H:i', $timestamp);
        // Format the date into the desired output format
        return $timestampAsDateTime->format($format);
    }

}

