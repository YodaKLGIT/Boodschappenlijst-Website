// custom.js

function toggleProducts(event, shoppingListId) {
    event.preventDefault();
    const productSection = document.getElementById('products-' + shoppingListId);
    
    if (productSection.style.maxHeight === '0px' || productSection.style.maxHeight === '') {
        productSection.style.maxHeight = productSection.scrollHeight + 'px';
        productSection.style.opacity = '1';
    } else {
        productSection.style.maxHeight = '0px';
        productSection.style.opacity = '0';
    }
}











// Function to dismiss notification
function dismissNotification() {
    const notification = document.getElementById('notification');
    if (notification) {
        notification.remove(); 
    }
}

