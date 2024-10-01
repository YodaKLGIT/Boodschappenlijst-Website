// custom.js

// Function to toggle product visibility
function toggleProducts(event) {
    event.preventDefault(); // Prevent the default anchor behavior
    const productsDiv = event.target.closest('li').querySelector('.products');

    if (productsDiv) {
        const isVisible = productsDiv.style.maxHeight !== '0px';
        
        // If it's currently visible, hide it
        if (isVisible) {
            productsDiv.style.maxHeight = '0'; // Start collapsing
            productsDiv.style.opacity = '0'; // Fade out
        } else {
            productsDiv.style.maxHeight = `${productsDiv.scrollHeight}px`; // Expand to full height
            productsDiv.style.opacity = '1'; // Fade in
        }
    }
}


// Function to dismiss notification
function dismissNotification() {
    const notification = document.getElementById('notification');
    if (notification) {
        notification.remove(); 
    }
}

