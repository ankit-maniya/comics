<?php
require_once(__DIR__ . '/db_master.php');

class Cart
{
    protected $cartItems = [];
    protected $totalItems = 0;
    protected $totalPrice = 0;

    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $this->cartItems = &$_SESSION['cart'];
        $this->calculateTotal();
    }

    public function addToCart(Comic $comic, $quantity = 1)
    {
        $comicId = $comic->getComicId();

        if (isset($this->cartItems[$comicId])) {
            // Item already exists in cart, update quantity
            $this->cartItems[$comicId]['quantity'] += $quantity;
        } else {
            // Add new item to cart
            $this->cartItems[$comicId] = [
                'item' => $comic,
                'quantity' => $quantity,
            ];
        }
    }

    public function removeFromCart($comicId)
    {
        if (isset($this->cartItems[$comicId])) {
            unset($this->cartItems[$comicId]);
        }
    }

    public function updateQuantity($comicId, $quantity)
    {
        if (isset($this->cartItems[$comicId])) {
            $this->cartItems[$comicId]['quantity'] = $quantity;
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $totalItems = 0;
        $totalPrice = 0;

        foreach ($this->cartItems as $item) {
            $totalItems += $item['quantity'];
            $totalPrice += $item['item']->getComicPrice() * $item['quantity'];
        }

        $this->totalItems = $totalItems;
        $this->totalPrice = $totalPrice;
    }

    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function getTotalItems()
    {
        $totalItems = 0;
        foreach ($this->cartItems as $item) {
            $totalItems += $item['quantity'];
        }
        return $totalItems;
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->cartItems as $item) {
            $totalPrice += $item['item']->getComicPrice() * $item['quantity'];
        }
        return $totalPrice;
    }

    public function clearCart()
    {
        $this->cartItems = [];
    }
}
