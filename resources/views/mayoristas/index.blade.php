@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-6xl">
        <!-- Encabezado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start mb-12">
            <div>
                <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-4">
                    PEDIDOS ESPECIALES Y AL POR MAYOR
                </h1>

                <p class="text-gray-700 mb-4 leading-relaxed">
                    ¿Buscas un detalle único, personalizado y de alta calidad en cantidades mayores?<br>
                    En <strong>Imani Magnets</strong> creamos imanes personalizados para empresas, fotógrafos, eventos y ocasiones especiales.
                </p>

                <div class="bg-[#E9E6DF] p-4 rounded-md mb-4">
                    <p class="text-dark-turquoise font-bold mb-2">Perfectos para:</p>
                    <ul class="list-disc list-inside text-gray-700 text-[17px]">
                        <li>Promocionar tu marca o negocio</li>
                        <li>Recordatorios de bodas, bautizos o cumpleaños</li>
                        <li>Merchandising, arte o fotografías</li>
                    </ul>
                </div>

                <p class="text-gray-700 mb-4">
                    Puedes enviarnos tu diseño o te ayudamos a crearlo.<br>
                    Solicita tu cotización y recibe el mejor precio y atención personalizada.
                </p>

                <p class="text-gray-700">
                    Contáctanos por formulario, WhatsApp o correo:<br>
                    <span class="text-dark-turquoise font-semibold">hello@imanimagnets.com</span>
                </p>
            </div>

            <!-- Imágenes en columna -->
            <div class="flex flex-col items-center gap-6">
                <div class="rounded-lg overflow-hidden shadow-md w-full max-w-sm">
                    <img
                        src="{{ asset('images/IMG-20251016-WA0028.jpg') }}"
                        alt="Imanes personalizados al por mayor"
                        class="w-full h-[350px] md:h-[300px] object-cover">
                </div>

                <div class="rounded-lg overflow-hidden shadow-md w-full max-w-sm">
                    <img
                        src="{{ asset('images/IMG-20251016-WA0032.jpg') }}"
                        alt="Ejemplo de imán personalizado"
                        class="w-full h-[350px] md:h-[300px] object-cover">
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-[#F9F8F5] border border-gray-300 rounded-lg shadow-sm p-8">
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-dark-turquoise font-semibold mb-1">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                    <div>
                        <label for="apellido" class="block text-dark-turquoise font-semibold mb-1">Apellido *</label>
                        <input type="text" id="apellido" name="apellido" placeholder="Apellido"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                </div>

                <!-- Correo y celular -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="correo" class="block text-dark-turquoise font-semibold mb-1">Correo *</label>
                        <input type="email" id="correo" name="correo" placeholder="ejemplo@mail.com"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                    <div>
                        <label for="celular" class="block text-dark-turquoise font-semibold mb-1">Celular *</label>
                        <input type="tel" id="celular" name="celular"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                    </div>
                </div>

                <!-- Cantidad -->
                <div>
                    <label for="cantidad" class="block text-dark-turquoise font-semibold mb-1">¿Cuántos imanes necesitas? *</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" placeholder="Ej. 100"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                </div>

                <!-- Fecha -->
                <div>
                    <label for="fecha" class="block text-dark-turquoise font-semibold mb-1">¿Para cuándo los necesitas? *</label>
                    <input type="date" id="fecha" name="fecha"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none">
                </div>

                <!-- Comentarios -->
                <div>
                    <label for="comentarios" class="block text-dark-turquoise font-semibold mb-1">Comentarios *</label>
                    <textarea id="comentarios" name="comentarios" rows="4" placeholder="Escribe aquí tus comentarios o requerimientos..."
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-gray-orange focus:outline-none"></textarea>
                </div>

                <!-- Botón -->
                <div class="text-center">
                    <button type="submit"
                        class="btn-primary inline-block px-8 md:px-10 py-3 md:py-4 bg-gray-orange hover:bg-[#a89980] text-white rounded-lg font-spartan font-semibold text-sm md:text-base tracking-wider uppercase">
                        ENVIAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection