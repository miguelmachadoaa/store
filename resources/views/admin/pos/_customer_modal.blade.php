<!-- Modal para Crear Cliente -->
<div id="customer-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Nuevo Cliente</h3>
            <button onclick="closeCustomerModal()" class="text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="customer-form" onsubmit="createCustomer(event)" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" id="new-customer-name" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" id="new-customer-email" required
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="text" id="new-customer-phone"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">RIF</label>
                <input type="text" id="new-customer-rif"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                <textarea id="new-customer-address" rows="3"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeCustomerModal()"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">
                    Cancelar
                </button>
                <button type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                    Crear Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCustomerModal() {
        document.getElementById('customer-modal').classList.remove('hidden');
    }

    function closeCustomerModal() {
        document.getElementById('customer-modal').classList.add('hidden');
        document.getElementById('customer-form').reset();
    }

    function createCustomer(event) {
        event.preventDefault();

        const data = {
            name: document.getElementById('new-customer-name').value,
            email: document.getElementById('new-customer-email').value,
            phone: document.getElementById('new-customer-phone').value,
            rif: document.getElementById('new-customer-rif').value,
            address: document.getElementById('new-customer-address').value
        };

        fetch('{{ route('admin.pos.customers.store') }}', {
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
                    selectCustomer(response.customer);
                    closeCustomerModal();
                    showSuccess(response.message);
                } else {
                    showError(response.message || 'Error al crear el cliente');
                }
            })
            .catch(error => {
                showError('Error al crear el cliente');
            });
    }
</script>