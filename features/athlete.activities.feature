Feature: Athlete activities
  In order to get points for my activities
  As an athlete
  I need to be able to sync my activities

  Scenario: As a first time user I need to add my activities
    Given I am authenticated as "newathlete"
    And I have 0 activities
    When I sync my activities
    Then I should have 5 activities

  Scenario: As a returning user I need to add my latest activities
    Given I am authenticated as "existingathlete"
    And I have 10 activities
    When I sync my activities
    Then I should have 25 activities

