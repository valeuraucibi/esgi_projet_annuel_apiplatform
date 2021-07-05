
# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html

Feature: Category Feature
    Scenario: Get list of categories
        Given I request to "GET" "/categories"
        Then The response status code should be 200
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"

    Scenario: Get list of category
        Given I request to "GET" "/categories/XXX"
        Then The response status code should be 404

    ########################################## ADMIN USER #################################

    Scenario: Post new category
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
         "name": "My category"
        }
        """
        When I request to "POST" "/categories"
        Then The response status code should be 201


    Scenario: Delete a category for admin users
        Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
        Given I log in
        When I request to "DELETE" "/categories/{category4}"
        Then The response status code should be 204

    ################### NORMAL USERS #################################


    Scenario: Post of category for normal users
        Given I set payload
        """
        {
          "email": "user.test@gmail.com",
          "password": "test"
        }
        """
        Given I log in
        When I set payload
        """
        {
         "name": "PS5"
        }
        """
        When I request to "POST" "/categories"
        Then The response status code should be 403


    Scenario: Modification of comments for normal users
        Given I set payload
        """
        {
          "email": "user.test@gmail.com",
          "password": "test"
        }
        """
        Given I log in
        When I set payload
        """
        {
         "name": "télé"
        }
        """
        When I request to "PUT" "/categories/{category3}"
        Then The response status code should be 403

    Scenario: Delete of category for normal users
        Given I set payload
        """
       {
          "email": "user.test@gmail.com",
          "password": "test"
        }
        """
        Given I log in
        When I request to "DELETE" "/categories/{category1}"
        Then The response status code should be 403



     ############################## USER SELLER #####################################################


    Scenario: Post of category for seller users
        Given I set payload
        """
        {
          "email": "user.seller@gmail.com",
          "password": "password"
        }
        """
        Given I log in
        When I set payload
        """
        {
          "name": "jeux"
        }
        """
        When I request to "POST" "/categories"
        Then The response status code should be 403


    Scenario: Modification of category for seller users
        Given I set payload
        """
        {
          "email": "user.seller@gmail.com",
          "password": "password"
        }
        """
        Given I log in
        When I set payload
        """
        {
          "name": "logiciels"
        }
        """
        When I request to "PUT" "/categories/{category3}"
        Then The response status code should be 403

    Scenario: Delete of category for seller users
        Given I set payload
        """
        {
          "email": "user.seller@gmail.com",
          "password": "password"
        }
        """
        Given I log in
        When I request to "DELETE" "/categories/{category1}"
        Then The response status code should be 403


    ####################### USER NOT LOGGED IN ######################################################


    Scenario: Trying to posting a category without being logged
    When I set payload
        """
        {
          "name": "enceintes"
        }
        """
    When I request to "POST" "/categories/{category2}"
    Then The response status code should be 405

    Scenario: Trying to modify a category without being logged
    When I set payload
        """
        {
          "name": "XBOX"
        }
        """
    When I request to "PUT" "/categories/{category2}"
    Then The response status code should be 401


    Scenario: Trying to delete a category without being logged
    When I set payload
        """
        {
          "name": "tours"
        }
        """
    When I request to "DELETE" "/categories/{category2}"
    Then The response status code should be 401

  ###################### ASSERT #######################

  Scenario: Post categories < 2 char
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
         "name": "My"
        }
        """
        When I request to "POST" "/categories/{category2}"
        Then The response status code should be 405

    Scenario: PUT category name
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
         "name": "ne"
        }
        """
        When I request to "PUT" "/categories/{category10}"
        Then The response status code should be 400
