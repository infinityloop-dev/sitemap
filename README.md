# Sitemap
:wrench: Sitemap generator component

![Packagist](https://img.shields.io/packagist/dt/nepttune/sitemap.svg)
![Packagist](https://img.shields.io/packagist/v/nepttune/sitemap.svg)
[![CommitsSinceTag](https://img.shields.io/github/commits-since/nepttune/sitemap/v1.1.1.svg?maxAge=600)]()

[![Code Climate](https://codeclimate.com/github/nepttune/sitemap/badges/gpa.svg)](https://codeclimate.com/github/nepttune/sitemap)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nepttune/sitemap/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nepttune/sitemap/?branch=master)

## Introduction

This componenet automaticaly generates sitemap from annotated presenter actions. Found actions are cached to improve performance.

## Dependencies

- [nette/application](https://github.com/nette/application)
- [nette/di](https://github.com/nette/di)
- [nette/caching](https://github.com/nette/caching)

## How to use

- Implement `\Nepttune\TI\ISitemap` interface and use `\Nepttune\TI\TSitemap` trait in selected presenters (Those which should have links in sitemap.).
- Add annotation `@sitemap` to selected actions.
- Register `\Nepttune\Component\ISitemapFactory` as service in cofiguration file.
- Inject it into eg. SitemapPresenter, write `createComponent` method and use macro `{control}` in template file.
  - Just as any other component.
  - Content type is automaticaly set to `application/xml`.

### Example configuration

```
services:
    - Nepttune\Component\ISitemapFactory
```
You can optionaly provide configuration array and enable hreflang links to be included for each entry (Requires translator in presenter).
```
parameters:
    sitemap:
        hreflang: true
        
services:
    sitemapFactory:
            implement: Nepttune\Component\ISitemapFactory
            arguments:
                - '%sitemap%'
```

### Example presenter

```
class ExamplePresenter implements IPresenter, ISitemap
{
    use TSitemap;

    /** @var  \Nepttune\Component\ISitemapFactory */
    protected $iSitemapFactory;
    
    public function __construct(\Nepttune\Component\ISitemapFactory $ISitemapFactory)
    {
        $this->iSitemapFactory = $ISitemapFactory;
    }
    
    public function actionSitemap()
    {
        $this->getHttpResponse()->setContentType('application/xml');
    }
    
    /**
     * @sitemap
     */
    public function actionExample()
    {
    }

    protected function createComponentSitemap()
    {
        return $this->iSitemapFactory->create();
    }
}
```
