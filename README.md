# Resultify backend login news

## What does it do?

Extension extend default TYPO3 login controller in order to show Resultify news on Backend login page, under form.

It's importing news items from [https://www.resultify.se/typo3-feed.rss](https://www.resultify.se/typo3-feed.rss)

## How to setup?

- Install extension
- Create scheduler task to import news items **Import Resultify news (pxa_resultify_belogin_news)**
- Select language in **Extension manager settings or Settings module in TYPO3 9.x**

## News language

Right now extension is importing Swedish and Norwegian news items from Resultify site.

Using **Extension manager settings or Settings module in TYPO3 9.x** it's possible to choose what language layer to show.

