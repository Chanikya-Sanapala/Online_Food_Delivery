<div class="dashboard-order">
    <h3>Order Menu</h3>
    <div class="order-wrapper" style="max-height: 400px; overflow-y: auto;">
         <!-- Items injected by JS -->
         <div class="empty-cart-msg" style="text-align:center; color:#888; margin-top:20px;">
             <i class="fas fa-shopping-basket" style="font-size:40px; margin-bottom:10px;"></i>
             <p>Your cart is empty</p>
         </div>
    </div>

    <div class="order-divider"></div>

    <div class="order-total">
        <div>
            <span>Subtotal</span>
            <span id="subtotalText">Rs.0.00</span>
        </div>
        <div>
            <span>Tax (10%)</span>
            <span id="taxText">Rs.0.00</span>
        </div>
        <div>
            <span>Delivery</span>
            <span id="deliveryText">Rs.0.00</span>
        </div>
        <div style="color: green;">
            <span>Discount</span>
            <span id="couponText">-Rs.0.00</span>
        </div> 
        <div style="font-size: 18px; font-weight: 700; color: #333; margin-top: 10px;">
            <span>Total</span>
            <span id="totalText">Rs.0.00</span>
        </div>
        <p id="youSave" style="color: green; font-size: 12px; text-align: right;"></p>
    </div>

    <div style="margin-top: 20px;">
        <input type="text" id="couponCode" placeholder="Coupon Code" style="width: 70%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
        <button id="applyCouponBtn" style="width: 25%; padding: 10px; background: #333; color: white; border: none; border-radius: 8px;">Apply</button>
    </div>

    <div style="margin-top: 15px;">
         <div style="display:flex; justify-content:space-between; align-items:center;">
             <h4>Delivery Address</h4>
             <button onclick="detectLocation()" style="font-size:10px; background:transparent; border:1px solid #999; border-radius:4px; cursor:pointer;">
                <i class="fas fa-location-arrow"></i> Use Current
             </button>
         </div>
         <div id="userAddress" contenteditable="true" style="background:#f9f9f9; padding:10px; border-radius:8px; font-size:13px; color:#555; border:1px solid #eee; margin-top:5px;">
             Detecting location...
         </div>
    </div>

    <button id="checkoutBtn" class="checkout-btn">Checkout</button>
</div>

<!-- Order Confirmation Modal -->
<div id="orderConfirmation" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:200; align-items:center; justify-content:center;">
    <div class="glass" style="background:white; padding:40px; border-radius:20px; text-align:center; max-width:400px;">
        <i class="fas fa-check-circle" style="font-size:60px; color:#4cd964; margin-bottom:20px;"></i>
        <h2>Order Placed!</h2>
        <p id="confirmMsg" style="margin:20px 0; color:#666;">Your food is on the way.</p>
        <button id="closeConfirm" class="add-btn" style="font-size:16px; padding:10px 30px;">Awesome</button>
    </div>
</div>
