Feature: BookMark Feature

  Scenario: Get a given bookMark
    When I request to "GET" "/bookmarks/{bookmark1}"
    Then The response status code should be 200
    And The "content-type" header response should exist
    And The "content-type" header response should be "application/ld+json; charset=utf-8"


  Scenario: Trying to get a bookmark with invalid id
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }

          """
    Given I log in
    When I request to "GET" "/bookmarks/XXX"
    Then The response status code should be 404

  Scenario: Create a BookMark
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
          "product": {product1},
          "userId": {user1}
        }
        """
    When I request to "POST" "/bookmarks"
    Then the response status code should be 201

  Scenario: Delete a bookmark by admin
    Given I set payload
          """
          {
            "email": "admin@admin.com",
            "password": "admin"
          }
          """
    Given I log in
    When I request to "DELETE" "/bookmarks/{bookmark2}"
    Then The response status code should be 204

  Scenario: Trying to delete a bookmark without being logged
    When I request to "DELETE" "/bookmarks/{bookmark3}"
    Then The response status code should be 401

  Scenario: Updating a BookMark
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
          "product": {product4}
        }
        """
    When I request to "PUT" "/bookmarks/{bookmark4}"
    Then the response status code should be 200
