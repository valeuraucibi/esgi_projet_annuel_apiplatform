Feature: Product Feature

    Scenario: Get a given product
      When I request to "GET" "/products/{product2}"
      Then The response status code should be 200
      And The "content-type" header response should exist
      And The "content-type" header response should be "application/ld+json; charset=utf-8"

    Scenario: Get Comments for a given product
      When I request to "GET" "/products/{product3}/comments"
      Then The response status code should be 200
      And The "content-type" header response should exist
      And The "content-type" header response should be "application/ld+json; charset=utf-8"

    Scenario: Trying to get a product with invalid id
      Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
      Given I log in
      When I request to "GET" "/products/XXX"
      Then The response status code should be 404

    Scenario: Create a Product
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
          "price": 100,
          "reference": "string",
          "description": "string",
          "countInStock":10,
          "category": "{category3}",
          "userId": {userSeller1},
        }
        """
        When I request to "POST" "/products"
        Then the response status code should be 201

    Scenario: Delete a product by admin
      Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
      Given I log in
      When I request to "DELETE" "/products/{product1}"
      Then The response status code should be 204

    Scenario: Trying to delete a product without being logged
      When I request to "DELETE" "/products/{product1}"
      Then The response status code should be 401

    Scenario: Creating a Product with invalid name
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
          "name": "a",
          "price": 100,
          "reference": "string",
          "description": "string",
          "countInStock":10,
          "category": "{category3}",
          "userId": {userSeller1},
        }
        """
      When I request to "POST" "/products"
      Then the response status code should be 400

    Scenario: Updating a Product
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
          "name": "newName"
        }
        """
      When I request to "PUT" "/products/{product4}"
      Then the response status code should be 200
