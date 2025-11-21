<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class ContentPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'politica-cookies',
                'title' => 'Política de Cookies',
                'content' => '<h2>1. Introducción</h2>
<p>En <strong>Imani Magnets</strong> utilizamos cookies y tecnologías similares para mejorar la experiencia de nuestros usuarios, garantizar el correcto funcionamiento del sitio web y ofrecer contenidos y servicios personalizados.</p>
<p>Esta política explica qué son las cookies, qué tipo utilizamos, con qué finalidad y cómo podés gestionarlas.</p>

<h2>2. ¿Qué son las cookies?</h2>
<p>Las cookies son pequeños archivos que se almacenan en tu dispositivo (computadora, teléfono o tableta) cuando visitas un sitio web. Permiten que el sitio recuerde tus preferencias de navegación, sesiones iniciadas, idioma seleccionado, productos añadidos al carrito y otros datos útiles para mejorar tu experiencia.</p>

<h2>3. Tipos de cookies que utilizamos</h2>
<p><strong>Estrictamente necesarias:</strong> Permiten el funcionamiento básico del sitio (carrito, inicio de sesión, seguridad). Se eliminan al cerrar el navegador.</p>
<p><strong>De preferencia o personalización:</strong> Guardan tus preferencias de idioma, país o productos vistos recientemente. Conservación: hasta 6 meses.</p>
<p><strong>Analíticas o de rendimiento:</strong> Nos ayudan a entender cómo los usuarios usan el sitio (páginas más visitadas, tiempo, errores, etc.). Ejemplos: Google Analytics, Meta Pixel. Conservación: hasta 12 meses.</p>
<p><strong>Publicitarias o de marketing:</strong> Permiten mostrarte anuncios relevantes según tus intereses o interacción. Ejemplos: Meta (Facebook/Instagram), Google Ads. Conservación: hasta 12 meses.</p>
<p><strong>De terceros:</strong> Instaladas por servicios externos integrados (pasarelas de pago, mailing, redes sociales). Ejemplos: PayPhone, Mailchimp.</p>
<p>Las cookies esenciales se instalan automáticamente porque son necesarias para el correcto funcionamiento del sitio. Las cookies no esenciales (analíticas, publicitarias o de personalización) solo se usan con el <strong>consentimiento expreso del usuario</strong>.</p>

<h2>4. Base legal para el uso de cookies</h2>
<p>La instalación de cookies no esenciales se basa en el consentimiento previo y explícito del usuario. Este consentimiento puede ser retirado en cualquier momento mediante el panel de configuración o desde las opciones del navegador.</p>

<h2>5. Gestión y configuración de cookies</h2>
<p>Podés administrar tus preferencias en cualquier momento desde nuestro panel de configuración de cookies, disponible en el banner inicial o en el pie de página del sitio.</p>
<p>También podés configurar tu navegador para bloquear, eliminar o limitar las cookies. Tené en cuenta que desactivar algunas cookies puede afectar el funcionamiento o la experiencia del sitio.</p>

<h2>6. Cookies de terceros</h2>
<p>Nuestro sitio puede incluir contenidos o servicios de terceros, como botones de redes sociales, formularios o pasarelas de pago. Estos terceros pueden instalar sus propias cookies bajo sus políticas de privacidad.</p>

<h2>7. Cambios en la Política de Cookies</h2>
<p>Nos reservamos el derecho de modificar esta Política de Cookies en cualquier momento para adaptarla a cambios normativos o tecnológicos. Cualquier actualización será publicada en esta misma página con su fecha de entrada en vigor actualizada.</p>',
                'is_published' => true,
            ],
            [
                'slug' => 'politica-envios',
                'title' => 'Política de Envíos',
                'content' => '<h2>1. Cobertura</h2>
<p>Realizamos envíos únicamente dentro de Ecuador. No se realizan envíos internacionales.</p>

<h2>2. Costos de envío</h2>
<ul>
    <li>El costo del envío depende de la ubicación del cliente y se calculará automáticamente al momento de finalizar la compra en el carrito.</li>
    <li>En la página web podrán encontrarse promociones de envío gratis cuando se cumplan las condiciones indicadas en cada oferta.</li>
</ul>

<h2>3. Procesamiento y despacho</h2>
<ul>
    <li>Los pedidos se procesan en un plazo de 24 a 48 horas hábiles luego de la confirmación del pago.</li>
    <li>Los pedidos se despachan de lunes a viernes.</li>
    <li>Una vez despachado tu pedido, recibirás un número de guía o seguimiento, que puede tardar hasta 24 horas en estar disponible en el sistema del courier.</li>
</ul>

<h2>4. Tiempos de entrega</h2>
<ul>
    <li><strong>Ciudades principales:</strong> 2 a 3 días hábiles.</li>
    <li><strong>Zonas rurales:</strong> 4 a 6 días hábiles.</li>
</ul>

<h2>5. Responsabilidad de envío</h2>
<ul>
    <li>Una vez entregado el paquete al courier (Servientrega, Laars Courier u otros proveedores disponibles), la responsabilidad del transporte y los tiempos de entrega recae en dicha empresa.</li>
    <li>Recomendamos realizar el seguimiento de tu pedido mediante el número de guía proporcionado.</li>
</ul>

<h2>6. Pérdida o daño durante el envío</h2>
<ul>
    <li>En caso de pérdida del paquete durante el envío, solicitaremos la compensación correspondiente al courier y realizaremos un reenvío del producto sin costo adicional para el cliente.</li>
    <li>No ofrecemos seguro adicional; Imani Magnets gestionará la reposición únicamente si la pérdida o daño es confirmado por el courier.</li>
</ul>

<h2>7. Direcciones de entrega</h2>
<ul>
    <li>Los pedidos se entregan exclusivamente a domicilio.</li>
    <li>No se realizan envíos a oficinas de los couriers para retiro.</li>
</ul>',
                'is_published' => true,
            ],
            [
                'slug' => 'politica-privacidad',
                'title' => 'Política de Privacidad y Protección de Datos Personales',
                'content' => '<p>Bienvenido/a a <strong>Imani Magnets</strong>. La presente Política de Privacidad describe cómo recopilamos, utilizamos y protegemos la información personal que nos proporcionas a través de nuestro sitio web <a href="https://www.imanimagnets.com">www.imanimagnets.com</a> y otros canales de comunicación asociados. Al utilizar este sitio, aceptas las prácticas descritas en esta política.</p>

<h2>1. Identificación del responsable del tratamiento</h2>
<ul>
    <li><strong>Nombre comercial:</strong> Imani Magnets</li>
    <li><strong>Titular legal:</strong> Julia Schulz</li>
    <li><strong>RUC:</strong> 1761553880001</li>
    <li><strong>Ubicación:</strong> Cumbayá, Ecuador</li>
    <li><strong>Correo electrónico:</strong> <a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a></li>
    <li><strong>Sitio web:</strong> <a href="https://www.imanimagnets.com">www.imanimagnets.com</a></li>
</ul>

<h2>2. Principios del Tratamiento</h2>
<p>Imani Magnets realiza el tratamiento de datos personales conforme a los principios establecidos en la <strong>Ley Orgánica de Protección de Datos Personales (LOPDP)</strong> del Ecuador: Legalidad, Finalidad, Minimización, Transparencia, Calidad, Seguridad, Conservación limitada y Responsabilidad proactiva.</p>

<h2>3. Datos que Recolectamos</h2>
<ul>
    <li>Identificación y contacto: nombre, apellido, dirección, teléfono, correo electrónico.</li>
    <li>Datos fiscales: necesarios para emisión de facturas.</li>
    <li>Datos de pago: procesados de forma segura por plataformas como PayPhone.</li>
    <li>Imágenes o archivos personalizados enviados por el usuario para la fabricación de productos.</li>
    <li>Datos técnicos de navegación: dirección IP, tipo de navegador, sistema operativo.</li>
    <li>Mensajes o consultas enviadas a través de formularios de contacto o canales digitales.</li>
    <li>Datos para promociones o newsletter, únicamente con consentimiento previo.</li>
</ul>

<h2>4. Base Legal del Tratamiento</h2>
<ul>
    <li>Consentimiento informado otorgado por el titular.</li>
    <li>Ejecución de obligaciones contractuales derivadas de la compra o solicitud de productos.</li>
    <li>Cumplimiento de obligaciones legales o tributarias.</li>
    <li>Interés legítimo de Imani Magnets en la prevención de fraude, mejora del servicio o análisis estadístico.</li>
</ul>

<h2>5. Finalidades del Tratamiento</h2>
<ul>
    <li>Procesar y gestionar pedidos realizados en el sitio web.</li>
    <li>Emitir facturación electrónica conforme a la normativa del SRI.</li>
    <li>Enviar confirmaciones, actualizaciones o notificaciones de pedidos.</li>
    <li>Brindar atención al cliente, soporte o gestión de reclamos.</li>
    <li>Realizar comunicaciones comerciales y promocionales (solo con consentimiento expreso).</li>
    <li>Cumplir con obligaciones legales y de auditoría.</li>
    <li>Analizar el uso del sitio web para mejorar la experiencia del usuario.</li>
    <li>Prevenir fraudes o actividades ilícitas.</li>
</ul>

<h2>6. Conservación de Datos</h2>
<ul>
    <li>Imágenes y archivos personalizados: hasta 30 días después de la entrega del pedido.</li>
    <li>Datos de navegación: hasta 12 meses.</li>
    <li>Datos de facturación y transacciones: durante al menos 5 años (normativa tributaria).</li>
</ul>

<h2>7. Transferencia de Datos a Terceros</h2>
<p>Imani Magnets no vende ni cede información personal sin consentimiento. Los datos podrán compartirse solo con:</p>
<ul>
    <li>Hostinger (alojamiento web)</li>
    <li>PayPhone (procesamiento de pagos)</li>
    <li>Mailchimp (envío de correos y newsletters)</li>
    <li>Servientrega u otras empresas de mensajería (envíos y logística)</li>
</ul>
<p>Las transferencias internacionales se realizan únicamente hacia países que garanticen un nivel de protección adecuado o mediante contratos con estándares equivalentes de seguridad y confidencialidad.</p>

<h2>8. Seguridad</h2>
<ul>
    <li>Encriptación SSL/TLS en la navegación.</li>
    <li>Control de acceso restringido.</li>
    <li>Copias de seguridad y procedimientos de recuperación.</li>
    <li>Auditorías internas y capacitación del personal.</li>
    <li>Notificación de incidentes dentro de un plazo máximo de 5 días hábiles desde su detección.</li>
</ul>

<h2>9. Derechos del Titular de los Datos</h2>
<p>De acuerdo con la LOPDP, los titulares pueden ejercer sus derechos de Acceso, Rectificación, Eliminación, Oposición, Portabilidad, Suspensión y No ser objeto de decisiones automatizadas. Las solicitudes serán atendidas en un plazo máximo de 15 días hábiles, prorrogables por otros 15 conforme a la ley.</p>
<p>Para ejercerlos, escribí a <a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a> indicando tu nombre completo, número de identificación y solicitud específica.</p>

<h2>10. Consentimiento</h2>
<p>El uso del sitio implica el consentimiento expreso del usuario respecto al tratamiento de sus datos conforme a esta política. Para comunicaciones comerciales, se solicitará consentimiento específico que podrá revocarse en cualquier momento escribiendo a <a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a>.</p>

<h2>11. Cookies</h2>
<p>El sitio web utiliza cookies esenciales y no esenciales. Las cookies no esenciales requieren consentimiento previo. Puedes configurar tu navegador para deshabilitarlas. Para más detalles, consultá nuestra Política de Cookies.</p>

<h2>12. Vigencia y Modificaciones</h2>
<p>Esta Política de Privacidad estará vigente mientras Imani Magnets realice el tratamiento de datos personales. Cualquier modificación será publicada en esta misma página con su fecha de entrada en vigor actualizada.</p>

<h2>13. Cumplimiento y Procedimientos Internos</h2>
<p>Imani Magnets implementará mecanismos internos que garanticen la correcta gestión de datos personales conforme a la LOPDP, incluyendo registro de actividades, gestión de incidentes y atención de solicitudes.</p>

<h2>14. Datos de Menores</h2>
<p>No recolectamos intencionalmente datos de menores sin consentimiento de sus representantes legales. Si identificamos información sin autorización, será eliminada inmediatamente.</p>

<h2>15. Autoridad de Control y Reclamos</h2>
<p>Si consideras que tus derechos no han sido atendidos, podés presentar una reclamación ante la autoridad nacional competente en materia de protección de datos personales.</p>

<h2>16. Cambios en esta Política</h2>
<p>Nos reservamos el derecho de actualizar esta Política de Privacidad en cualquier momento. Cualquier modificación se publicará en esta misma página con la fecha correspondiente.</p>
<p><strong>Imani Magnets</strong><br>Cumbayá, Ecuador<br><a href="https://www.imanimagnets.com">www.imanimagnets.com</a><br><a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a></p>',
                'is_published' => true,
            ],
            [
                'slug' => 'terminos-condiciones',
                'title' => 'Términos y Condiciones de Uso',
                'content' => '<h2>Titularidad del sitio web</h2>
<p>El presente sitio web, accesible a través de la dirección <a href="https://www.imanimagnets.com">www.imanimagnets.com</a>, es operado bajo el nombre comercial <strong>Imani Magnets</strong>, cuyo titular legal es <strong>Julia Schulz</strong>, con domicilio en Cumbayá, Quito, Ecuador, y correo electrónico de contacto <a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a>.</p>
<p>El uso de este sitio web implica la aceptación expresa de los presentes Términos y Condiciones. Recomendamos a nuestros clientes y visitantes leerlos detenidamente antes de realizar cualquier compra o utilizar los servicios disponibles.</p>

<h2>1. Objeto</h2>
<p>Este sitio web permite la compra de imanes personalizados y colecciones prediseñadas ofrecidas por <strong>Imani Magnets</strong>.</p>

<h2>2. Uso del sitio</h2>
<p>El usuario declara que toda la información proporcionada al momento de registrarse o realizar una compra es verdadera, exacta y actualizada. Asimismo, se compromete a no utilizar el sitio con fines ilícitos, fraudulentos o contrarios a la buena fe.</p>

<h2>3. Productos personalizados</h2>
<p>Los pedidos que incluyan imágenes o diseños cargados por el cliente se consideran <strong>productos personalizados</strong>. Estos no podrán ser devueltos ni reembolsados, salvo por defectos de fabricación o errores atribuibles a <strong>Imani Magnets</strong>.</p>
<p>El cliente es responsable de la calidad, resolución y derechos de uso de las imágenes que cargue en la plataforma.</p>

<h2>4. Precios y pagos</h2>
<p>Todos los precios publicados en el sitio web incluyen los impuestos aplicables conforme a la legislación ecuatoriana. Los pagos se realizan a través de plataformas seguras de terceros, tales como tarjetas de crédito, transferencias bancarias u otros medios habilitados. El procesamiento del pago se considera una condición indispensable para iniciar la producción del pedido.</p>

<h2>5. Entregas y envíos</h2>
<p>Los envíos se realizan únicamente dentro de Ecuador mediante couriers locales. Una vez procesado el pedido, el cliente recibirá un número de guía para el seguimiento de su paquete.</p>
<ul>
    <li><strong>Plazo de entrega en ciudades principales:</strong> entre 2 y 3 días hábiles.</li>
    <li><strong>Plazo de entrega en ciudades secundarias:</strong> entre 4 y 6 días hábiles.</li>
</ul>
<p>Los tiempos de entrega son referenciales y pueden variar por causas externas ajenas a <strong>Imani Magnets</strong>. La responsabilidad del transporte recae en el proveedor logístico una vez entregado el paquete.</p>

<h2>6. Política de devoluciones y cambios</h2>
<p><strong>Imani Magnets</strong> acepta devoluciones únicamente en los siguientes casos:</p>
<ul>
    <li>El producto recibido presenta defectos de fabricación.</li>
    <li>El pedido recibido no corresponde al solicitado.</li>
</ul>
<p>En estos casos, el cliente deberá notificar a <a href="mailto:hello@imanimagnets.com">hello@imanimagnets.com</a> dentro de los <strong>5 días hábiles posteriores</strong> a la recepción del pedido, adjuntando fotografías que evidencien el problema.</p>
<p>Una vez revisada la solicitud, se informará al cliente si procede la devolución, el cambio o la reposición del producto.</p>
<p><strong>Quedan excluidos de esta política:</strong></p>
<ul>
    <li>Productos personalizados con imágenes o diseños cargados por el cliente, salvo que exista un defecto de producción.</li>
    <li>Daños ocasionados por uso indebido, manipulación inadecuada o causas externas al proceso de fabricación y envío.</li>
</ul>
<p>En caso de aprobación, el cliente recibirá nuevamente el producto sin costo adicional.</p>

<h2>7. Limitación de responsabilidad</h2>
<p><strong>Imani Magnets</strong> no será responsable por daños o perjuicios derivados del uso indebido del sitio web, interrupciones técnicas, fallas de internet, ni por retrasos o incumplimientos atribuibles a terceros proveedores de servicios logísticos o de pago.</p>

<h2>8. Propiedad intelectual</h2>
<p>Todos los contenidos del sitio web, incluyendo textos, imágenes, logotipos, plantillas y diseños, son propiedad exclusiva de <strong>Imani Magnets</strong> o cuentan con autorización expresa de sus titulares. Está prohibida su reproducción, distribución o uso sin consentimiento previo por escrito.</p>

<h2>9. Modificaciones</h2>
<p><strong>Imani Magnets</strong> se reserva el derecho de actualizar, modificar o sustituir los presentes Términos y Condiciones en cualquier momento. Las modificaciones entrarán en vigor a partir de su publicación en <a href="https://www.imanimagnets.com">www.imanimagnets.com</a>. El uso continuado del sitio tras dichos cambios constituye la aceptación expresa de los nuevos términos por parte del usuario.</p>',
                'is_published' => true,
            ],
        ];

        $this->command->info('Seeding content pages...');

        foreach ($pages as $page) {
            ContentPage::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
            $this->command->line("  ✓ {$page['title']}");
        }

        $this->command->info('✓ Successfully seeded ' . count($pages) . ' content pages!');
    }
}
