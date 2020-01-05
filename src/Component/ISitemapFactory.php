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

namespace Nepttune\Component;

interface ISitemapFactory
{
    public function create() : Sitemap;
}
