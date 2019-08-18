Feature:
  Manage Products

  Scenario: Create a product
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "api/products"
    """
    {
      "name": "new",
      "description": "new",
      "price": 1000,
      "createdAt": "2019-08-18T13:32:12.219Z",
      "isPublished": true
     }
    """
    Then  the response status code should be 201