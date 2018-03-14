# Magento 2 versions available API (JSON,XML)

In Magento 1, we can get list of available versions at `http://connect20.magentocommerce.com/community/Mage_All_Latest/releases.xml`. Magento 2 edition, there is nothing similar. However, there are Magento 2 releases on Github, but it's complex, includes prereleases / preview release, that why we create this simple tool to filter and format the JSON / XML file that may help Magento 2 development community.

## Purpose

Helps Magento community get Magento 2 latest version number and list all version number also.

## How to use

### All releases (JSON)

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/releases/releases.json

Json response: 

```json
{
    "2.2.3": {
        "v": "2.2.3",
        "s": "stable",
        "d": "2018-02-27"
    },
    "2.2.2": {
        "v": "2.2.2",
        "s": "stable",
        "d": "2017-12-12"
    },
    "2.2.1": {
        "v": "2.2.1",
        "s": "stable",
        "d": "2017-11-07"
    }
}
```

### All releases (XML)

File Source: https://raw.githubusercontent.com/mageplaza/magento-versions/master/releases/releases.xml

```xml
<?xml version="1.0" encoding="UTF-8"?>
<releases>
   <r>
      <v>2.2.3</v>
      <s>stable</s>
      <d>2018-02-27</d>
   </r>
   <r>
      <v>2.2.2</v>
      <s>stable</s>
      <d>2017-12-12</d>
   </r>
</releases>
```
### Latest release

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/releases/latest.txt

```
2.2.3
```

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/releases/latest.json

```json
{
    "v": "2.2.3",
    "s": "stable",
    "d": "2018-02-27"
}
```


## Update frequently

We update new releases from `https://github.com/magento/magento2` **daily**.

## Contribute

You are welcome to contribute this project. Just create a pull request :)
