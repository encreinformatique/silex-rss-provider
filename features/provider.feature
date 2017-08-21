Feature: Service works expected
  In order to generate a valid sitemap
  I need to be able to create some entries

  Scenario:
    Given Service with charset "utf-8" and version "1.0" is available
    And No entry was set
    Then It should pass with:
    """
    <?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>
    """
