let clickedProductsId = JSON.parse(localStorage.getItem('clickedProductsId')) || [],
    max = Math.max(...clickedProductsId);
for (let i = 0; i < max; i++) {
    if (clickedProductsId.includes(i) === true) {

    }
}