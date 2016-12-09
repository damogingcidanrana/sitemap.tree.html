# sitemap.tree.html

Компонент для Bitrix CMS

Автоматическая генерация карты сайта с разбитием по разделам и подразделам неограниченной вложенности.

#### Пример результата работы компонента:
 - Раздел_1
   - Подраздел_1
     - Третий уровень
       - и т.д...
   - Подраздел_2
 - Раздел_2
   - Подраздел_3
     - Третий уровень
 - Раздел_3

#### Подключение:
Поместить папку `sitemap.tree.html` в `/bitrix/components/custom_components/`

В index.php:
```php
$APPLICATION->IncludeComponent(
  "custom_components:sitemap.tree.html", 
  ".default", 
  array(
    "COMPONENT_TEMPLATE" => ".default",
    "IBLOCKS" => array(
      0 => array(
                "ID" => "4",
                "SECTIONS" => "N",
                "ELEMENTS" => "Y"
            ),
            1 => array(
                "ID" => "5",
                "SECTIONS" => "Y",
                "ELEMENTS" => "Y"
           )
        ),
    "EXCLUDED_FOLDERS" => array(
      0 => "bitrix",
      1 => "upload",
      2 => "search",
      3 => "cgi-bin",
      4 => "images"
    )
  )
);
```
Параметр `IBLOCKS` представляет из себя список инфоблоков, включаемых в карту сайта, где `ID` - ID инфоблока, `SECTIONS` - нужно ли включать директории данного инфоблока в карту сайта, `ELEMENTS` - нужно ли включать элементы данного инфоблока в карту сайта.

Параметр `EXCLUDED_FOLDERS` - список папок исключаемых из карты сайта.

>Визуальное редактирование параметров компонента не доработано на данный момент, прописывать только вручную.
