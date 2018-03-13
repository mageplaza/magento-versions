# Magento 2 versions available API (JSON,XML)

In Magento 1, we can get list of available versions at `http://connect20.magentocommerce.com/community/Mage_All_Latest/releases.xml`. Magento 2 edition, there is nothing similar. However, there are Magento 2 releases on Github, but it's complex, includes prereleases / preview release, that why we create this simple tool to filter and format the JSON / XML file that may help Magento 2 development community.

## Purpose

Helps Magento community get Magento 2 latest version number and list all version number also.

## How to use

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/versions/versions.json

Json response: 

```
{
    "2.2": [
        {
            "v": "2.2.3",
            "s": "stable",
            "d": "2018-02-27"
        },
        {
            "v": "2.2.0",
            "s": "stable",
            "d": "2017-09-26"
        }
    ],
    "2.1": [
        {
            "v": "2.1.12",
            "s": "stable",
            "d": "2018-02-27"
        },
        {
            "v": "2.1.5",
            "s": "stable",
            "d": "2017-02-21"
        }
    ],

}
```

### Latest version

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/versions/latest.txt

File: https://raw.githubusercontent.com/mageplaza/magento-versions/master/versions/latest.json

Example: 

```
2.2.3
```