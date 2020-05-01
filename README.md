# Sitemap
:wrench: Sitemap generator component

## Introduction

This componenet automaticaly generates sitemap from annotated presenter actions. Found actions are cached to improve performance.

## Installation

Install package using composer

```
composer require nepttune/sitemap
```

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
