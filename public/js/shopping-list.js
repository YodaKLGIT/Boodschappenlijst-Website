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

function startEditing(productListId) {
    const productName = document.getElementById('product-name-' + productListId);
    
    // Make the <h3> element editable
    productName.contentEditable = 'true';
    productName.focus(); // Focus on the element to start editing
}

function stopEditing(productListId) {
    const productName = document.getElementById('product-name-' + productListId);

    // Make the <h3> element non-editable
    productName.contentEditable = 'false';

    // Fetch the new name
    const newName = productName.innerText;

    // Fetch the theme ID from a hidden input or data attribute (modify as necessary)
    const themeId = document.getElementById('theme-id-' + productListId).value; // Assuming you have a hidden input for theme ID

    // Send the new name and theme_id to the server using Fetch API
    fetch(`/lists/${productListId}`, {
        method: 'PUT', // Assuming you're using PUT for updates
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ name: newName, theme_id: themeId }), // Sending the new name and theme_id
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Success:', data);
        // Optionally, update UI or show a message
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


function handleKey(event, productListId) {
    if (event.key === 'Enter') {
        stopEditing(productListId); // Save on Enter
    } else if (event.key === 'Escape') {
        const productName = document.getElementById('product-name-' + productListId);
        productName.contentEditable = 'false'; // Revert back to non-editable
        productName.blur(); // Remove focus from the element
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

