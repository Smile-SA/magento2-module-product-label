# Changelog

All notable changes to this project will be documented in this file.

## [1.3.0] - Unreleased
[1.3.0]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.6...1.3.0

- Supported platforms: Magento 2.4.6 and later, Mage-OS 1.0.0 and later (tested up to Magento 2.4.9 and Mage-OS 4.0), PHP 8.1 to 8.5
- `composer.json` now states it: `php ^8.1` and `magento/framework >=103.0.6` (previously `php ^7.4 || ^8.1` and `magento/framework >=103.0.0`)
- Magento 2.4.4 and 2.4.5 are supported by the 1.2.x line, from 1.2.7
- CI: static analysis and `setup:di:compile` run on Mage-OS, without Magento credentials

## [1.2.5] - 2023-02-15
[1.2.5]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.4...1.2.5

- Fix loading data product labels on admin grid

## [1.2.4] - 2023-02-15
[1.2.4]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.3...1.2.4

- Fix typing in ProductLabel block

## [1.2.3] - 2023-02-02
[1.2.3]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.2...1.2.3

- Allow smile directory to fix upload from media gallery

## [1.2.2] - 2022-11-21
[1.2.2]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.1...1.2.2

- Add github actions workflow

## [1.2.1] - 2022-11-15
[1.2.1]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.2.0...1.2.1

- Update to fix gallery image uploader

## [1.2.0] - 2022-11-08
[1.2.0]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.1.2...1.2.0

- Add Smile Lab Quality Suite
- Analyse code style with phpcs / phpmd / phpstan command

**Compatibility :**
- Magento Open Source : >= 2.4.4
- Adobe Commerce : >= 2.4.4
  We do not guarantee the compatibility with prior versions.

## [1.1.2] - 2021-08-31
[1.1.2]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.1.1...1.1.2

- [issue-34] - Update composer dependencies (Merge pull request #35 from chernoux/master)

## [1.1.1] - 2020-06-21
[1.1.1]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.1.0...1.1.1

- Unicity of product labels across store views.

## [1.1.0] - 2019-06-11
[1.1.0]: https://github.com/Smile-SA/magento2-module-product-label/compare/1.0.0...1.1.0

- Add scope by storeview

## 1.0.0 - 2019-04-19

- Initial Release
