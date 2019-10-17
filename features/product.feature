Feature:
  Manage Products

  Scenario: Create a product
    When I add "Content-Type" header equal to "application/ld+json"
    And I add "Accept" header equal to "application/ld+json"
    And I send a "POST" request to "api/products"
    """
    {
      "name": "Dormouse.123",
      "description": "123Alice looked round, eager to see what was going to happen next. First, she tried another question.",
      "price": 123,
      "owner": "/api/users/3",
      "shortDescription": "123Alice looked round, eager to see what wa...",
      "createdAgo": "3 months ago"
     }
    """
    Then  the response status code should be 201