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
if (empty($reportBtnLink)) {
    $reportBtnLink = home_url('/finance/');
}

$spanishQuizData = [
  'isSpanish' => $isSpanish,
  'lang'      => $isSpanish ? 'es' : 'en',
  'questions' => [
    ['a' => 'Life & Skills', 'ab' => 'Producir', 't' => '¿Completas tus actividades con rapidez?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Enfocarse', 't' => '¿Estás posicionado para el éxito?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Percibes los juegos o intenciones de otras personas?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Conduces un automóvil de lujo?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Enfocarse', 't' => '¿Tu futuro es incierto?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Producir', 't' => '¿Te gusta tener mucha acción y actividad?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Te endeudas al final del año?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Tiendes a percibir erróneamente a las personas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Viajas en clase económica en lugar de primera clase?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Tener', 't' => '¿Estás inseguro sobre tus deseos materiales?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Desearías estar viviendo el sueño que anhelas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Producir', 't' => '¿Tu carrera se ha convertido en menos de lo que deseabas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Desearías haber actuado más rápido en el pasado?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Invertir', 't' => '¿Tu carrera te brindará riqueza en el futuro?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Enfocarse', 't' => '¿Siempre te esfuerzas por ser lo mejor que puedes ser?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Te desagradan las personas?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invertir', 't' => '¿Tomas acciones concretas para elevar tu nivel de juego?', 'o' => [['Sí', 4], ['Tal vez', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigar', 't' => '¿Sientes que sabes más que otros, incluso que aquellos con más éxito que tú?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Enfocarse', 't' => '¿Prefieres quedarte cerca de casa durante las vacaciones?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Enfocarse', 't' => '¿Te distraes con facilidad?', 'o' => [['Sí', 1], ['Tal vez', 2], ['No', 4]]],
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
    'Enfocarse'     => 'Tu atención está repartida en tantos frentes que ninguno alcanza el punto donde empieza a dar resultados.',
    'Invertir'      => 'Tu tiempo, tu energía y tu dinero ya están invertidos en algo. La pregunta es si eso te está devolviendo algo.',
    'Producir'      => 'Estás ocupado casi todo el día y aun así cuesta trabajo señalar qué produjiste esta semana.',
    'Crear riqueza' => 'No se entrena sola: es el promedio de las otras cinco y te muestra el resultado de todas juntas.',
  ],
  'labels' => [
    'area'          => 'Área: ',
    'you_are_in'    => 'Estás en la Zona ',
    'you_are_here'  => ' · tú estás aquí',
    'start_here'    => ' · habilidad crítica',
    'privacy_error' => 'Por favor acepta la Política de Privacidad para ver tu resultado.',
    'email_error'   => 'Por favor ingresa un correo electrónico válido.',
    'phone_error'   => 'Por favor ingresa un número de teléfono o WhatsApp válido.',
    'email_sent'    => '✓ Tu resultado ha sido enviado a tu correo.',
    'gap_template'  => 'Lo que este resultado todavía no te dice: por qué {ability} está ahí, cuál de las otras cinco la arrastra y cuál es el primer movimiento con más impacto. Todo eso está en tu Perfil de Salud Financiera: 100 preguntas, tu gráfica completa, el reporte de las seis habilidades, el Cuaderno de Trabajo y la audio-lección de Alan C. Walter.',
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
          <input class="input" type="tel" id="gPhone" placeholder="+1 555 123 4567" required>
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

    <!-- Screen 4: Result (R1 Blueprint) -->
    <div id="quizResult" class="quiz-screen" hidden>
      <div class="split top result-grid">
        <!-- Left Column: Result & Breakdown -->
        <div class="result-main">
          <div class="kicker" style="color:var(--shgreen)"><?= $isSpanish ? 'Mini Perfil Financiero · Diagnóstico' : 'Financial Mini Profile · Diagnosis'; ?></div>
          
          <h1 class="mt16" style="line-height:1.2;">
            <span id="rUserName"></span><?= $isSpanish ? ', tu habilidad más baja es ' : ', your lowest ability is '; ?><span id="rLowestAbility" style="color:var(--fuego);font-weight:700;"></span>
          </h1>

          <!-- Quote Card (Slide 18) -->
          <div class="card quote-card pad-md mt20" style="background:#FFFBF2;border:1px solid #F5E5C9;border-left:4px solid var(--fuego);border-radius:8px;">
            <p class="quote-text" id="rAbilityQuote" style="font-size:15px;line-height:1.6;font-style:italic;color:var(--ink);margin:0;"></p>
          </div>

          <!-- The Gap copy (Slide 4) -->
          <div class="mt24">
            <p class="lede" id="rGapCopy" style="color:#2C3742;line-height:1.6;">
              <?= $isSpanish 
                ? 'Lo que este resultado todavía no te dice: por qué tu habilidad más baja está ahí, cuál de las otras cinco la arrastra y cuál es el primer movimiento con más impacto. Todo eso está en tu Perfil de Salud Financiera: 100 preguntas, tu gráfica completa, el reporte de las seis habilidades, el Cuaderno de Trabajo y la audio-lección de Alan C. Walter.' 
                : 'What this result still doesn\'t tell you: why your lowest ability sits where it does, which of the other five is dragging it down, and which first move has the most impact. That\'s in your Financial Health Profile: 100 questions, your full chart, the report on all six abilities, the Financial Fitness Workbook and Alan C. Walter\'s audio lesson.'; ?>
            </p>
          </div>
          
          <hr class="rule mt28 mb28">

          <!-- 6 Financial Abilities Breakdown -->
          <div class="tiny mb16" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink);"><?= $isSpanish ? 'Tus seis habilidades financieras' : 'Your six financial abilities'; ?></div>
          <div id="rAbilitiesBreakdown" class="abilities-breakdown mb28"></div>

          <!-- Overall Zone Summary -->
          <div class="card tint pad-md mb28" style="background:rgba(0,125,25,0.03);border:1px solid #D6EDE0;border-radius:8px;">
            <div class="hgroup" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:600;color:var(--ink);"><?= $isSpanish ? 'Zona general:' : 'Overall Zone:'; ?> <strong id="rZoneName" style="color:var(--shgreen);"></strong></span>
              <span class="tiny" id="rZoneScoreLabel"></span>
            </div>
            <div class="mt12" id="rBar"></div>
            <p class="xs mt12 text-muted" id="rBody" style="margin-bottom:0;"></p>
          </div>

          <button type="button" class="btn btn-ghost btn-sm" id="retake"><?= $isSpanish ? 'Repetir el perfil' : 'Retake the profile'; ?></button>
        </div>

        <!-- Right Column: Offer Card (Slide 4) -->
        <div class="result-sidebar">
          <div class="card pad-lg tint" style="border-color:#C2E4D2;background:#F6FAF8;">
            <div class="kicker" style="color:var(--shgreen)"><?= $isSpanish ? 'Oferta exclusiva' : 'Exclusive offer'; ?></div>
            <h3 class="mt8"><?= $isSpanish ? 'Perfil de Salud Financiera' : 'Financial Health Profile'; ?></h3>
            <p class="sm mt12" style="color:#4A5764;line-height:1.55;">
              <?= $isSpanish 
                ? 'Medición a fondo de tus seis habilidades, el porqué de tu punto bajo y el plan de 90 días para resolverlo.' 
                : 'Deep measurement of your six abilities, the reason behind your low point, and the 90-day plan to resolve it.'; ?>
            </p>

            <div class="card pad-sm mt16" style="background:#fff;border:1px solid rgba(0,0,0,0.06);border-radius:8px;">
              <div class="tiny mb8" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Qué incluye exactamente:' : 'What\'s included:'; ?></div>
              <ul class="xs" style="margin:0;padding-left:18px;color:#4A5764;line-height:1.7;">
                <li><?= $isSpanish ? '100 preguntas y diagnóstico preciso' : '100 questions and precise diagnosis'; ?></li>
                <li><?= $isSpanish ? 'Tu gráfica completa de las seis habilidades' : 'Your full chart of all six abilities'; ?></li>
                <li><?= $isSpanish ? 'Reporte detallado de fugas y bloqueos' : 'Detailed leaks and bottlenecks report'; ?></li>
                <li><?= $isSpanish ? 'Cuaderno de Trabajo con plan de 90 días' : 'Financial Fitness Workbook with 90-day plan'; ?></li>
                <li><?= $isSpanish ? 'Audio-lección exclusiva de Alan C. Walter' : 'Alan C. Walter\'s exclusive audio lesson'; ?></li>
              </ul>
            </div>

            <div class="hgroup mt20" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Pago único:' : 'One-time payment:'; ?></span>
              <span class="price-tag" style="font-size:19px;font-weight:700;color:var(--shgreen);">$500 USD</span>
            </div>

            <a class="btn btn-go btn-block mt16" id="rBtnBuy" href="<?= esc_url($reportBtnLink); ?>"><?= $isSpanish ? 'Obtener mi Perfil de Salud Financiera' : 'Get my Financial Health Profile'; ?></a>
            <button type="button" class="btn btn-ghost btn-sm btn-block mt12" id="rBtnEmailMe"><?= $isSpanish ? 'Enviarme mi mini perfil por correo' : 'Email me my mini profile'; ?></button>
            <div id="rEmailSentMsg" class="tiny center mt8" style="color:var(--shgreen);display:none;font-weight:600;"><?= $isSpanish ? '✓ Enviado a tu correo' : '✓ Sent to your email'; ?></div>
            <div class="tiny center mt16 text-muted"><?= $isSpanish ? 'Garantía de satisfacción · ACLC' : 'Satisfaction guarantee · ACLC'; ?></div>
          </div>

          <a class="card card-link mt20" href="<?= esc_url(home_url($isSpanish ? '/es/cohorts/' : '/cohorts/')); ?>" style="display:block">
            <div class="tiny text-muted"><?= $isSpanish ? 'O hazlo en grupo' : 'Or do it with a group'; ?></div>
            <h4 class="mt8"><?= $isSpanish ? 'Cohorte de Otoño' : 'Autumn cohort'; ?></h4>
            <div class="tiny mt8" style="color:var(--fuego)"><?= $isSpanish ? 'Inicia 14 de Octubre' : 'Starts 14 October'; ?></div>
          </a>

          <div class="card mt20">
            <div class="tiny mb8"><?= $isSpanish ? 'O con un coach, a tu propio ritmo' : 'Or with a coach, at your own pace'; ?></div>
            <p class="xs text-muted"><?= $isSpanish ? 'Fundamentos Vitales y coaching uno a uno son impartidos por ACLC en Letoli Ranch.' : 'Vital Fundamentals and one-to-one coaching are delivered by ACLC at Letoli Ranch.'; ?></p>
            <a class="btn btn-ghost btn-sm btn-block mt16" href="<?= esc_url(home_url($isSpanish ? '/es/#contact' : '/#contact')); ?>">
              <?= $isSpanish ? 'Hablar con un coach' : 'Talk to a coach'; ?>
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
