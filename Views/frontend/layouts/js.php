<script src="public/js/jquery.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/jquery.scrollUp.min.js"></script>
<script src="public/js/price-range.js"></script>
<script src="public/js/jquery.prettyPhoto.js"></script>
<script src="public/js/main.js"></script>
<script>
    // format number
    function formatNumber(num) {
        let numString = '';
        while (num > 0) {
            let div = num % 1000;
            num = Math.floor(num / 1000);
            if (num !== 0) {
                if (div < 10) {
                    div = '00' + div;
                } else if (div < 100) {
                    console.log(1099 % 1000, 'thanh');
                    div = '0' + div;
                }
                numString = ',' + div + numString;
            } else {
                numString = div + numString;
            }
        }

        return numString;
    }
    // detail
    $(".category").on("click", function() {
        const $id = this.id;
        $.ajax({
            type: "GET",
            url: '?controller=product&action=renderProductByCategoryId',
            data: {
                id: $id
            },
            success: function(response) {
                const data = JSON.parse(response);
                let html = '<h2 class="title text-center">Features Items</h2>';
                data.map(item => {
                    let image = JSON.parse(item.image);
                    html += `
                    <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="public/images/home/${image[0].name}" alt="" />
                                                <h2>${item.price} VND</h2>
                                                <p>${item.name}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                    <h2>${item.price} VND</h2>
                                                    <p>${item.name}</p>
                                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <ul class="nav nav-pills nav-justified">
                                                <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                                <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                    `;
                });
                $(".features_items").html(html);
            }
        });
    });
    // add to cart
    $(".add-to-cart").on("click", function() {
        $this = $(this).closest(".single-products");
        const id = $this.find(".productinfo input").val();
        const name = $this.find(".productinfo p").text();
        const price = $this.find(".productinfo h2").text();
        const image = $this.find(".productinfo img").attr('src');
        $.ajax({
            type: "POST",
            url: '?controller=cart&action=addCart',
            data: {
                id: id,
                name: name,
                price: price,
                image: image
            },
            success: function(response) {
                const data = JSON.parse(response);
                $(".cart-quantity").text(Object.keys(data).length);
            }
        });
        const $message = $(this).closest(".product-image-wrapper").find('.message-cart');
        $message.css('color', 'blue');
        $message.text('Add to cart success!');
        setTimeout(function() {
            $message.text('');
        }, 2000);
    });
    // increase quantity
    $(".cart_quantity_up").on("click", function() {
        const id = $(this).closest('tr').find('.product_id').val();
        let valueQuantity = $(this).closest('tr').find(".cart_quantity_input").val();
        let qty = parseInt(valueQuantity) + 1;
        $(this).closest('tr').find(".cart_quantity_input").val(qty);
        //price
        let price = $(this).closest('tr').find('.cart_price p').text();
        price = price.replace("VND", "");
        price = parseInt(price.replace(",", ""));
        //total
        let total = qty * price;
        $(this).closest('tr').find('.cart_total p').text(formatNumber(total) + ' ' + 'VND');
        let allProductTotal = 0;
        $.ajax({
            type: "POST",
            url: '?controller=cart&action=increaseQuantity',
            data: {
                id: id
            },
            success: function(response) {
                const data = JSON.parse(response);
                for (const item in data) {
                    let price = data[item].price;
                    price = price.replace('VND', '');
                    price = Number(price.replace(',', ''));
                    let quantity = data[item].quantity;
                    allProductTotal += (price * quantity);
                    $(".product_total").text(formatNumber(allProductTotal) + ' ' + 'VND');
                }
            }
        });
    });
    // decrease quantity
    $(".cart_quantity_down").on("click", function() {
        const id = $(this).closest('tr').find('.product_id').val();
        let valueQuantity = $(this).closest('tr').find(".cart_quantity_input").val();
        let qty = parseInt(valueQuantity) - 1;
        let allProductTotal = 0;
        if (qty > 0) {
            $(this).closest('tr').find(".cart_quantity_input").val(qty);
            //price
            let price = $(this).closest('tr').find('.cart_price p').text();
            price = price.replace("VND", "");
            price = parseInt(price.replace(",", ""));
            // total
            let total = qty * price;
            $(this).closest('tr').find('.cart_total p').text(formatNumber(total) + ' ' + 'VND');
        } else {
            $(this).closest('tr').remove();
        }
        $.ajax({
            type: "POST",
            url: '?controller=cart&action=decreaseQuantity',
            data: {
                id: id,
                qty: qty
            },
            success: function(response) {
                const data = JSON.parse(response);
                for (const item in data) {
                    let price = data[item].price;
                    price = price.replace('VND', '');
                    price = Number(price.replace(',', ''));
                    let quantity = data[item].quantity;
                    allProductTotal += (price * quantity);
                    $(".product_total").text(formatNumber(allProductTotal) + ' ' + 'VND');
                }
                $(".cart-quantity").text(Object.keys(data).length);
            }
        });

    });
    // delete cart
    $(".cart_quantity_delete").on("click", function() {
        
        const id = $(this).closest('tr').find('.product_id').val();
        let allProductTotal = 0;
        $.ajax({
            type: "POST",
            url: '?controller=cart&action=deleteCart',
            data: {
                id: id
            },
            success: function(response) {
                const data = JSON.parse(response);
                for (const item in data) {
                    let price = data[item].price;
                    price = price.replace('VND', '');
                    price = Number(price.replace(',', ''));
                    let quantity = data[item].quantity;
                    allProductTotal += (price * quantity);
                    $(".product_total").text(formatNumber(allProductTotal) + ' ' + 'VND');
                }
                $(".cart-quantity").text(Object.keys(data).length);
            }
        });
        $(this).closest('tr').remove();
    });
</script>