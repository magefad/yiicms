Fad Yii Cms (dev)
===================

Easy CMS based on Yii (1.1.12) with the basic modules and extensions to start. Code style is PSR-1/PSR-2.

MODULES
------------

/protected/modules/

      admin/            admin main — list and settings modules, version of Yii and PHP
      blog/             blog
      comment/          comments behavior
      contact/          feedback (support for sending via SMTP)
      gallery/          gallery (galleria frontend)
      menu/             menu
      news/             news
      page/             pages
      rights/           rbac users (yii-rights)
      sitemap/          sitemap (tree-like sitemap/, sitemap.xml)
      social/           social networks  (vk, facebook)
      user/             users (include eauth, eoauth, lightopenid)

EXTENSIONS
------------

/protected/extensions/

      aceEditor/        code editor (widget)
      addThis/          social buttons from addThis (widget)
      bootstrap/        yiiBooster
      elFinder/         file manager for tinyMce
      galleria/         galleria
      grid/             Nested Set GridView
      image/            Kohana Image Library
      jui/              DateTimePicker with timepicker
      mail/             SwiftMailer
      syncTranslit      behavior and widget for translit values (ActiveRecord)
      tinymce           WYSIWYG editor

/protected/modules/

      blog/extensions/taggable/     taggable Behavior
      gallery/widgets/photoManager  photo manager
      news/widgets/LastNews         latest news
      user/extensions/eauth/        Yii EAuth extension

LINKS
------------

### Extensions of fad yii cms

* [aceEditor](http://ace.ajax.org/)
* [addThis](http://www.addthis.com/)
* [grid](http://ludo.cubicphuse.nl/jquery-plugins/treeTable/doc/)
* [jui](http://trentrichardson.com/examples/timepicker/)
* [syncTranslit](http://snowcore.net/synctranslit)

### Party extensions

* [YiiBooster](http://yii-booster.clevertech.biz/)
* [Yii-rights](http://www.yiiframework.com/extension/rights/)
* [TinyMce](http://www.yiiframework.com/extension/newtinymce/)
* [elFinder](http://elfinder.org/)
* [Galleria](http://www.yiiframework.com/extension/galleria/)
* [Kohana Image Library](http://www.yiiframework.com/extension/image/)
* [Yii EAuth extension](https://github.com/Nodge/yii-eauth))
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)

### Resources

* [Tiwtter Bootstrap](http://twitter.github.com/bootstrap/)
* [RBAC](http://en.wikipedia.org/wiki/Role-based_access_control)
* [PSR-1/PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/)

WHAT's NEXT
------------

* **create website and community**
* switch to sourceLanguage = en (~15%)
* creating something blocks of content (like ModX)
* creation of templates to manage user (Rights ext) under CMS
* installator
* possibility to edit the page directly on the site (like Google Sites)

I will appreciate any help in improving the project, and, of course, pull request's.
