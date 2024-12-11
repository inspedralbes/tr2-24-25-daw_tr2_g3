<?php

namespace app\Helpers;

class GeneralHelper
{
    /**
     * Genera un slug a partir del nombre.
     *
     * @param string $name
     * @return string
     */
    public static function generateSlug(string $name): string
    {
        return strtolower(str_replace(' ', '-', $name));
    }

    /**
     * Genera un código único para el formulario.
     *
     * @param string $prefix
     * @param int $id
     * @return string
     */
    public static function generateCode(string $prefix, int $id): string
    {
        return $prefix . str_pad($id, 5, '0', STR_PAD_LEFT); // Ejemplo: FOR00001
    }
}
