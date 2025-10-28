@extends('layouts.app')

@section('content')
<section class="bg-white py-12 md:py-16">
    <div class="container mx-auto px-6 max-w-4xl text-gray-800 leading-relaxed">
        
        <!-- Título -->
        <h1 class="text-3xl md:text-4xl font-spartan font-bold text-dark-turquoise mb-4">
            POLÍTICA DE ENVÍOS
        </h1>

        <p class="italic text-gray-600 mb-10">
            Última actualización: Octubre 2025
        </p>

        <!-- Contenido -->
        <div class="space-y-8 text-[17px]">
            <!-- 1. Cobertura -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">1. Cobertura</h2>
                <p>
                    Realizamos envíos únicamente dentro de Ecuador. No se realizan envíos internacionales.
                </p>
            </div>

            <!-- 2. Costos de envío -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">2. Costos de envío</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li>El costo del envío depende de la ubicación del cliente y se calculará automáticamente al momento de finalizar la compra en el carrito.</li>
                    <li>En la página web podrán encontrarse promociones de envío gratis cuando se cumplan las condiciones indicadas en cada oferta.</li>
                </ul>
            </div>

            <!-- 3. Procesamiento y despacho -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">3. Procesamiento y despacho</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li>Los pedidos se procesan en un plazo de 24 a 48 horas hábiles luego de la confirmación del pago.</li>
                    <li>Los pedidos se despachan de lunes a viernes.</li>
                    <li>Una vez despachado tu pedido, recibirás un número de guía o seguimiento, que puede tardar hasta 24 horas en estar disponible en el sistema del courier.</li>
                </ul>
            </div>

            <!-- 4. Tiempos de entrega -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">4. Tiempos de entrega</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Ciudades principales:</strong> 2 a 3 días hábiles.</li>
                    <li><strong>Zonas rurales:</strong> 4 a 6 días hábiles.</li>
                </ul>
            </div>

            <!-- 5. Responsabilidad de envío -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">5. Responsabilidad de envío</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li>Una vez entregado el paquete al courier (Servientrega, Laars Courier u otros proveedores disponibles), la responsabilidad del transporte y los tiempos de entrega recae en dicha empresa.</li>
                    <li>Recomendamos realizar el seguimiento de tu pedido mediante el número de guía proporcionado.</li>
                </ul>
            </div>

            <!-- 6. Pérdida o daño durante el envío -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">6. Pérdida o daño durante el envío</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li>En caso de pérdida del paquete durante el envío, solicitaremos la compensación correspondiente al courier y realizaremos un reenvío del producto sin costo adicional para el cliente.</li>
                    <li>No ofrecemos seguro adicional; Imani Magnets gestionará la reposición únicamente si la pérdida o daño es confirmado por el courier.</li>
                </ul>
            </div>

            <!-- 7. Direcciones de entrega -->
            <div>
                <h2 class="font-semibold text-dark-turquoise mb-2">7. Direcciones de entrega</h2>
                <ul class="list-disc list-inside space-y-1">
                    <li>Los pedidos se entregan exclusivamente a domicilio.</li>
                    <li>No se realizan envíos a oficinas de los couriers para retiro.</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
