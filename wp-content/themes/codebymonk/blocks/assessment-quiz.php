<?php
/**
 * Block Name: Assessment Quiz
 * Class: block-assessment-quiz
 */

$blockClasses = ['block-assessment-quiz', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('quiz_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'quiz';

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

$currentLang = function_exists('apply_filters') ? apply_filters('wpml_current_language', null) : (defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
$isSpanish = ($currentLang === 'es');

$introKicker = get_field('intro_kicker') ?: ($isSpanish ? 'Gratis · dos minutos' : 'Free · two minutes');
$introTitle = get_field('intro_title') ?: ($isSpanish ? 'Veinte preguntas' : 'Twenty questions');
$introDesc = get_field('intro_desc') ?: ($isSpanish ? 'No hay respuestas correctas. Nadie más verá esto. Pedimos tu correo al final, no ahora.' : 'No right answers. Nobody else sees this. We ask for your email at the end, not now.');
$btnText = get_field('start_button_text') ?: ($isSpanish ? 'Comenzar' : 'Start');
$reportBtnText = get_field('report_btn_text') ?: ($isSpanish ? 'Obtener mi Perfil de Salud Financiera' : 'Get my Financial Health Profile');
$reportBtnLink = get_field('report_btn_link');
if (empty($reportBtnLink) || $reportBtnLink === '/finance/' || $reportBtnLink === '/es/finance/') {
    $reportBtnLink = $isSpanish ? home_url('/es/perfil-financiero/') : home_url('/finance/');
}
$sessionBtnLink = get_field('session_btn_link');
if (empty($sessionBtnLink)) {
    $sessionBtnLink = add_query_arg('package', 'session', $reportBtnLink);
}

$spanishQuizData = [
  'isSpanish' => $isSpanish,
  'lang'      => $isSpanish ? 'es' : 'en',
  'questions' => [
    ['a' => 'Life & Skills', 'ab' => 'Producir', 't' => '¿Completas tus actividades con rapidez?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Enfocar', 't' => '¿Estás posicionado para el éxito?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Percibes los juegos o intenciones de otras personas?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Conduces un automóvil de lujo?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Enfocar', 't' => '¿Tu futuro es incierto?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Producir', 't' => '¿Te gusta tener mucha acción y actividad?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Te endeudas al final del año?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Tiendes a percibir erróneamente a las personas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Viajas en clase económica en lugar de primera clase?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Estás inseguro sobre tus deseos materiales?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Desearías estar viviendo el sueño que anhelas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Producir', 't' => '¿Tu carrera se ha convertido en menos de lo que deseabas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Desearías haber actuado más rápido en el pasado?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Invertir', 't' => '¿Tu carrera te brindará riqueza en el futuro?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Enfocar', 't' => '¿Siempre te esfuerzas por ser lo mejor que puedes ser?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Te desagradan las personas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Tomas acciones concretas para elevar tu nivel de juego?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Sientes que sabes más que otros, incluso que aquellos con más éxito que tú?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Enfocar', 't' => '¿Prefieres quedarte cerca de casa durante las vacaciones?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Enfocar', 't' => '¿Te distraes con facilidad?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
  ],
  'zones' => [
    1 => ['n' => 'Roja', 'i' => 1, 'col' => 'var(--red)'],
    2 => ['n' => 'Amarilla', 'i' => 2, 'col' => '#B98F0C'],
    3 => ['n' => 'Verde', 'i' => 3, 'col' => 'var(--shgreen)'],
    4 => ['n' => 'Magia Dorada', 'i' => 4, 'col' => '#8A7440'],
  ],
  'copy' => [
    'Roja'         => 'Esta es una persona que está en el lugar equivocado en el momento equivocado, conectada con las personas equivocadas. El esfuerzo produce poco, porque estás reaccionando a lo que sucede en lugar de dirigirlo.',
    'Amarilla'     => 'Esta es la “rutina diaria” o “estancamiento” donde la persona no toma riesgos sino que trabaja solo por seguridad. Despierto, pero el cambio aún depende de cómo te sientas ese día.',
    'Verde'        => 'Esta es una persona que está en el lugar correcto en el momento correcto, haciendo que las cosas salgan bien. Esta persona está viviendo su sueño. Los resultados llegan de manera consistente porque la estructura los sostiene, no la fuerza de voluntad.',
    'Magia Dorada' => 'Estás fuera del universo físico. Operas por encima de las leyes del universo físico y con claridad total. Maestría en tu Zona de manera confiable.',
  ],
  'ability_quotes' => [
    'Tener'         => 'Puedes ganar más y seguir sin nada: si no te sientes con derecho a conservarlo, el dinero encuentra la salida solo.',
    'Investigar'    => 'Las decisiones caras casi nunca se toman por falta de dinero, sino por falta de preguntas antes de firmar.',
    'Enfocar'       => 'Tu atención está repartida en tantos frentes que ninguno alcanza el punto donde empieza a dar resultados.',
    'Invertir'      => 'Tu tiempo, tu energía y tu dinero ya están invertidos en algo. La pregunta es si eso te está devolviendo algo.',
    'Producir'      => 'Estás ocupado casi todo el día y aun así cuesta trabajo señalar qué produjiste esta semana.',
    'Crear riqueza' => 'No se entrena sola: es el promedio de las otras cinco y te muestra el resultado de todas juntas.',
  ],
  'have_levels' => [
    'low_yellow' => [
      'name'  => 'Trabajando para no tener',
      'title' => 'Nivel: Trabajando para no tener',
      'short' => 'Tu resultado quedó por debajo de la línea central de la Zona Amarilla: hoy estás trabajando para no tener. No es falta de esfuerzo. Es un proceso negativo que te aleja de lo que quieres, aunque lo estés persiguiendo, y se puede cambiar.',
      'full'  => 'TRABAJANDO PARA NO TENER. Si tu resultado está por debajo de la línea central oscura que recorre horizontalmente la Zona Amarilla, esto significa que estás trabajando "para no tener". La mayoría de las personas NO PUEDEN TENER. No importa si lo tienen físicamente... no pueden tenerlo de verdad. No se sienten lo suficientemente valiosos. No se sienten lo suficientemente buenos. Sienten que no deberían obtener lo que están intentando alcanzar y sienten que no lo merecen. Por lo general, han sido programados con mensajes como "no vales nada" o "no sirves para nada". Eso es el resultado de mucho procesamiento negativo que hace que la persona se sienta así. El proceso negativo básico que está gobernando sus vidas es: "No puedes ser esto, no puedes hacer esto, no puedes tener esto. No puedes tener tus sueños. No puedes ser, no puedes hacer y no puedes tener". PROCESO NEGATIVO: es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar. Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.'
    ],
    'high_yellow' => [
      'name'  => 'Batallando para tener',
      'title' => 'Nivel: Batallando para tener',
      'short' => 'Tu resultado quedó en la parte alta de la Zona Amarilla: estás batallando para tener. Avanzas, pero cada logro te cuesta más de lo que debería, porque sigues cargando reglas aprendidas sobre lo que no se puede o no se debe.',
      'full'  => 'BATALLANDO PARA TENER. Si tu resultado está por encima de la línea central oscura que recorre horizontalmente la Zona Amarilla, pero aún dentro de la Zona Amarilla, significa que estás batallando "para tener". La vida, la familia, tus padres o los grupos te han procesado negativamente diciéndote lo que no se puede hacer, por qué no se puede hacer y lo que no debe hacerse. En este tipo de entornos, las personas utilizan el poder o las fuerzas externas para dictar lo que es correcto y cómo se debe actuar o comportar. PROCESO NEGATIVO: es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar. Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.'
    ],
    'green' => [
      'name'  => 'Tienes la capacidad para tener',
      'title' => 'Nivel: Tienes la capacidad para tener',
      'short' => 'Tu resultado quedó en la Zona Verde: tienes la capacidad para tener. Tu entorno trabaja a tu favor y has recibido procesos positivos. El siguiente paso es hacer más de lo que ya te funciona para expandir tu juego.',
      'full'  => 'TIENES LA CAPACIDAD PARA TENER. ¡Felicidades! Si tu resultado está en la Zona Verde, tienes la capacidad para "tener"; cuanto más alto estés en la Zona Verde, mayor será tu capacidad para tener todo lo que deseas. Tu entorno trabaja contigo constantemente en armonía y has recibido muchos procesos positivos. PROCESO POSITIVO: es una serie de acciones positivas, cambios o funciones que te llevan a lograr el resultado o propósito positivo que te has propuesto. Es un movimiento continuo y ascendente en la dirección que tú decidiste seguir. También puede definirse como una serie de acciones honestas, con integridad, alineadas con tus metas y propósitos, que dan lugar a ciclos de operación que culminan en un producto o resultado final positivo y óptimo. Recuerda que hay dos cosas que debes tener para volverte rico: la primera es la disciplina y la segunda es la duplicación. Si tienes esas dos cosas, puedes tener éxito en cualquier momento. Si estás en la Zona Verde, ¡tienes la habilidad para tener! Haz más de las acciones exitosas que ya estás ejecutando para expandir tu juego.'
    ]
  ],
  'labels' => [
    'area'          => 'Área: ',
    'you_are_in'    => 'Estás en la Zona ',
    'you_are_here'  => ' · tú estás aquí',
    'start_here'    => ' · comienza aquí',
    'privacy_error' => 'Por favor acepta la Política de Privacidad para ver tu resultado.',
    'email_error'   => 'Por favor ingresa un correo electrónico válido.',
    'phone_error'   => 'Por favor ingresa un número de teléfono o WhatsApp válido.',
    'email_sent'    => '✓ Tu resultado ha sido enviado a tu correo.',
    'gap_template'  => 'Tener es una de las seis habilidades que forman tu salud financiera. Las otras cinco son Producir, Enfocar, Investigar, Invertir y Crear riqueza. Tu Perfil de Salud Financiera mide las seis, te muestra cuál te está frenando más y te da con qué trabajarla.',
    'area_names'    => [
      'Financial'     => 'Financiero',
      'Life & Skills' => 'Vida y Habilidades',
      'Body'          => 'Cuerpo',
    ]
  ]
];
?>
<script>
window.zolQuizData = <?= json_encode($spanishQuizData); ?>;
</script>

<section id="<?= esc_attr($blockID); ?>" data-block="assessment-quiz" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap qwrap">
    
    <!-- Screen 1: Intro -->
    <div id="quizIntro" class="quiz-screen">
      <div class="kicker" style="color:var(--shgreen)"><?= esc_html($introKicker); ?></div>
      <h1 class="mt16"><?= esc_html($introTitle); ?></h1>
      <p class="lede mt16"><?= esc_html($introDesc); ?></p>
      <button type="button" class="btn btn-go btn-block mt32" id="startQuiz"><?= esc_html($btnText); ?></button>
    </div>

    <!-- Screen 2: Running Quiz (20 Questions) -->
    <div id="quizRun" class="quiz-screen" hidden>
      <div class="hgroup" style="justify-content:space-between">
        <span class="tiny" id="qArea"><?= $isSpanish ? 'Área' : 'Area'; ?></span>
        <span class="tiny" id="qCount">1 / 20</span>
      </div>
      <div class="progress" id="qBar"></div>
      <h2 id="qText" class="mt16" style="min-height:74px"></h2>
      <div class="stack mt24" id="qOpts"></div>
      <div class="hgroup mt32" style="justify-content:space-between;align-items:center;">
        <button type="button" class="btn btn-ghost btn-sm" id="qBack"><?= $isSpanish ? 'Atrás' : 'Back'; ?></button>
        <span class="tiny text-muted"><?= $isSpanish ? 'Respuestas guardadas automáticamente' : 'Answers saved automatically'; ?></span>
      </div>
    </div>

    <!-- Screen 3: Email & WhatsApp Gate -->
    <div id="quizGate" class="quiz-screen" hidden>
      <div class="kicker" style="color:var(--shgreen)"><?= $isSpanish ? 'Casi listo' : 'Almost there'; ?></div>
      <h1 class="mt16"><?= $isSpanish ? '¿A dónde enviamos tu resultado?' : 'Where should we send your result?'; ?></h1>
      <p class="lede mt16"><?= $isSpanish ? 'También lo verás en la siguiente pantalla. El correo y WhatsApp son para que puedas guardar y consultar tu resultado.' : 'You will see it on the next screen too. The email and WhatsApp are so you can save and review your result.'; ?></p>
      
      <div class="card pad-lg mt32">
        <div class="field">
          <label for="gName"><?= $isSpanish ? 'Nombre' : 'First name'; ?></label>
          <input class="input" id="gName" placeholder="<?= $isSpanish ? 'Tu nombre' : 'Jane'; ?>" required>
        </div>
        <div class="field">
          <label for="gMail"><?= $isSpanish ? 'Correo electrónico' : 'Email'; ?></label>
          <input class="input" type="email" id="gMail" placeholder="<?= $isSpanish ? 'tu@correo.com' : 'jane@example.com'; ?>" required>
        </div>
        <div class="field">
          <label for="gPhone"><?= $isSpanish ? 'WhatsApp / Teléfono' : 'WhatsApp / Phone'; ?></label>
          <input class="input" type="tel" id="gPhone" placeholder="<?= $isSpanish ? '+52 55 1234 5678' : '+1 469 123 4567'; ?>" required>
        </div>
        <label class="xs" style="display:flex;gap:9px;align-items:flex-start;margin-top:16px;">
          <input type="checkbox" id="gOk" style="margin-top:3px" checked> 
          <?= $isSpanish ? 'Acepto la Política de Privacidad y recibir mi resultado por correo.' : 'I agree to the Privacy Policy and to receiving my result by email.'; ?>
        </label>
        <label class="xs" style="display:flex;gap:9px;align-items:flex-start;margin-top:10px;">
          <input type="checkbox" id="gWaOptin" style="margin-top:3px" checked> 
          <?= $isSpanish ? 'Acepto recibir mi resultado y seguimiento por WhatsApp.' : 'I agree to receive my result and follow-up updates via WhatsApp.'; ?>
        </label>
        <div id="quizGateError" class="xs mt8" style="color:var(--red);display:none;"></div>
        <button type="button" class="btn btn-go btn-block mt24" id="gGo"><?= $isSpanish ? 'Ver mi resultado' : 'See my result'; ?></button>
      </div>
    </div>

    <!-- Screen 4: Result (Mini Perfil con Gráfica de Zonas) -->
    <div id="quizResult" class="quiz-screen" hidden>
      <div class="split top result-grid">
        <!-- Left Column: Result & Breakdown -->
        <div class="result-main">
          <div class="kicker" style="color:var(--shgreen)"><?= $isSpanish ? 'Tu resultado · Mini Perfil' : 'Your result · Mini Profile'; ?></div>
          
          <h1 class="mt16" id="rZone" style="line-height:1.2;"></h1>
          
          <div class="mt24" id="rBar"></div>
          <div class="zlabels">
            <span class="tiny"><?= $isSpanish ? 'Roja' : 'Red'; ?></span>
            <span class="tiny" id="rHere"></span>
            <span class="tiny"><?= $isSpanish ? 'Verde' : 'Green'; ?></span>
            <span class="tiny"><?= $isSpanish ? 'Magia Dorada' : 'Golden'; ?></span>
          </div>

          <p class="lede mt24" id="rBody"></p>
          
          <hr class="rule mt32 mb32">

          <!-- Have Ability Level Card (R1) -->
          <div class="card pad-md mb28" id="rLevelCard" style="background:#FFFBF2;border:1px solid #F5E5C9;border-left:4px solid var(--fuego);border-radius:8px;">
            <div class="hgroup" style="justify-content:space-between;align-items:center;margin-bottom:8px;">
              <span class="tiny" style="font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--muted);"><?= $isSpanish ? 'Diagnóstico de tu Nivel en Tener' : 'Your Have Level Diagnosis'; ?></span>
              <span id="rLevelBadge" class="tiny" style="font-weight:700;padding:3px 10px;border-radius:4px;background:#FDE68A;color:#92400E;"></span>
            </div>
            <h3 id="rLevelTitle" style="font-size:18px;margin:0 0 10px;color:var(--ink);"></h3>
            <p id="rLevelText" style="font-size:14px;line-height:1.68;color:#2C3742;margin:0;"></p>
          </div>

          <!-- Por áreas evaluadas -->
          <div class="tiny mb16" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink);"><?= $isSpanish ? 'Resultados por área evaluada' : 'Results by evaluated area'; ?></div>
          <div id="rAreas" class="areas-breakdown mb28"></div>

          <!-- 6 Financial Abilities Breakdown -->
          <div class="tiny mb16" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink);"><?= $isSpanish ? 'Tus seis habilidades financieras' : 'Your six financial abilities'; ?></div>
          <div id="rAbilitiesBreakdown" class="abilities-breakdown mb28"></div>

          <!-- The Gap copy (R1 v2.1) -->
          <div class="card pad-md mb28" style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;">
            <p class="lede" id="rGapCopy" style="color:#2C3742;line-height:1.6;font-size:14px;margin:0;">
              <?= $isSpanish 
                ? '<strong>Lo que este resultado todavía no te muestra:</strong> Tener es una de las seis habilidades que forman tu salud financiera. Las otras cinco son Producir, Enfocar, Investigar, Invertir y Crear riqueza. Tu Perfil de Salud Financiera mide las seis, te muestra cuál te está frenando más y te da con qué trabajarla.' 
                : '<strong>What this result still doesn\'t show you:</strong> Having is only one of the six abilities that define your financial health. The other five are Producing, Focusing, Investigating, Investing, and Creating Wealth. Your Financial Health Profile measures all six, shows you which one is holding you back the most, and gives you tools to elevate it.'; ?>
            </p>
          </div>

          <button type="button" class="btn btn-ghost btn-sm" id="retake"><?= $isSpanish ? 'Repetir el perfil' : 'Retake the profile'; ?></button>
        </div>

        <!-- Right Column: Offer Card (Two Products v2.1) -->
        <div class="result-sidebar">
          <!-- Primary Offer: Automated Profile -->
          <div class="card pad-lg tint" style="border-color:#C2E4D2;background:#F6FAF8;">
            <div class="tiny" style="color:var(--shgreen);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;"><?= $isSpanish ? 'Opción Principal · Automático' : 'Primary Option · Automated'; ?></div>
            <h3 class="mt8"><?= $isSpanish ? 'Perfil de Salud Financiera' : 'Financial Health Profile'; ?></h3>
            <p class="sm mt8" style="color:#4A5764;line-height:1.55;">
              <?= $isSpanish 
                ? 'Gráfica completa de tus 6 habilidades, audio-lección de Alan C. Walter y el cuaderno de trabajo "Tomando las riendas de tu futuro financiero".' 
                : 'Complete chart of your 6 abilities, Alan C. Walter audio lesson, and the "Taking Charge of Your Financial Future" workbook.'; ?>
            </p>

            <div class="card pad-sm mt12" style="background:#fff;border:1px solid rgba(0,0,0,0.06);border-radius:8px;">
              <div class="tiny mb6" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Incluye exactamente:' : 'What\'s included:'; ?></div>
              <ul class="xs" style="margin:0;padding-left:18px;color:#4A5764;line-height:1.65;">
                <li><?= $isSpanish ? '100 preguntas y diagnóstico preciso' : '100 questions and precise diagnosis'; ?></li>
                <li><?= $isSpanish ? 'Tu gráfica completa de las seis habilidades' : 'Your full chart of all six abilities'; ?></li>
                <li><?= $isSpanish ? 'Audio-lección exclusiva de Alan C. Walter' : 'Alan C. Walter\'s exclusive audio lesson'; ?></li>
                <li><?= $isSpanish ? 'Cuaderno "Tomando las riendas de tu futuro financiero"' : 'Workbook "Taking Charge of Your Financial Future"'; ?></li>
              </ul>
            </div>

            <div class="hgroup mt16" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Pago único:' : 'One-time payment:'; ?></span>
              <span class="price-tag" style="font-size:19px;font-weight:700;color:var(--shgreen);"><?= $isSpanish ? '$500 MXN' : '$25 USD'; ?></span>
            </div>

            <a class="btn btn-go btn-block mt14" id="rBtnBuy" href="<?= esc_url($reportBtnLink); ?>"><?= $isSpanish ? 'Obtener mi Perfil de Salud Financiera' : 'Get my Financial Health Profile'; ?></a>
          </div>

          <!-- Secondary Offer: Profile + Private Session -->
          <div class="card pad-md mt16" style="background:#fff;border:1px solid var(--line);border-radius:10px;">
            <div class="tiny" style="color:var(--stage);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;"><?= $isSpanish ? 'Opción Secundaria · Con Coach' : 'Secondary Option · With Coach'; ?></div>
            <h4 class="mt6" style="font-size:16px;"><?= $isSpanish ? 'Perfil + Sesión Privada (60 min)' : 'Profile + Private Session (60 min)'; ?></h4>
            <p class="xs mt6" style="color:#5B6475;line-height:1.5;">
              <?= $isSpanish 
                ? 'Todo lo anterior, más una sesión de 60 minutos con un coach certificado para interpretar y profundizar en tus resultados.' 
                : 'All the above, plus a 60-minute one-on-one session with a certified coach to interpret and deepen into your results.'; ?>
            </p>
            <div class="hgroup mt10 mb10" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Inversión:' : 'Investment:'; ?></span>
              <span style="font-size:16px;font-weight:700;color:var(--ink);"><?= $isSpanish ? '$1,640 MXN' : '$85 USD'; ?></span>
            </div>
            <a class="btn btn-sm btn-block" id="rBtnBuySession" href="<?= esc_url($sessionBtnLink); ?>" style="background:var(--stage-bg);color:var(--stage);border:1px solid var(--stage);font-weight:600;text-align:center;text-decoration:none;display:block;">
              <?= $isSpanish ? 'Quiero el perfil con sesión privada' : 'Get profile with private session'; ?>
            </a>
          </div>

          <!-- Tertiary Option: Email result -->
          <div class="mt16">
            <button type="button" class="btn btn-ghost btn-sm btn-block" id="rBtnEmailMe"><?= $isSpanish ? 'Enviarme mi resultado por correo' : 'Email me my result'; ?></button>
            <div id="rEmailSentMsg" class="tiny center mt8" style="color:var(--shgreen);display:none;font-weight:600;"><?= $isSpanish ? '✓ Enviado a tu correo' : '✓ Sent to your email'; ?></div>
            <div class="tiny center mt12 text-muted"><?= $isSpanish ? 'Garantía de satisfacción · ACLC' : 'Satisfaction guarantee · ACLC'; ?></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
