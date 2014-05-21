Feature: Answer to a survey
    In order to answer a survey
    As an anonymous
    I should be able to validate a form

    Scenario: Successfully answer to a survey
        Given I go to a survey answer page
        When I fill correctly the form
        Then my super website should thanks me

    Scenario: failed to answer a survey
        Given I go to a survey answer page
        When I fill the form but whithout my email
        Then my website should not be happy ar all


