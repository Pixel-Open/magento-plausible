# Magento Plausible

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-green)](https://php.net/)
[![Minimum Magento Version](https://img.shields.io/badge/magento-%3E%3D%202.4.4-green)](https://business.adobe.com/products/magento/magento-commerce.html)
[![GitHub release](https://img.shields.io/github/v/release/Pixel-Open/magento-plausible)](https://github.com/Pixel-Open/magento-plausible/releases)

## Presentation

Add Plausible Analytics to Magento.

- Save visited pages
- Access Analytics in Magento Admin with Plausible Shared Link
- Manage goals on specific actions (contact, register, checkout, order...)
- Allow use of your own Plausible instance
- Compatible with multiple websites
- Compatible with Magento OpenSource and Adobe Commerce

## Requirements

- Magento >= 2.4.4
- PHP >= 7.2.0

## Installation

```
composer require pixelopen/magento-plausible
```

## Configuration

*Stores > Configuration > Services > Plausible*

### Tracking

| Option       | Description                                                                  |
|--------------|------------------------------------------------------------------------------|
| Enabled      | Add tracking script on frontend and start recording visited pages.           |
| Instance URL | Plausible instance URL. Allow to use a custom domain for dedicated instance. |

**Note:** For custom domain with Magento CSP Module, remember to add your instance URL in CSP whitelist for *frame-src*, *connect-src* and *script-src*.

### Admin

| Option      | Description                                                                                             |
|-------------|---------------------------------------------------------------------------------------------------------|
| Enabled     | Display stats in the "Marketing > Plausible > Analytics" menu (refresh cache when option is updated).   |
| Shared Link | Create the shared link in your Plausible instance site settings: Visibility > Shared links > + New link |

### Goals

The module includes goal events when enabled in module configuration.

- Contact message sent
- Account registration
- Customer has logged in
- Cart view
- Checkout
- Order complete

| Option   | Description                                                                      |
|----------|----------------------------------------------------------------------------------|
| Enabled  | Allow to track actions.                                                          |
| Contact  | Plausible goal name when customer send a contact message. Leave empty to ignore. |
| Register | Plausible goal name when creating the customer account. Leave empty to ignore.   |
| Login    | Plausible goal name when customer was connected. Leave empty to ignore.          |
| Cart     | Plausible goal name when customer goes to the cart. Leave empty to ignore.       |
| Checkout | Plausible goal when customer access the checkout. Leave empty to ignore.         |
| Order    | Plausible goal name when customer submits order. Leave empty to ignore.          |

You need to add goal events in your Plausible website configuration:

![Plausible Goals](goals.png)

The Plausible goal name must be the same as the name in the module configuration.

Default goal names are:

- contact
- register
- login
- cart
- checkout
- order
