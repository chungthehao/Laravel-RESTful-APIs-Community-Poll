<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI5MGZiYTVhNmUyNTdiZjI0ZjM2ODViN2FmMGRlMWNhNDM1Njk4ZGQ2ODdkNDNhNDcwM2RiNTk4ZWFiNjI0YTNmNDA1MjQzNzEzYTcxOGM3In0.eyJhdWQiOiI0IiwianRpIjoiMjkwZmJhNWE2ZTI1N2JmMjRmMzY4NWI3YWYwZGUxY2E0MzU2OThkZDY4N2Q0M2E0NzAzZGI1OThlYWI2MjRhM2Y0MDUyNDM3MTNhNzE4YzciLCJpYXQiOjE1NjkwMjk5NjQsIm5iZiI6MTU2OTAyOTk2NCwiZXhwIjoxNjAwNjUyMzYzLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.pVWHjVGMHAH33DA6JzyTHAMtNbcn3LTZWb5iVLzL9dCgGHOV7Rm7cW7F8X46-PYB3qJ3JWXoVhH2mLVhOdtyqbsMsVjFMf16OabuMCpbGNpCWGnjtT5MzKEBhKhtz7HTXY02ahWBHuk2TCNjso0RRB0zjPQ4rwt8N5rrvouBHCtaBbPdbeceqksPq360DEDWznoqltLGzOMzsL4267jblp2-a2gHAxEol67l3LvX_E3qCrGeiOQkNM9jEa-Is2GYDgI4z-di-DBexSfRxAenPr0iIK7KkLWSWZgXOTgM5pGHSYC6wlcemkWMO2A7GAt1FScUzhupi5fKIalYU2zD7e3RjFq4fI1iDlUvrC_ENiOEh6uLtskvMs_JisGWoJwy86tDfcQF-HZBhLSREIfIpD_hTKwZKv1Ap4K49yqvZGGhOzX9vxjs_sda3feVUh3-DF3XqeG_qBiFg9Zo2mfS2fmXxN6nLT-d_H5vID3kDjyDtTKbZXugm7jHrFrj9s29ZoQrApSOamEXjTJMYkZZtHyWiFl5ERC7jP0GRElFa4iQczB1oMoKxwB9uTCn78XBvCUd20AU5mQQ1SCVOfrSmc2fC1UVEXBAfOG6vFPTNiKLqdwEI9PFpj0xdbEPSuJiHCpv61iRd7pUbwD1o5sZmJTn9GGYLV4CQmeKs76l8hI";
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client();
        $this->response = $client->request(
            $httpMethod,
            'http://127.0.0.1:8000' . $argument1,
            [
                'body' => $this->payload,
                'headers' => [
                    "Authorization" => "Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json",
                ],
            ]
        );
        $this->responseBody = $this->response->getBody(true);
    }

    /**
     * @Then /^I get a response$/
     */
    public function iGetAResponse()
    {
        if (empty($this->responseBody)) {
            throw new Exception('Did not get a response from the API');
        }
    }

    /**
     * @Given /^the response is JSON$/
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

    /**
     * @Then the response contains :arg1 records
     */
    public function theResponseContainsRecords($arg1)
    {
        $data = json_decode($this->responseBody);
        $count = count($data);
        return $count == $arg1;
    }

    /**
     * @Then the response contains a title of :arg1
     */
    public function theResponseContainsATitleOf($arg1)
    {
        $data = json_decode($this->responseBody);

        if ($data->title == $arg1) {

        } else {
            throw new Exception("The title does not match.\n" . $this->responseBody);
        }
    }


}