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

namespace Nepttune\Component;

final class Sitemap extends BaseComponent
{
    /** @var \Nette\DI\Container */
    private $context;

    /** @var \Nette\Caching\Cache */
    private $cache;

    public function __construct(\Nette\DI\Container $context, \Nette\Caching\IStorage $storage)
    {
        parent::__construct();
        
        $this->context = $context;
        $this->cache = new \Nette\Caching\Cache($storage, 'Nepttune.Sitemap');
    }

    protected function beforeRender() : void
    {
        $this->template->pages = $this->cache->call([$this, 'getPages']);
        $this->template->date = new \Nette\Utils\DateTime();
    }

    public function getPages() : array
    {
        $pages = [];

        foreach ($this->context->findByType(\Nepttune\TI\ISitemap::class) as $name)
        {
            /** @var \Nepttune\TI\ISitemap $presenter */
            $presenter = $this->context->getService($name);
            $pages = \array_merge($pages, $presenter->getSitemap());
        }

        return $pages;
    }
}
