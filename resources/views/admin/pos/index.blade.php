<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Punto de Venta (POS)
            </h2>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Ver Órdenes
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="success-message"
                class="hidden mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline" id="success-text"></span>
            </div>

            <div id="error-message"
                class="hidden mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline" id="error-text"></span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna Izquierda: Productos y Carrito (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Búsqueda de Productos -->
                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Buscar Productos</h3>
                        <div class="relative">
                            <input type="text" id="product-search" placeholder="Buscar por nombre o SKU..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10">
                            <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div id="product-results" class="mt-3 space-y-2 max-h-64 overflow-y-auto"></div>
                    </div>

                    <!-- Carrito -->
                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Carrito de Venta</h3>
                        <div id="cart-items" class="space-y-3">
                            <p class="text-gray-500 text-center py-8">No hay productos en el carrito</p>
                        </div>

                        <!-- Resumen de Totales -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold" id="subtotal">$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Impuestos:</span>
                                <span class="font-semibold" id="taxes">$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm" id="discount-row" style="display: none;">
                                <span class="text-gray-600">Descuento:</span>
                                <span class="font-semibold text-green-600" id="discount">-$0.00</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                                <span>Total:</span>
                                <span class="text-indigo-600" id="total">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Cliente y Pago (1/3) -->
                <div class="space-y-6">
                    <!-- Selección de Cliente -->
                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cliente</h3>
                        <div class="relative mb-3">
                            <input type="text" id="customer-search" placeholder="Buscar por nombre, email o RIF..."
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-10">
                            <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div id="customer-results" class="space-y-2 max-h-48 overflow-y-auto mb-3"></div>

                        <div id="selected-customer" class="hidden p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800" id="customer-name"></p>
                                    <p class="text-sm text-gray-600" id="customer-email"></p>
                                    <p class="text-sm text-gray-600" id="customer-rif"></p>
                                </div>
                                <button onclick="clearCustomer()" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button onclick="openCustomerModal()"
                            class="w-full mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                            + Nuevo Cliente
                        </button>
                    </div>

                    <!-- Cupón de Descuento -->
                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Cupón de Descuento</h3>
                        <div class="flex gap-2">
                            <input type="text" id="coupon-code" placeholder="Código de cupón"
                                class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button onclick="applyCoupon()"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 rounded-lg">
                                Aplicar
                            </button>
                        </div>
                        <div id="coupon-applied" class="hidden mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-green-800 font-semibold" id="coupon-name"></span>
                                <button onclick="removeCoupon()" class="text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Método de Pago y Estado -->
                    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalles de Pago</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                                <select id="payment-method"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="pago_movil">Pago Móvil</option>
                                    <option value="zelle">Zelle</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Orden</label>
                                <select id="order-status"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="pagada">Pagada</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="enviada">Enviada</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Finalizar Venta -->
                    <button onclick="finalizeSale()"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg text-lg">
                        Finalizar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.pos._customer_modal')

    <script>
        let cart = [];
        let selectedCustomer = null;
        let appliedCoupon = null;

        // Búsqueda de productos
        let productSearchTimeout;
        document.getElementById('product-search').addEventListener('input', function () {
            clearTimeout(productSearchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                document.getElementById('product-results').innerHTML = '';
                return;
            }

            productSearchTimeout = setTimeout(() => {
                fetch('{{ route('admin.pos.products.search') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ query })
                })
                    .then(res => res.json())
                    .then(products => {
                        const resultsDiv = document.getElementById('product-results');
                        if (products.length === 0) {
                            resultsDiv.innerHTML = '<p class="text-gray-500 text-sm">No se encontraron productos</p>';
                            return;
                        }

                        resultsDiv.innerHTML = products.map(product => `
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, ${product.stock})">
                            <div class="flex-1">
                                <p class="font-semibold text-sm">${product.name}</p>
                                <p class="text-xs text-gray-600">SKU: ${product.sku || 'N/A'} | Stock: ${product.stock}</p>
                            </div>
                            <span class="font-bold text-indigo-600">$${parseFloat(product.price).toFixed(2)}</span>
                        </div>
                    `).join('');
                    });
            }, 300);
        });

        // Búsqueda de clientes
        let customerSearchTimeout;
        document.getElementById('customer-search').addEventListener('input', function () {
            clearTimeout(customerSearchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                document.getElementById('customer-results').innerHTML = '';
                return;
            }

            customerSearchTimeout = setTimeout(() => {
                fetch('{{ route('admin.pos.customers.search') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ query })
                })
                    .then(res => res.json())
                    .then(customers => {
                        const resultsDiv = document.getElementById('customer-results');
                        if (customers.length === 0) {
                            resultsDiv.innerHTML = '<p class="text-gray-500 text-sm">No se encontraron clientes</p>';
                            return;
                        }

                        resultsDiv.innerHTML = customers.map(customer => `
                        <div class="p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" onclick='selectCustomer(${JSON.stringify(customer)})'>
                            <p class="font-semibold text-sm">${customer.name}</p>
                            <p class="text-xs text-gray-600">${customer.email}</p>
                        </div>
                    `).join('');
                    });
            }, 300);
        });

        function selectCustomer(customer) {
            selectedCustomer = customer;
            document.getElementById('customer-name').textContent = customer.name;
            document.getElementById('customer-email').textContent = customer.email;
            document.getElementById('customer-rif').textContent = customer.rif ? `RIF: ${customer.rif}` : '';
            document.getElementById('selected-customer').classList.remove('hidden');
            document.getElementById('customer-search').value = '';
            document.getElementById('customer-results').innerHTML = '';
        }

        function clearCustomer() {
            selectedCustomer = null;
            document.getElementById('selected-customer').classList.add('hidden');
        }

        function addToCart(id, name, price, stock) {
            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                if (existingItem.quantity >= stock) {
                    showError(`Stock insuficiente para ${name}`);
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({ id, name, price, quantity: 1, stock });
            }

            document.getElementById('product-search').value = '';
            document.getElementById('product-results').innerHTML = '';
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function updateQuantity(id, quantity) {
            const item = cart.find(item => item.id === id);
            if (item) {
                if (quantity > item.stock) {
                    showError(`Stock insuficiente. Disponible: ${item.stock}`);
                    return;
                }
                if (quantity <= 0) {
                    removeFromCart(id);
                } else {
                    item.quantity = parseInt(quantity);
                    renderCart();
                }
            }
        }

        function renderCart() {
            const cartDiv = document.getElementById('cart-items');

            if (cart.length === 0) {
                cartDiv.innerHTML = '<p class="text-gray-500 text-center py-8">No hay productos en el carrito</p>';
                updateTotals();
                return;
            }

            cartDiv.innerHTML = cart.map(item => `
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div class="flex-1">
                        <p class="font-semibold text-sm">${item.name}</p>
                        <p class="text-xs text-gray-600">$${parseFloat(item.price).toFixed(2)} c/u</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="number" min="1" max="${item.stock}" value="${item.quantity}" 
                            onchange="updateQuantity(${item.id}, this.value)"
                            class="w-16 rounded border-gray-300 text-center">
                        <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');

            updateTotals();
        }

        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const taxes = subtotal * 0.16; // Simplificado, deberías calcular por producto
            let discount = 0;

            if (appliedCoupon) {
                // Simplificado - el backend calculará el descuento real
                discount = subtotal * 0.1; // Ejemplo
            }

            const total = subtotal + taxes - discount;

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('taxes').textContent = `$${taxes.toFixed(2)}`;
            document.getElementById('discount').textContent = `-$${discount.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;

            if (discount > 0) {
                document.getElementById('discount-row').style.display = 'flex';
            } else {
                document.getElementById('discount-row').style.display = 'none';
            }
        }

        function applyCoupon() {
            const code = document.getElementById('coupon-code').value.trim();
            if (!code) return;

            appliedCoupon = { code };
            document.getElementById('coupon-name').textContent = code;
            document.getElementById('coupon-applied').classList.remove('hidden');
            document.getElementById('coupon-code').value = '';
            updateTotals();
        }

        function removeCoupon() {
            appliedCoupon = null;
            document.getElementById('coupon-applied').classList.add('hidden');
            updateTotals();
        }

        function finalizeSale() {
            if (!selectedCustomer) {
                showError('Debe seleccionar un cliente');
                return;
            }

            if (cart.length === 0) {
                showError('Debe agregar al menos un producto');
                return;
            }

            const data = {
                customer_id: selectedCustomer.id,
                products: cart.map(item => ({ id: item.id, quantity: item.quantity })),
                payment_method: document.getElementById('payment-method').value,
                status: document.getElementById('order-status').value,
                coupon_code: appliedCoupon ? appliedCoupon.code : null
            };

            fetch('{{ route('admin.pos.orders.create') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        showSuccess(response.message);
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1500);
                    } else {
                        showError(response.message);
                    }
                })
                .catch(error => {
                    showError('Error al procesar la venta');
                });
        }

        function showSuccess(message) {
            document.getElementById('success-text').textContent = message;
            document.getElementById('success-message').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('success-message').classList.add('hidden');
            }, 5000);
        }

        function showError(message) {
            document.getElementById('error-text').textContent = message;
            document.getElementById('error-message').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('error-message').classList.add('hidden');
            }, 5000);
        }
    </script>
</x-app-layout>