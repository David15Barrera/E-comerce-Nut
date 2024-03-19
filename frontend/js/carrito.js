// Datos de ejemplo de productos en el carrito
const productosEscogidos = [
    { nombre: 'Producto 1', precio: 20 },
    { nombre: 'Producto 2', precio: 30 },
    { nombre: 'Producto 3', precio: 25 }
];

// Función para calcular el total del carrito
function calcularTotal() {
    const total = productosEscogidos.reduce((acc, curr) => acc + curr.precio, 0);
    return total.toFixed(2);
}

// Función para mostrar los productos en el carrito
function mostrarProductos() {
    const cartItems = document.querySelector('.cart-items');
    cartItems.innerHTML = '';
    productosEscogidos.forEach(producto => {
        const item = document.createElement('div');
        item.classList.add('cart-item');
        item.innerHTML = `
            <div>${producto.nombre}</div>
            <div>$${producto.precio.toFixed(2)}</div>
        `;
        cartItems.appendChild(item);
    });
}

// Función principal
function main() {
    const totalElement = document.getElementById('total');
    const checkoutBtn = document.getElementById('checkout-btn');

    mostrarProductos();
    totalElement.textContent = calcularTotal();

    checkoutBtn.addEventListener('click', () => {
        alert('Pasa al Metodo de Pago...');
        // Aquí iría el código para procesar el pago
    });
}

// Ejecutar la función principal al cargar la página
main();
