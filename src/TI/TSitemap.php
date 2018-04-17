<?php

/**
 * This file is part of Nepttune (https://www.peldax.com)
 *
 * Copyright (c) 2018 Václav Pelíšek (info@peldax.com)
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <https://www.peldax.com>.
 */

declare(strict_types = 1);

namespace Nepttune\TI;

trait TSitemap
{
    public function getSitemap() : array
    {
        $pages = [];

        /** @var \Nette\Application\UI\ComponentReflection $reflection */
        $reflection = static::getReflection();

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method)
        {
            if ($method->class !== $reflection->getName() || substr($method->name, 0, 6) !== 'action')
            {
                continue;
            }

            if ($method->hasAnnotation('sitemap'))
            {
                $regex = '/App\\\\([A-Z][a-z]*)Module\\\\Presenter\\\\([A-Z][a-z]*)Presenter/';
                $matches = [];

                preg_match($regex, $reflection->name, $matches);

                if (\count($matches) < 3)
                {
                    continue;
                }

                $pages[] = ":{$matches[1]}:{$matches[2]}:" . lcfirst(substr($method->name, 6));
            }
        }

        return $pages;
    }
}
