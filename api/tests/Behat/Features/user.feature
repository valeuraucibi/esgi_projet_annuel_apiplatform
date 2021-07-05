# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature: User Feature
  Scenario: Get list of users
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }
        """
    Given I log in
    When I request to "GET" "/users"
    Then The response status code should be 200
    And The "content-type" header response should exist
    And The "content-type" header response should be "application/ld+json; charset=utf-8"

  Scenario: Get list of users
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }
        """
    Given I log in
    When I request to "GET" "/users/XXX"
    Then The response status code should be 404

  Scenario: Post new user admin
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
         "email": "ld1@gmail.com",
         "roles": [
          "ROLE_ADMIN"
          ],
         "password": "password",
         "firstName": "Lassana",
         "lastName": "DIAKITE"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 201


  Scenario: Post new user Seller
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
         "email": "Seller@gmail.com",
         "roles": [
          "ROLE_SELLER"
          ],
         "password": "password",
         "firstName": "Lassana",
         "lastName": "Vendeur"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 201

  Scenario: PUT new user Seller
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
         "firstName": "Yannick",
         "lastName": "Vendeur"
        }
        """
    When I request to "PUT" "/users/{userSellerUnique}"
    Then The response status code should be 200

  Scenario: Post new user
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
         "email": "lassuser@gmail.com",
         "roles": [
          "ROLE_USER"
          ],
         "password": "password",
         "firstName": "Lassana",
         "lastName": "user"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 201

  Scenario: PUT new user
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
         "firstName": "Paul",
         "lastName": "utilisateur"
        }
        """
    When I request to "PUT" "/users/{userUnique}"
    Then The response status code should be 200

  #################### Delete user ###########################

  Scenario: Delete a user Seller by admin users
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
    Given I log in
    When I request to "DELETE" "/users/{userSellerUnique}"
    Then The response status code should be 204

  Scenario: Delete a user by admin users
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
    Given I log in
    When I request to "DELETE" "/users/{userUnique}"
    Then The response status code should be 204

  Scenario: Delete a user Admin by admin users
    Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
    Given I log in
    When I request to "DELETE" "/users/{admin}"
    Then The response status code should be 204


  ################ test Assert #################################

  Scenario: Post new user Seller firstName < 2 char
    Given I set payload
         """
        {
         "email": "Seller1@gmail.com",
         "roles": [
          "ROLE_SELLER"
          ],
         "password": "password",
         "firstName": "li",
         "lastName": "Vendeur"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 400

  Scenario: Post new user password blank
    Given I set payload
         """
        {
         "email": "user2@gmail.com",
         "password": "",
         "firstName": "li",
         "lastName": "Vendeur"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 400

  Scenario: Post new user same email
    Given I set payload
         """
        {
         "email": "user2@gmail.com",
         "password": "",
         "firstName": "julien",
         "lastName": "user"
        }
        """
    When I request to "POST" "/users"
    Then The response status code should be 400
