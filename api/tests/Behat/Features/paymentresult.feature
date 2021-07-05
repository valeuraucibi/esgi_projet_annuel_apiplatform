Feature: PaymentResult Feature

    Scenario: Get a given paymentResult
        When I request to "GET" "/payment_results/{paymentResult1}"
        Then The response status code should be 200
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"


    Scenario: Trying to get a PaymentResult with invalid id
        Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
        Given I log in
        When I request to "GET" "/payment_results/XXX"
        Then The response status code should be 404

    Scenario: Create a PaymentResult
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
          "status": "string",
          "emailAddress": "email@hotmail.com",
          "orders": {order1},
        }
        """
        When I request to "POST" "/payment_results"
        Then the response status code should be 201

    Scenario: Delete a PaymentResult by admin
        Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
        Given I log in
        When I request to "DELETE" "/payment_results/{paymentResult2}"
        Then The response status code should be 204

    Scenario: Trying to delete a PaymentResult without being logged
        When I request to "DELETE" "/payment_results/{paymentResult3}"
        Then The response status code should be 401

    Scenario: Updating a PaymentResult
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
          "status": "stringUpdated"
        }
        """
        When I request to "PUT" "/payment_results/{paymentResult5}"
        Then the response status code should be 200
