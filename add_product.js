// FILE: add_product.js

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  
  const productForm = document.getElementById('productForm');
  
  const productNameInput = document.getElementById('product_name'); 
<<<<<<< HEAD
=======
  // --- END ADDED ---
>>>>>>> 611ad7d7c5de580eea32608f462c2caf5309802c

  const priceInput = document.getElementById('price');
  const stockInput = document.getElementById('stock');
  const categorySelect = document.getElementById('category');
  const errorMessage = document.getElementById('errorMessage');

  // Add a 'submit' event listener to the form
  productForm.addEventListener('submit', function(e) {
    // Hide old errors
    errorMessage.style.display = 'none';
    errorMessage.textContent = '';
    
    // Convert values
    // --- ADDED .trim() ---
    const productName = productNameInput.value.trim(); 
    // --- END ADDED ---
    const price = parseFloat(priceInput.value);
    const stock = parseInt(stockInput.value, 10);
    const category = categorySelect.value;

    let errorMessages = [];

    // --- Start Validation Checks ---
    
    // --- ADDED THIS BLOCK ---
    if (productName === "") {
      errorMessages.push('Please enter a product name.');
    }
    // --- END ADDED ---

    if (category === "") {
      errorMessages.push('Please select a category.');
    }

    if (isNaN(price) || price <= 0) {
      errorMessages.push('Price must be a number greater than zero.');
    }
    
    if (isNaN(stock) || stock < 0) {
      errorMessages.push('Stock must be a number (0 or more).');
    }

    // --- End Validation Checks ---

    // If we have any errors, stop the form
    if (errorMessages.length > 0) {
      e.preventDefault(); // This is the most important part
      errorMessage.innerHTML = errorMessages.join('<br>');
      errorMessage.style.display = 'block';
    }
    // If there are no errors, the form submits normally.
<<<<<<< HEAD
  });
=======
  });
>>>>>>> 611ad7d7c5de580eea32608f462c2caf5309802c

});