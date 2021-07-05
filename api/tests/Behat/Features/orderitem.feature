Feature: OrderItem Feature

  Scenario: Get a given orderItem
    When I request to "GET" "/order_items/{orderItem1}"
    Then The response status code should be 200
    And The "content-type" header response should exist
    And The "content-type" header response should be "application/ld+json; charset=utf-8"


  Scenario: Trying to get an orderItem with invalid id
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
    Given I log in
    When I request to "GET" "/order_items/XXX"
    Then The response status code should be 404

  Scenario: Create an OrderItem
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
          "name": "string",
          "qty": 5,
          "price": 10,
          "product": {product1},
          "theOrder": {order2}
        }
        """
    When I request to "POST" "/order_items"
    Then the response status code should be 201

  Scenario: Delete an orderItem by admin
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
    Given I log in
    When I request to "DELETE" "/order_items/{orderItem2}"
    Then The response status code should be 204

  Scenario: Trying to delete an orderItems without being logged
    When I request to "DELETE" "/order_items/{orderItem3}"
    Then The response status code should be 401

  Scenario: Updating an OrderItem
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
          "qty": 25,
          "price": 300,
        }
        """
    When I request to "PUT" "/order_items/{orderItem4}"
    Then the response status code should be 200
