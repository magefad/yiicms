Fad Yii Cms (dev)
===================

Easy CMS based on Yii (1.1.12) with the basic modules and extensions to start. Code style is PSR-1/PSR-2.

CONFIGURATION
------------

/protected/config

      console.php       options yiic (консоль)
      db.php            options for database connection (used in production.php)
      dev.php           options for development
      main.php          general options - all options merged width this (mergeArray)
      production.php    options for production
      urlRules.php      additional rules for CUrlManager

BEHAVIORS
------------

/protected/components/behaviors

      AdjacencyListBehavior     parent_id, level, sort_order (SortableBehavior)
      InlineWidgetsBehavior     embed widgets to the page
      NestedSetBehavior         nested set behavior for AR models (from yiiext)
      SaveBehavior              auto create_user_id, update_user_id, create_time, update_time
      SortableBehavior          sort_order
      StatusBehavior            statusable behavior

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
      jui/              DateTimePicker with time picker
      mail/             SwiftMailer
      syncTranslit      behavior and widget for translit values (ActiveRecord)
      tinymce           WYSIWYG editor

/protected/modules/

      blog/extensions/taggable/     taggable Behavior
      gallery/widgets/photoManager  photo manager
      news/widgets/LastNews         latest news
      user/extensions/eauth/        Yii EAuth extension

ДОПОЛНИТЕЛЬНО
------------
      /robots.txt                           General rules for search engines
      /protected/autocomplete.php           Auto complete for IDE
      /protected/components/Controller      extended RController
      /protected/components/FadTbGridView   extended TbGridView
      /protected/components/WebModule       extended CWebModule
      /protected/components/Widget          extended CWidget

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

I will appreciate any help in improving the project, and, of course, pull requests.
