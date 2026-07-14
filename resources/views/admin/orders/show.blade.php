<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de la Órden #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-md text-sm transition">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Mensajes de Estado del Sistema -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Cuadrícula Principal de Información -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Columna Izquierda: Detalles Generales de la Orden (Ocupa 2/3 en pantallas grandes) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Bloque: Información Base -->
                    <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">📦 Información del Pedido</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500 font-medium">Fecha de Registro</p>
                                <p class="text-gray-900 font-semibold mt-0.5">{{ $order->created_at->format('d/m/Y H:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">Método de Pago Seleccionado</p>
                                <p class="text-gray-900 font-semibold mt-0.5 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 font-medium">Dirección de Entrega / Envío</p>
                                <p class="text-gray-900 font-semibold mt-0.5">{{ $order->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Tabla de Productos Comprados -->
                    <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">🛒 Productos Incluidos</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Producto</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase text-xs">Cantidad</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase text-xs">Precio Unitario</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase text-xs">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 font-medium text-gray-900">
                                                {{ $item->product_name ?? 'Producto #' . $item->product_id }}
                                                @if($item->variant_name)
                                                    <span class="block text-xs text-gray-400 font-normal">Variante: {{ $item->variant_name }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center text-gray-700 font-semibold">{{ $item->quantity }}</td>
                                            <td class="px-4 py-4 text-right text-gray-700">${{ number_format($item->price, 2) }}</td>
                                            <td class="px-4 py-4 text-right font-semibold text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Cliente, Totales y Gestión de Estado (Ocupa 1/3) -->
                <div class="space-y-6">
                    
                    <!-- Bloque: Datos de Cliente -->
                    <!-- Bloque: Datos de Cliente -->
                    <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">👤 Datos del Cliente</h3>
                        <div class="text-sm space-y-3">
                            <div>
                                <span class="text-gray-500 font-medium block">Nombre completo</span>
                                <span class="text-gray-900 font-semibold">{{ $order->customer_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-medium block">Cédula / RIF</span>
                                <span class="text-gray-900 font-semibold">{{ $order->customer_rif ?? 'No registrado' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-medium block">Correo electrónico</span>
                                <span class="text-indigo-600 font-semibold break-all">{{ $order->customer_email }}</span>
                            </div>
                            
                            <!-- Campo de Teléfono con enlace a WhatsApp -->
                            <div>
                                <span class="text-gray-500 font-medium block">Teléfono</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-gray-900 font-semibold">
                                        {{ $order->user->phone ?? 'No registrado' }}
                                    </span>
                                    @if($whatsappUrl)
                                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" 
                                        class="inline-flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 font-bold px-2 py-0.5 rounded text-xs transition border border-green-200"
                                        title="Chatear por WhatsApp">
                                        💬 WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Control de Estado de la Orden -->
                    <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 border-b pb-2">⚙️ Estado de la Orden</h3>
                        
                        <div class="mb-4">
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 block mb-1">Estado actual</span>
                            <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full {{ $order->status_badge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-3 border-t pt-3">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="status" class="block text-xs font-medium text-gray-700 uppercase mb-1">Cambiar Estado</label>
                                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <option value="pendiente" {{ $order->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="pagada" {{ $order->status == 'pagada' ? 'selected' : '' }}>Pagada</option>
                                    <option value="enviada" {{ $order->status == 'enviada' ? 'selected' : '' }}>Enviada</option>
                                    <option value="cancelada" {{ $order->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md text-sm transition shadow-sm">
                                Actualizar Estado
                            </button>
                        </form>
                    </div>

                    <!-- Bloque: Resumen Financiero -->
                    <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">💰 Resumen de Caja</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Base Imponible:</span>
                                <span>${{ number_format($order->taxable_base ?? $order->total / 1.16, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>IVA (16%):</span>
                                <span>${{ number_format($order->tax_amount ?? ($order->total - ($order->total / 1.16)), 2) }}</span>
                            </div>
                            
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between text-green-600 font-medium">
                                    <span>Descuento aplicado:</span>
                                    <span>-${{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between border-t pt-2 text-base font-bold text-gray-900">
                                <span>Total Neto:</span>
                                <span>${{ number_format($order->total, 2) }}</span>
                            </div>

                            <!-- Equivalencia Cambiaria Local -->
                            <div class="bg-gray-50 p-3 rounded-lg mt-3 space-y-1 text-xs border border-gray-100">
                                <div class="flex justify-between text-gray-700 font-bold text-sm">
                                    <span>Total en Bolívares:</span>
                                    <span>Bs. {{ number_format($order->total_bs, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-400">
                                    <span>Tasa de cambio de referencia:</span>
                                    <span>Bs. {{ number_format($order->exchange_rate, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- SECCIÓN NUEVA: Historial de Pagos Reportados por el Usuario -->
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    💳 Pagos Reportados para esta Orden
                </h3>

                @if($order->paymentReports && $order->paymentReports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Banco de Origen</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nro. Referencia</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Monto en Bs.</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fecha Ejecución</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Soporte Digital</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Validación</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->paymentReports as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $payment->bank_name }}</td>
                                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $payment->reference_number }}</td>
                                        <td class="px-4 py-3 font-semibold text-gray-900">Bs. {{ number_format($payment->amount_bs, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if($payment->proof_image)
                                                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center gap-0.5">
                                                    Ver Captura ↗
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">Sin adjunto</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full 
                                                {{ $payment->status === 'approved' ? 'bg-green-100 text-green-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                @if($payment->status === 'approved') Aprobado @elseif($payment->status === 'rejected') Rechazado @else Pendiente @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 text-sm border border-dashed border-gray-200">
                        Esta orden aún no cuenta con ningún reporte de pago asociado en la plataforma.
                    </div>
                @endif
            </div>

          <!-- SECCIÓN NUEVA: Historial de Pagos Reportados por el Usuario -->
            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    💳 Pagos Reportados para esta Orden
                </h3>

                @if($order->paymentReports && $order->paymentReports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Banco de Origen</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nro. Referencia</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Monto en Bs.</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fecha Ejecución</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Soporte Digital</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Validación</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->paymentReports as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $payment->bank_name }}</td>
                                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $payment->reference_number }}</td>
                                        <td class="px-4 py-3 font-semibold text-gray-900">Bs. {{ number_format($payment->amount_bs, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            @if($payment->proof_image)
                                                {{-- Cambio a URL del disco r2 --}}
                                                <a href="{{ Storage::disk('r2')->url($payment->proof_image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center gap-0.5">
                                                    Ver Captura ↗
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">Sin adjunto</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full 
                                                {{ $payment->status === 'approved' ? 'bg-green-100 text-green-800' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                @if($payment->status === 'approved') Aprobado @elseif($payment->status === 'rejected') Rechazado @else Pendiente @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 text-center text-gray-500 text-sm border border-dashed border-gray-200">
                        Esta orden aún no cuenta con ningún reporte de pago asociado en la plataforma.
                    </div>
                @endif
            </div>

            <!-- SECCIÓN NUEVA: Comentarios y Seguimiento Post-Venta -->    

            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">💬 Comentarios y Seguimiento Post-Venta</h3>

                <!-- Formulario para agregar nuevo comentario -->
                <form action="{{ route('admin.orders.comments.store', $order) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comentario / Nota interna</label>
                            <textarea name="comment" rows="3" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 placeholder-gray-400"
                                placeholder="Ej: Se envió por DHL, el cliente solicitó empaque especial o adjunto foto de la guía..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto de la guía u otro adjunto (Opcional)</label>
                            <input type="file" name="photo" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition shadow">
                                Guardar Comentario
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="border-gray-200 my-4">

                <!-- Listado de comentarios agregados -->
                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @forelse($order->comments as $comment)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="space-y-1 flex-1">
                                <p class="text-gray-700 whitespace-pre-line text-sm">{{ $comment->comment }}</p>
                                <span class="block text-xs text-gray-400">
                                    Publicado el {{ $comment->created_at->format('d/m/Y h:i A') }}
                                </span>
                            </div>

                            @if($comment->file_path)
                                <div class="w-24 h-24 flex-shrink-0 relative group cursor-pointer">
                                    {{-- Cambio a URL del disco r2 en los enlaces e imágenes --}}
                                    <a href="{{ Storage::disk('r2')->url($comment->file_path) }}" target="_blank" title="Ver imagen completa">
                                        <img src="{{ Storage::disk('r2')->url($comment->file_path) }}" 
                                            alt="Guía o evidencia" 
                                            class="w-full h-full object-cover rounded-lg border border-gray-200 shadow-sm transition transform hover:scale-105">
                                        <span class="absolute bottom-1 right-1 bg-black bg-opacity-60 text-white text-[10px] px-1 rounded">🔎 Ver</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No hay comentarios post-venta registrados para esta orden.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>