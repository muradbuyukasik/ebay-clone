<?php

require_once('models/Bidding.php');

class BiddingController
{
    /**
     *
     * Get a specific bidding by id
     *
     * @param int $id The id for the bidding to be retrieved
     *
     * @return Bidding Returns the relevant bidding from the database
     *
     */
    public static function get($id)
    { }

    /**
     *
     * Create a new bidding
     *
     * @param array $data The data to create a new bidding.
     *
     */
    public static function post($data)
    {
        require_once("controllers/ProductController.php");

        if (!isset($_SESSION['authenticated']))
            return ["error" => "Login of maak een account aan om mee te bieden."];

        require_once("validators/BiddingValidator.php");

        $isValid = BiddingValidator::validate($data['BidAmount'], ProductController::get($data['ProductId'])['Price']);

        if (is_array($isValid))
            return $isValid;

        $bidding = new Bidding();

        $bidding->ProductId = $data['ProductId'];
        $bidding->BidAmount = $data['BidAmount'];
        $bidding->Username = $_SESSION['authenticated']['Username'];
        $bidding->BidDate = date("m-d-Y");
        $bidding->BidTime = date("h:i:sa");

        require_once('controllers/ProductController.php');

        ProductController::put($data['ProductId'], [
            "Price" => $data['BidAmount'],
            "Buyer" => $_SESSION['authenticated']['Username']
        ]);

        $bidding->post();
    }

    /**
     *
     * Execute a quick bidding
     *
     * @param int $productId The productId to create a new bidding.
     * @param int $amount The amount to bid
     * 
     * @return array Return any errors or true
     *
     */
    public static function quickBid($productId, $amount)
    {
        if (!isset($_SESSION['authenticated']))
            redirect("inloggen");

        require_once("controllers/ProductController.php");

        $product = Product::get($productId);

        $bidding = [
            "ProductId" => $product['ProductId'],
            "BidAmount" => $product['Price'] + $amount
        ];
        $errors = BiddingController::post($bidding);
        if (is_array($errors))
            return $errors;

        redirect("/veiling/$productId");
    }
}
