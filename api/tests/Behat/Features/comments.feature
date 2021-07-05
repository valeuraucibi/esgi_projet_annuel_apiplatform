# This file contains a user story for demonstration only.
# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html


################### ADMIN USERS ####################################

Feature: Comment Feature
    Scenario: Get list of comments for admin users
        Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }
        """
        Given I log in
        When I request to "GET" "/comments"
        Then The response status code should be 200
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"


    Scenario: Get list of comments for admin users
        Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
        Given I log in
        When I request to "GET" "/comments/XXX"
        Then The response status code should be 404
    
    Scenario: Post of comments for admin users
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
            "rating": 4,
            "content": "nana zaza nna nnaa",
            "product": "{product1}"
        }
        """
        
        When I request to "POST" "/comments"
        Then The response status code should be 201

    
    Scenario: Modification of comments for normal users
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
            "rating": 5
        }
        """
        When I request to "PUT" "/comments/{comment1}"
        Then The response status code should be 200

    
     Scenario: Delete a comment for admin users
        Given I set payload
        """
        {
          "email": "admin@admin.com",
          "password": "admin"
        }

        """
        Given I log in
        When I request to "DELETE" "/comments/{comment2}"
        Then The response status code should be 204


    ################### NORMAL USERS #################################

    
    Scenario: Post of comments for normal users
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
            "rating": 0,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
        
        When I request to "POST" "/comments"
        Then The response status code should be 201
        And The "content-type" header response should exist
        And The "content-type" header response should be "application/ld+json; charset=utf-8"
    

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
            "rating": 5
        }
        """
        When I request to "PUT" "/comments/{comment1}"
        Then The response status code should be 200
            
    Scenario: Delete of comments for normal users
        Given I set payload
        """
       {
          "email": "user.test@gmail.com",
          "password": "test"
        }
        """
        Given I log in
        When I request to "DELETE" "/comments/{comment1}"
        Then The response status code should be 403



    ############################## USER SELLER #####################################################


    Scenario: Post of comments for seller users
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
            "rating": 3,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
        
        When I request to "POST" "/comments"
        Then The response status code should be 201
    

    Scenario: Modification of comments for seller users
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
            "rating": 5
        }
        """
        When I request to "PUT" "/comments/{comment3}"
        Then The response status code should be 200

    
    Scenario: Delete of comments for seller users
        Given I set payload
        """
        {
          "email": "user.seller@gmail.com",
          "password": "password"
        }
        """
        Given I log in
        When I request to "DELETE" "/comments/{comment1}"
        Then The response status code should be 403
        

    ####################### USER NOT LOGGED IN ######################################################
    

    Scenario: Trying to posting a comment without being logged
    When I set payload
        """
        {
            "rating": 3,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
    When I request to "POST" "/comments/{comment2}"
    Then The response status code should be 405

    Scenario: Trying to modify a comment without being logged
    When I set payload
        """
        {
            "rating": 3,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
    When I request to "PUT" "/comments/{comment2}"
    Then The response status code should be 401
    

    Scenario: Trying to delete a comment without being logged
    When I set payload
        """
        {
            "rating": 3,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
    When I request to "DELETE" "/comments/{comment2}"
    Then The response status code should be 401
    
####################### Assert ##########################

    Scenario: Post of comments for users without rating
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
            "rating": ,
            "content": "nana na nna nnaa",
            "product": "{product1}"
        }
        """
        
        When I request to "POST" "/comments"
        Then The response status code should be 400


    Scenario: PUT of comments for users without rating
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
            "rating": ,
            "content": "nana na nna nnaa"
        }
        """
        When I request to "PUT" "/comments/{comment3}"
        Then The response status code should be 400

