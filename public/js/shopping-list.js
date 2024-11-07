// custom.js


function toggleProducts(event, shoppingListId) {
    event.preventDefault();
    const productSection = document.getElementById('products-' + shoppingListId);
    
    // Toggle max-height and opacity
    if (productSection.style.maxHeight === '0px' || productSection.style.maxHeight === '') {
        productSection.style.maxHeight = productSection.scrollHeight + 'px';
        productSection.style.opacity = '1';
    } else {
        productSection.style.maxHeight = '0px';
        productSection.style.opacity = '0';
    }
}

// Add this new function
function goToProduct(productId) {
    // Implement the logic to navigate to the product page
    console.log('Navigating to product:', productId);
    // You can use window.location.href = '/products/' + productId; to navigate
}

// Function to dismiss notification
function dismissNotification() {
    const notification = document.getElementById('notification');
    if (notification) {
        notification.remove(); 
    }
}




