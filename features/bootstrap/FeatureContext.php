<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * Command line output
     *
     * @var string
     */
    private $output;

    /**
     * Name of the fixture test file
     *
     * @var string
     */
    private $fixtureFile;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {}

    /**
     * @Given the “3 for the price of 2” offer is enabled
     */
    public function the3ForThePriceOf2OfferIsEnabled()
    {
        $this->fixtureFile = 'test_2.xml';
    }

    /**
     * @Given the “Buy Shampoo & get Conditioner for 50% off” offer is enabled
     */
    public function theBuyShampooGetConditionerForOffOfferIsEnabled()
    {
        $this->fixtureFile = 'test_3.xml';
    }

    /**
     * @When the following products are put on the order
     */
    public function theFollowingProductsArePutOnTheOrder(TableNode $table)
    {
        // @TODO move data into xml structure and then pass it into command
        $command = 'php app/console acme:discount src/Acme/DemoBundle/Tests/Command/Fixtures/' . $this->fixtureFile;

        exec($command, $output);

        $this->output = trim(implode("\n", $output));
    }

    /**
     * @Then the order total should be “:arg1”
     */
    public function theOrderTotalShouldBe($arg1)
    {
        if ((string) $arg1 !== $this->output) {
            throw new Exception(
                "Order total should be:\n" . $this->output
            );
        }
    }

}
