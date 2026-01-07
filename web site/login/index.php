<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Food Delivery</title>
</head>
<body>
    <input type="checkbox" id="cart">
    <label for="cart" class="label-cart"><span class="fas fa-shopping-cart"></span></label>
    <h3 class="logo">FOOD DELIVERY</h3>

    <div class="sidebar">
        <div class="sidebar-menu">
            <span class="fas fa-search"></span>
            <a href="search.html">search</a>
        </div>
        <div class="sidebar-menu">
            <span class="fas fa-home"></span>
            <a href="#">home</a>
        </div>
        <div class="sidebar-menu">
            <span class="fas fa-heart"></span>
            <a href="#">favs</a>
        </div>
        <div class="sidebar-menu">
            <span class="fas fa-user"></span>
            <a href="profile.html">profile</a>
        </div>
        <div class="sidebar-menu">
            <span class="fas fa-sliders-h"></span>
            <a href="setting.html">setting</a>
        </div>
    </div>

    <div class="dashboard">
        <div class="dashboard-banner">
            <img src="image banner.jpg">
            <div class="banner-promo">
                <h1><span>50% OFF</span><br>Tasty Food<br>On Your Hand</h1>
            </div>
        </div>

        <h3 class="dashboard-title">recommend food for you</h3>
        <div class="dashboard-menu">
            <a href="#">favorites</a>
            <a href="#">Best seller</a>
            <a href="#">Near me</a>
            <a href="#">Promotion</a>
            <a href="#">Top rated</a>
            <a href="#">All</a>
        </div>

        <div class="scroll-container">
            <img src="Chicken-Biryani.webp" alt="Chicken Biriyani" width="200" height="200">
            <img src="pizza.jpg" alt="pizza" width="200" height="200">
            <img src="fried rice.webp" alt="fried rice" width="200" height="200">
            <img src="dasa.jpg" alt="dosa" width="200" height="200">
            <img src="chicken.webp" alt="chicken" width="200" height="200">
            <img src="cake.jpeg" alt="cake" width="200" height="200">
            <img src="dessert.jpg" alt="dessert" width="200" height="200">
        </div>
        
        <div class="gallery-container">
            <div class="gallery" data-name="French Fries" data-price="99">
                <a target="_blank" href="image 1.jpg">
                    <img src="image 1.jpg" alt="french fries">
                </a>
                <div class="description">French Fries</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Naan" data-price="49">
                <a target="_blank" href="nana.webp">
                    <img src="nana.webp" alt="naan">
                </a>
                <div class="description">Naan</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Lassi" data-price="59">
                <a target="_blank" href="image 7.jpg">
                    <img src="image 7.jpg" alt="lassi">
                </a>
                <div class="description">Lassi</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Chicken Biryani" data-price="149">
                <a target="_blank" href="image 4.jpg">
                    <img src="image 4.jpg" alt="ChickenBiryani">
                </a>
                <div class="description">Chicken Biryani</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Noodles" data-price="99">
                <a target="_blank" href="image 5.jpg">
                    <img src="image 5.jpg" alt="noodles">
                </a>
                <div class="description">Noodles</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Burger" data-price="79">
                <a target="_blank" href="image 6.jpg">
                    <img src="image 6.jpg" alt="burger">
                </a>
                <div class="description">Burger</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Veg Thali" data-price="129">
                <a target="_blank" href="pure veg tali.jpeg">
                    <img src="pure veg tali.jpeg" alt="veg tali">
                </a>
                <div class="description">Pure Veg Thali</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Momos" data-price="69">
                <a target="_blank" href="momos.jpg">
                    <img src="momos.jpg" alt="momos">
                </a>
                <div class="description">Momos</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Sandwich" data-price="59">
                <a target="_blank" href="sandwich.jpg">
                    <img src="sandwich.jpg" alt="sandwich">
                </a>
                <div class="description">Sandwich</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Appam" data-price="39">
                <a target="_blank" href="Appam.jpg">
                    <img src="Appam.jpg" alt="Appam">
                </a>
                <div class="description">Appam</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Orange Juice" data-price="29">
                <a target="_blank" href="Orangejuice.jpg">
                    <img src="Orangejuice.jpg" alt="Orangejuice">
                </a>
                <div class="description">Orange Juice</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="gallery" data-name="Ice Cream" data-price="49">
                <a target="_blank" href="ice cream.jpeg">
                    <img src="ice cream.jpeg" alt="ice cream">
                </a>
                <div class="description">Ice Cream</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>

        <div class="dashboard-order">
            <h3>Order Menu</h3>
            <div class="order-address">
                <p>Address Delivery</p>
                <h4>vel junction, prince hostel, avadi</h4>
            </div>
            <div class="order-time">
                <span class="fas fa-clock"></span>30mins<span class="fas fa-map-marker-alt">5km</span>
            </div>

            <div class="order-wrapper" id="orderWrapper">
                <!-- Cart items will be dynamically added here -->
            </div>

            <hr class="divider">
            <div class="order-total">
                <p>Subtotal <span id="subtotal">Rs.0</span></p>
                <p>Tax (10%) <span id="tax">Rs.0</span></p>
                <p>Delivery Fee <span>Rs.75</span></p>

                <div class="order-promo">
                    <input class="input-promo" type="text" placeholder="Voucher">
                    <button class="button-promo">Find promo</button> 
                </div>
                <hr class="divider">
                <p>Total <span id="total">Rs.75</span></p>
            </div>
            <button class="checkout" onclick="window.location.href='order.html'">Checkout</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            const orderWrapper = document.getElementById('orderWrapper');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            let subtotal = 0;

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const gallery = this.closest('.gallery');
                    const name = gallery.dataset.name;
                    const price = parseFloat(gallery.dataset.price);
                    const imgSrc = gallery.querySelector('img').src;

                    const orderCard = document.createElement('div');
                    orderCard.className = 'order-card';
                    orderCard.innerHTML = `
                        <img class="order-image" src="${imgSrc}">
                        <div class="order-detail">
                            <p>${name}</p>
                            <i class="fas fa-times"></i> <input type="text" value="1">
                        </div>
                        <h4 class="order-price">Rs.${price}/-</h4>
                    `;

                    orderWrapper.appendChild(orderCard);

                    subtotal += price;
                    updateTotals();
                });
            });

            function updateTotals() {
                const tax = subtotal * 0.1;
                const total = subtotal + tax + 75; // 75 is the delivery fee

                subtotalElement.textContent = `Rs.${subtotal.toFixed(2)}`;
                taxElement.textContent = `Rs.${tax.toFixed(2)}`;
                totalElement.textContent = `Rs.${total.toFixed(2)}`;
            }
        });
    </script>
</body>
</html>