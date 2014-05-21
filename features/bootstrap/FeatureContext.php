<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Behat context class.
 */
class FeatureContext extends RawMinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I go to a survey answer page
     */
    public function iGoToASurveyAnswerPage()
    {
        $session = $this->getSession();
        $baseUrl = $this->getMinkParameter('base_url');

        $session->visit(sprintf('%s/en/knoodle/50/answer', $baseUrl));
    }

    /**
     * @When I fill correctly the form
     */
    public function iFillCorrectlyTheForm()
    {
        $this->fillAnswerForm();
        $this->fillValidateForm();
    }

    /**
     * @Then my super website should thanks me
     */
    public function mySuperWebsiteShouldThanksMe()
    {
        $webAssert = $this->assertSession()->pageTextContains('Thanks!');
    }

    /**
     * @Given I go to a survey page
     */
    public function iGoToASurveyPage()
    {
        throw new PendingException();
    }

    /**
     * @When I fill the form but whithout my email
     */
    public function iFillTheFormButWhithoutMyEmail()
    {
        $this->fillAnswerForm();
        $this->getSession()->getPage()->fillField('Email','');
        $this->fillValidateForm();
    }

    /**
     * @Then my website should not be happy ar all
     */
    public function myWebsiteShouldNotBeHappyArAll()
    {
        $this->assertSession()->addressEquals(sprintf(
            '%s/en/knoodle/50/answer',
            $this->getMinkParameter('base_url')
        ));
    }

    private function fillValidateForm()
    {
        $page = $this->getSession()->getPage();
        $page->find('css','#survey_name_validate')->click();
    }

    private function fillAnswerForm()
    {
        $page = $this->getSession()->getPage();
        $page->fillField('First name', 'George');
        $page->fillField('Last name', 'Abtibol');
        $page->fillField('Email', 'george@abtibol.com');
        $page->fillField(
            $page->find('css','#survey_name_choices_question_196_0')->getAttribute('name'),
            $page->find('css','#survey_name_choices_question_196_0')->getAttribute('value')
        );
        $page->fillField(
            $page->find('css','#survey_name_choices_question_197_0')->getAttribute('name'),
            $page->find('css','#survey_name_choices_question_197_0')->getAttribute('value')
        );
        $page->fillField(
            $page->find('css','#survey_name_choices_question_198_0')->getAttribute('name'),
            $page->find('css','#survey_name_choices_question_198_0')->getAttribute('value')
        );
        $page->fillField(
            $page->find('css','#survey_name_choices_question_199_0')->getAttribute('name'),
            $page->find('css','#survey_name_choices_question_199_0')->getAttribute('value')
        );
        $page->fillField(
            $page->find('css','#survey_name_choices_question_200_0')->getAttribute('name'),
            $page->find('css','#survey_name_choices_question_200_0')->getAttribute('value')
        );
    }
}
