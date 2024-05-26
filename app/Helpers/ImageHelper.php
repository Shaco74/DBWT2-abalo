<?php
// app/Helpers/ImageHelper.php

namespace App\Helpers;

/**
 * Class ImageHelper
 *
 * This class provides helper methods related to image handling.
 */
class ImageHelper {
    /**
     * Renders an image if present, otherwise returns a placeholder text.
     *
     * @param string|null $image The URL of the image to render.
     * @return string The HTML string of the image or a placeholder text.
     */
    public static function renderImageIfPresent($image): string {
        if ($image) {
            return '<img width="200px" src="' . $image . '" alt="Ein Bild des Produktes"/>';
        }
        return '<p>Kein Bild vorhanden :(</p>';
    }
}
