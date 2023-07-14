<!DOCTYPE html>
<html lang="en">

<head>
    <?php view('frontend.layouts.css') ?>
</head>

<body>
    <?php view('frontend.layouts.header') ?>
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Item</td>
                            <td class="description"></td>
                            <td class="price">Price</td>
                            <td class="quantity">Quantity</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($_SESSION['cart'])) : ?>
                            <?php $sum = 0; ?>
                            <?php foreach ($_SESSION['cart'] as $key => $item) : ?>
                                <?php
                                    $price = $item['price'];
                                    $price = str_replace('VND', '', $price);
                                    $price = str_replace(',', '', $price);
                                    $total = (int)$price * $item['quantity'];
                                    $sum += $total; 
                                ?>
                                <tr>
                                    <input class="product_id" type="hidden" value="<?php echo $item['id'] ?>">
                                    <td class="cart_product">
                                        <a href=""><img src="<?php echo $item['image'] ?>" alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><?php echo $item['name'] ?></h4>
                                    </td>
                                    <td class="cart_price">
                                        <p><?php echo $item['price'] ?></p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            <a style="cursor:pointer;" class="cart_quantity_up"> + </a>
                                            <input class="cart_quantity_input" type="text" name="quantity" value="<?php echo $item['quantity'] ?>" autocomplete="off" size="2">
                                            <a style="cursor:pointer;" class="cart_quantity_down"> - </a>
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price"><?php echo $formatNumber->formatNumber($total); ?> VND</p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (empty($_SESSION['cart'])) : ?>
                    <h4>no data</h4>
                <?php endif; ?>
            </div>
        </div>
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container">
            <div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="chose_area">
                        <ul class="user_option">
                            <li>
                                <input type="checkbox">
                                <label>Use Coupon Code</label>
                            </li>
                            <li>
                                <input type="checkbox">
                                <label>Use Gift Voucher</label>
                            </li>
                            <li>
                                <input type="checkbox">
                                <label>Estimate Shipping & Taxes</label>
                            </li>
                        </ul>
                        <ul class="user_info">
                            <li class="single_field">
                                <label>Country:</label>
                                <select>
                                    <option>United States</option>
                                    <option>Bangladesh</option>
                                    <option>UK</option>
                                    <option>India</option>
                                    <option>Pakistan</option>
                                    <option>Ucrane</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>

                            </li>
                            <li class="single_field">
                                <label>Region / State:</label>
                                <select>
                                    <option>Select</option>
                                    <option>Dhaka</option>
                                    <option>London</option>
                                    <option>Dillih</option>
                                    <option>Lahore</option>
                                    <option>Alaska</option>
                                    <option>Canada</option>
                                    <option>Dubai</option>
                                </select>

                            </li>
                            <li class="single_field zip-field">
                                <label>Zip Code:</label>
                                <input type="text">
                            </li>
                        </ul>
                        <a class="btn btn-default update" href="">Get Quotes</a>
                        <a class="btn btn-default check_out" href="">Continue</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Cart Sub Total <span>$59</span></li>
                            <li>Eco Tax <span>$2</span></li>
                            <li>Shipping Cost <span>Free</span></li>
                            <li>Total <span class="product_total"><?php echo $formatNumber->formatNumber($sum) . " " . "VND"; ?></span></li>
                        </ul>
                        <a class="btn btn-default update" href="">Update</a>
                        <a class="btn btn-default check_out" href="">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->
    <?php view('frontend.layouts.footer') ?>
</body>

</html>
<?php view('frontend.layouts.js') ?>