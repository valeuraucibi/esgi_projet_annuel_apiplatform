Feature: Message Feature

  Scenario: Get a given message
    When I request to "GET" "/messages/{message1}"
    Then The response status code should be 200
    And The "content-type" header response should exist
    And The "content-type" header response should be "application/ld+json; charset=utf-8"


  Scenario: Trying to get a message with invalid id
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
    Given I log in
    When I request to "GET" "/messages/XXX"
    Then The response status code should be 404

  Scenario: Create a Message
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
          "author": {user1},
          "subject": "string",
          "content": "string",
          "status": "string"
        }
        """
    When I request to "POST" "/messages"
    Then the response status code should be 201

  Scenario: Delete a messages by admin
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
    Given I log in
    When I request to "DELETE" "/messages/{message1}"
    Then The response status code should be 204

  Scenario: Trying to delete a message without being logged
    When I request to "DELETE" "/messages/{messages3}"
    Then The response status code should be 401

  Scenario: Updating a Message
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
          "subject": "stringUpdated",
          "content": "stringUpdated",
        }
        """
    When I request to "PUT" "/messages/{message6}"
    Then the response status code should be 200
