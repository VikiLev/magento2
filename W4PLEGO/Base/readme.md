W4PLEGO Base
=====================

[wiki link](https://pm.web4pro.com.ua/projects/lego-web4pro-base/wiki)

### VERSION 1.0.4

Create Config/Source array model for System configuration dropdown:
```xml
 <virtualType name="W4PLEGO\CustomModule\Model\Config\Source\LabelType" type="W4PLEGO\Base\Model\Config\Source\InputType">
     <arguments>
         <argument name="options" xsi:type="array">
             <item name="creation" xsi:type="array">
                 <item name="label" xsi:type="string" translatable="true">Label Creation</item>
                 <item name="value" xsi:type="const">\W4PLEGO\CustomModule\Helper\Config::LABEL_CREATION</item>
             </item>
             <item name="creation_zebra" xsi:type="array">
                 <item name="label" xsi:type="string" translatable="true">Label Creation Zebra</item>
                 <item name="value" xsi:type="const">\W4PLEGO\CustomModule\Helper\Config::LABEL_CREATION_ZEBRA</item>
             </item>
         </argument>
     </arguments>
 </virtualType>
```

### VERSION 1.0.8
Get current product 
```php
\W4PLEGO\Base\Service\GetCurrentProductService $currentProduct,
$product = $this->currentProduct->getProduct();
```

Get current category 
```php
\W4PLEGO\Base\Service\GetCurrentCategoryService $currentCategory,
$category = $this->currentCategory->getCategory();
```
### VERSION 1.0.9
Fix datapost to use formkey from the cookie

### VERSION 1.0.9.1
Fix datapost to use formkey from the cookie on frontend and from input field in the admin