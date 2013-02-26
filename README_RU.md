Fad Yii Cms (dev)
===================

Легкая CMS на базе Yii (1.1.12) с основными модулями и расширениями для старта. При написании кода используется стиль PSR-1/PSR-2.

Вместо дампа базы данных используются [миграции](http://www.yiiframework.com/doc/guide/1.1/ru/database.migration),
расширенные [дополнением](https://github.com/yiiext/migrate-command) с поддержкой модулей.

ПОДДЕРЖКА БАЗ ДАННЫХ
------------
CMS работает с MySQL, PostgreSQL и SQLite, другие типы БД пока не тестировались (скоро будут).

УСТАНОВКА
------------

1. [Загрузите](https://github.com/magefad/yiicms/archive/master.zip) последнюю версию Yii Fad CMS и распакуйте на сервер.
2. [Загрузите](http://yii.googlecode.com/files/yii-1.1.13.e9e4a0.tar.gz) последнюю версию Yii Framework и распакуйте.
3. Откройте для изменения index.php из CMS и укажите пути до Yii Framework ($yii переменная)
   * Так как CMS использует конфигурации разработчика (dev.php) и боевого (естественно поверх конфигурации main.php) режима,
   можно указать различные пути $yii development (например на denwer) и production (рабочий сайт).
4. Откройте Yii CMS по вашему адресу. Например http://localhost/cms/ и следуйте инструкциям установщика!


КОНФИГУРАЦИЯ
------------

/protected/config

      console.php       параметры для yiic (консоль)
      db.php            возвращает параметры подключения к базе данных (создается после установки)
      dev.php           параметры для разработки
      main.php          основные параметры - все остальные идут поверх него (mergeArray)
      modules.php       возвращает список модулей (перед установкой указан единственный модуль install, после установки будут вставлены выбранные)
      production.php    конфигурация для продакшн-сервера
      urlRules.php      дополнительные правила для CUrlManager

ПОВЕДЕНИЯ
------------

/protected/components/behaviors

      AdjacencyListBehavior     простое дерево - смежные вершины (parent_id, level, sort_order (SortableBehavior))
      InlineWidgetsBehavior     встраивание виджетов в текст страницы
      NestedSetBehavior         вложенные множества (из yiiext)
      SaveBehavior              create_user_id, update_user_id, create_time, update_time
      SortableBehavior          sort_order
      StatusBehavior            статус

МОДУЛИ
------------

/protected/modules/

      admin/            главная админки — список и настройки модулей, версия Yii, PHP
      auth/             RBAC права доступа (yii-auth)
      blog/             блог
      comment/          поведение комментариев
      contact/          обратная связь (поддержка отправки через SMTP)
      gallery/          галерея (galleria frontend)
      install/          установщик
      menu/             меню
      news/             новости
      page/             страницы
      sitemap/          карта сайта (древовидный sitemap/, sitemap.xml)
      social/           социальные сети (vk, facebook)
      user/             пользователи (включает eauth, eoauth, lightopenid)

РАСШИРЕНИЯ
------------

/protected/extensions/

      aceEditor/        редактор кода (виджет)
      addThis/          социальные кнопки addThis (виджет)
      bootstrap/        yiiBooster
      elFinder/         файловый менеджер для tinyMce
      galleria/         galleria
      grid/             Nested Set GridView
      image/            Kohana Image Library
      jui/              DateTimePicker с выборкой времени
      mail/             SwiftMailer
      migrate-command/  Расширенные миграции с поддержкой модулей
      syncTranslit/     поведение и виджет для транслита значений ActiveRecord
      tinymce/          WYSIWYG редактор

/protected/modules/

      blog/extensions/taggable/     taggable Behavior
      gallery/widgets/photoManager  фотоменеджер
      news/widgets/LastNews         блок последних новостей
      user/extensions/eauth/        Yii EAuth extension

ДОПОЛНИТЕЛЬНО
------------
      /robots.txt                           Основные правила для поисковых роботов
      /protected/autocomplete.php           Автодополнение кода в IDE
      /protected/components/CommandExecutor Компонент для вызова консольных команд (например migrate)
      /protected/components/Controller      Расширенный RController
      /protected/components/FadTbGridView   Расширенный TbGridView
      /protected/components/WebModule       Расширенный CWebModule
      /protected/components/Widget          Расширенный CWidget

ПОЛЕЗНЫЕ ССЫЛКИ
------------

### Расширения fad yii cms

* [aceEditor](http://ace.ajax.org/)
* [addThis](http://www.addthis.com/)
* [grid](http://ludo.cubicphuse.nl/jquery-plugins/treeTable/doc/)
* [jui](http://trentrichardson.com/examples/timepicker/)
* [syncTranslit](http://snowcore.net/synctranslit)

### Сторонние расширения

* [YiiBooster](http://yii-booster.clevertech.biz/)
* [Yii-Auth](http://www.yiiframework.com/extension/auth/)
* [TinyMce](http://www.yiiframework.com/extension/newtinymce/)
* [elFinder](http://elfinder.org/)
* [Galleria](http://www.yiiframework.com/extension/galleria/)
* [Kohana Image Library](http://www.yiiframework.com/extension/image/)
* [Yii EAuth extension](https://github.com/Nodge/yii-eauth)
* [loid extension](http://www.yiiframework.com/extension/loid)
* [EOAuth extension](http://www.yiiframework.com/extension/eoauth)

### Ресурсы

* [Tiwtter Bootstrap](http://twitter.github.com/bootstrap/)
* [RBAC](http://en.wikipedia.org/wiki/Role-based_access_control)
* [PSR-1/PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/)

ПЛАНЫ
------------

* **создание сайта и сообщества**
* Переход на sourceLanguage = en (~15%)
* создание нечто блоков контента (подобно ModX)
* ~~создание шаблонов для управления правами пользователей (Rights ext) под CMS~~ теперь yii-auth на bootstrap
* ~~установщик~~
* возможность изменять страницу прямо на сайте (подобно Google Sites)
* ~~поддержка SQLite~~
* поддержка MSSQL
* поддержка PostgreSQL
* поддержка Oracle

Буду рад любой помощи в улучшении проекта, и, конечно же, пулл реквестам.
