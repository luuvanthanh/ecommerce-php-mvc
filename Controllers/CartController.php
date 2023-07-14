<?php
class CartController extends BaseController
{
    private $loadHelper;

    public function __construct()
    {
        $this->loadHelper = new Helper;
    }

    public function getCart()
    {
        return $this->view('frontend.cart.index', ['formatNumber' => $this->loadHelper]);
    }

    public function addCart()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $quantity = 1;
        $product = ['id' => $id, 'name' => $name, 'price' => $price, 'image' => $image, 'quantity' => $quantity];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!empty($_SESSION['cart'][$product['id']])) {
            $_SESSION['cart'][$product['id']]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product['id']] = $product;
        }

        echo json_encode($_SESSION['cart']);
    }

    public function increaseQuantity()
    {
        $id = $_POST['id'];

        if (isset($_SESSION['cart'])) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] += 1;
            }
        }
        echo json_encode($_SESSION['cart']);
    }

    public function decreaseQuantity()
    {
        $id = $_POST['id'];
        $qty = $_POST['qty'];

        if (isset($_SESSION['cart'])) {
            if (isset($_SESSION['cart'][$id])) {
                if ($qty > 0) {
                    $_SESSION['cart'][$id]['quantity'] -= 1;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        echo json_encode($_SESSION['cart']);
    }

    public function deleteCart()
    {
        $id = $_POST['id'];
        unset($_SESSION['cart'][$id]);
        echo json_encode($_SESSION['cart']);
    }
}
