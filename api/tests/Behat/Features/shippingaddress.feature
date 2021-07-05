Feature: ShippingAddress Feature

    Scenario: Get a given shippingAddress
        When I request to "GET" "/shipping_addresses/{shippingAddress1}"
        Then The response status code should be 200
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"


    Scenario: Trying to get a ShippingAddress with invalid id
        Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
        Given I log in
        When I request to "GET" "/shipping_addresses/XXX"
        Then The response status code should be 404

    Scenario: Create a ShippingAddress
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
          "fullName": "string",
          "address": "string",
          "city": "string",
          "postalCode": "string",
          "country": "string",
          "theOrder": {order1},
          "lat": 5,
          "lng": 5
        }
        """
        When I request to "POST" "/shipping_addresses"
        Then the response status code should be 201

    Scenario: Delete a ShippingAddress by admin
        Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
        Given I log in
        When I request to "DELETE" "/shipping_addresses/{shippingAddress2}"
        Then The response status code should be 204

    Scenario: Trying to delete a ShippingAddress without being logged
        When I request to "DELETE" "/shipping_addresses/{shippingAddress3}"
        Then The response status code should be 401

    Scenario: Updating a ShippingAddress
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
          "fullName": "stringUpdated"
        }
        """
        When I request to "PUT" "/shipping_addresses/{shippingAddress5}"
        Then the response status code should be 200
