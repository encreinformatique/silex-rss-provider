Feature: Service works expected
  In order to generate a valid sitemap
  I need to be able to create some entries

  Scenario:
    Given Service with charset "utf-8" and version "1.0" is available
    And No entry was set
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"><channel/></rss>
    """

  Scenario:
    Given Service with charset "ISO-8859-1" and version "2.0" is available
    And No entry was set
    Then It should pass with:
    """
    <?xml version="2.0" encoding="ISO-8859-1"?>
    <rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"><channel/></rss>
    """

  Scenario:
    Given Service with charset "utf-8" and version "1.0" is available
    When I add an entry "https://github.com/encreinformatique/silex-rss-provider" with title "my title" and date "2017-08-21 14:59"
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"><channel><item><title>my title</title><link>https://github.com/encreinformatique/silex-rss-provider</link><guid>https://github.com/encreinformatique/silex-rss-provider</guid><pubDate>Mon, 21 Aug 17 14:59:00 +0200</pubDate></item></channel></rss>
    """

  Scenario:
    Given Service with charset "utf-8" and version "1.0" is available
    When I add an entry "https://github.com/encreinformatique/silex-rss-provider" with title "my title" and date "2017-08-21 14:59"
    And I add an entry "https://github.com/encreinformatique/silex-pagination" with title "Silex pagination" and date "2017-08-20 11:12"
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"><channel><item><title>my title</title><link>https://github.com/encreinformatique/silex-rss-provider</link><guid>https://github.com/encreinformatique/silex-rss-provider</guid><pubDate>Mon, 21 Aug 17 14:59:00 +0200</pubDate></item><item><title>Silex pagination</title><link>https://github.com/encreinformatique/silex-pagination</link><guid>https://github.com/encreinformatique/silex-pagination</guid><pubDate>Sun, 20 Aug 17 11:12:00 +0200</pubDate></item></channel></rss>
    """
