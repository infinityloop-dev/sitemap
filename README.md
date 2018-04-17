# Sitemap
:wrench: Sitemap generator component

## Introduction

This componenet automaticaly generates sitemap from annotated presenter actions. Found actions are cached to improve performance.

## Dependencies

- [nepttune/base-requirements](https://github.com/nepttune/base-requirements)
- [nepttune/base-components](https://github.com/nepttune/base-components)

## How to use

- Register `\Nepttune\Component\ISitemapFactory` as service in cofiguration file, inject it into presenter, write `createComponent` method and use macro `{control}` in template file.
  - Just as any other component.
  - You might also want to change mime type to `application/xml`.
- Implement `\Nepttune\TI\ISitemap` interface and use `\Nepttune\TI\TSitemap` trait in selected presenters (Those which should have links in sitemap.).
- Add annotation `@sitemap` to selected actions.

### Example configuration

```
services:
    - Nepttune\Component\ISitemapFactory
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
        $this->iRobotsFactory = $ISitemapFactory;
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
