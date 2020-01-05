<?php

/**
 * This file is part of inifnityloop-dev/sitemap (https://www.infinityloop.dev)
 *
 * Copyright (c) 2018 Václav Pelíšek (peldax@infinityloop.dev)
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <https://www.peldax.com>.
 */

declare(strict_types = 1);

namespace Nepttune\TI;

trait TSitemap
{
    public static function getSitemap() : array
    {
        $pages = [];

        /** @var \Nette\Application\UI\ComponentReflection $reflection */
        $reflection = static::getReflection();

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method)
        {
            if ($method->isStatic() ||
                !$method->isPublic() ||
                !$method->hasAnnotation('sitemap') ||
                substr($method->name, 0, 6) !== 'action')
            {
                continue;
            }

            $regex = '/App\\\\([A-Z][a-z]*)Module\\\\Presenter\\\\([A-Z][a-z]*)Presenter/';
            $matches = [];
            preg_match($regex, $reflection->name, $matches);

            if (\count($matches) < 3)
            {
                continue;
            }

            $pages[] = ":{$matches[1]}:{$matches[2]}:" . lcfirst(substr($method->name, 6));
        }

        return $pages;
    }
}
