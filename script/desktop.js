var head = document.getElementsByTagName('HEAD')[0];  
var link = document.createElement('link'); 
link.rel = 'stylesheet';  
link.type = 'text/css'; 
link.href = 'https://ventureby.com/shopify_popup_app/script/style.css?v='+Date.now();  
head.appendChild(link);


var productsXHR = new XMLHttpRequest();
productsXHR.open( "GET", '/admin/api/2021-07/products.json', false ); // false for synchronous request
productsXHR.send( null );

var currencyXHR = new XMLHttpRequest();
currencyXHR.open( "GET", '/admin/api/2021-10/shop.json', false );
currencyXHR.send( null );

if( currencyXHR.responseText ){
   var shopifyProductsCurrency = JSON.parse( currencyXHR.responseText ); 
   
   var shopCurrency = shopifyProductsCurrency.shop.money_format.replace("{{amount}}", "");
   console.log(shopCurrency);
}

if( productsXHR.responseText ){
	var shopifyProducts = JSON.parse( productsXHR.responseText );
    var ascOrderdProducts = [];
    var length = shopifyProducts.products.length;
    for(var i = length-1;i>=0;i--){
        ascOrderdProducts.push(shopifyProducts.products[i]);
    }
    shopifyProducts = ascOrderdProducts[0];
   
    console.log(shopifyProducts);
    
    var imgsrc = shopifyProducts.image.src;
    var price = shopifyProducts.variants[0].price;
    var compare_at_price = shopifyProducts.variants[0].compare_at_price;
    
	var html = '<div id="popUpModal"><div class="popUpcontent"><div class="popupCloseBtn" onclick="popUpclose()"><img src="https://ventureby.com/shopify_popup_app/inc/cross.png"></div><div class="imgBox"><img src="'+imgsrc+'"></div><div class="labelSmall">'+shopifyProducts.vendor+'</div><div class="mainProductLabel">'+shopifyProducts.title+'</div><div class="productPrice"><s>'+shopCurrency+price+'</s> '+shopCurrency+compare_at_price+'</div><div></div><div class="productVariants"><div class="quantity-wrapper"><div class="counterMain"><label>Quantity</label><div class="counterMaininner"><span class="add-down add-action">-</span><input id="prodQuantity" type="text" name="quantity" value="700"/><span class="add-up add-action">+</span></div></div><div class="select-size"><label>Select Size</label><select><option>Size 1</option></select></div></div><div class="select-color"><label>Select Color</label><select><option>Red</option></select></div></div><button class="addToCart" onclick="popUpclose()">Add to Cart</button><button class="noThanks" onclick="popUpclose()">No Thanks</button></div></div>';document.body.innerHTML += html;
}

document.getElementById("popUpModal").style.display = 'none'; 
(function(ns, fetch) {
    if (typeof fetch !== 'function') return;

    ns.fetch = function() {
        const response = fetch.apply(this, arguments);

        response.then(res => {
            if ([
                    `${window.location.origin}/cart/add.js`,
                    `${window.location.origin}/cart/add`,
                    // `${window.location.origin}/cart/update.js`,
                    // `${window.location.origin}/cart/change.js`,
                    // `${window.location.origin}/cart/clear.js`,
                ].includes(res.url)) {
                res.clone().json().then(data => display_popup(data));
            }
        });

        return response;
    }

}(window, window.fetch));

function display_popup(data){
    document.getElementById("popUpModal").style.display = 'block';
}

function popUpclose(){
    document.getElementById("popUpModal").style.display = 'none';
}






