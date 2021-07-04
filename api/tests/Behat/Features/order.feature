Feature: Order Feature

  Scenario: Get a given order
    When I request to "GET" "/orders/{order1}"
    Then The response status code should be 200
    And The "content-type" header response should exist
    And The "content-type" header response should be "application/ld+json; charset=utf-8"


  Scenario: Trying to get an order with invalid id
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
    Given I log in
    When I request to "GET" "/orders/XXX"
    Then The response status code should be 404

  Scenario: Create an Order
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }
        """
    Given I log in
    When I set payload
        """
        {
          "customer": {user1},
          "status": "string",
          "amount": 10,
          "paymentMethod": "string",
          "itemsPrice": 500,
          "shippingPrice": 30,
          "taxPrice": 5,
          "totalPrice": 1000,
          "isPaid": false,
          "paitAt": "2021-07-04T18:25:47.443Z",
          "isDelivered": false,
          "deliveredAt": "2021-07-04T18:25:47.443Z",
          "paymentResult": 5
        }
        """
    When I request to "POST" "/orders"
    Then the response status code should be 201

  Scenario: Delete an order by admin
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
    Given I log in
    When I request to "DELETE" "/orders/{order1}"
    Then The response status code should be 204

  Scenario: Trying to delete an orders without being logged
    When I request to "DELETE" "/orders/{order3}"
    Then The response status code should be 401

  Scenario: Updating an Order
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }
        """
    Given I log in
    When I set payload
        """
        {
          "itemsPrice": 1500,
        }
        """
    When I request to "PUT" "/orders/{order6}"
    Then the response status code should be 200
