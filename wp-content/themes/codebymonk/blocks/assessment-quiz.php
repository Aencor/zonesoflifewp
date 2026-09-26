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

$introKicker = get_field('intro_kicker') ?: ($isSpanish ? 'GRATIS · DOS MINUTOS' : 'FREE · TWO MINUTES');
$introTitle = get_field('intro_title') ?: ($isSpanish ? 'Descubre tu Habilidad para Tener' : 'Discover your Ability to Have');
$introDesc = get_field('intro_desc') ?: ($isSpanish 
    ? 'Tu Mini Perfil Financiero te da el resultado de una de tus seis habilidades financieras: la Habilidad para Tener. Por eso tu resultado cae en uno de tres niveles: trabajando para no tener, batallando para tener o con la capacidad para tener. Son 20 preguntas y no hay respuestas correctas. Nadie más verá tus respuestas. Te pedimos tu correo al final para mandarte tu resultado y tu gráfica.' 
    : 'Your Mini Financial Profile gives you the result of one of your six financial abilities: the Ability to Have. That\'s why your result falls into one of three levels: working not to have, struggling to have, or able to have. It\'s 20 questions and there are no right answers. Nobody else will see your answers. We\'ll ask for your email at the end to send you your result and your graph.');
$btnText = get_field('intro_btn_text') ?: (get_field('btn_text') ?: ($isSpanish ? 'Comenzar mi Mini Perfil' : 'Start my Mini Profile'));
$aclc_user = class_exists('ACLC_Auth') ? ACLC_Auth::get_logged_user() : null;
$is_logged_in = !empty($aclc_user);
$pay_url_base = $isSpanish ? home_url('/es/adquirir/') : home_url('/pay/');
$access_url_base = $isSpanish ? home_url('/es/acceso/') : home_url('/access/');

$pay_profile = add_query_arg('package', 'profile', $pay_url_base);
$reportBtnText = get_field('report_btn_text') ?: ($isSpanish ? 'Obtener mi Perfil de Salud Financiera' : 'Get my Financial Health Profile');
$reportBtnLink = get_field('report_btn_link');
if (empty($reportBtnLink) || in_array($reportBtnLink, ['/finance/', '/es/finance/', home_url('/finance/'), home_url('/es/perfil-financiero/')])) {
    $reportBtnLink = $isSpanish ? home_url('/es/perfil-financiero/') : home_url('/finance/');
}
$sessionBtnLink = get_field('session_btn_link');
if (empty($sessionBtnLink)) {
    $sessionBtnLink = $isSpanish ? home_url('/es/perfil-financiero/?package=session') : home_url('/finance/?package=session');
}

$spanishQuizData = [
  'isSpanish'   => $isSpanish,
  'lang'        => $isSpanish ? 'es' : 'en',
  'isLoggedIn'  => (bool)$is_logged_in,
  'payUrl'      => $pay_url_base,
  'accessUrl'   => $access_url_base,
  'chartTemplateUrl' => get_stylesheet_directory_uri() . '/assets/img/HaveTemplate_ES.png',
  'financeUrl'  => $isSpanish ? home_url('/es/perfil-financiero/') : home_url('/finance/'),
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
      'name'      => 'Trabajando para no tener',
      'subtitle'  => 'Mitad de la Zona Amarilla hacia abajo',
      'title'     => 'Nivel: Trabajando para no tener',
      'short'     => 'Si tu resultado está por debajo de la línea central oscura que recorre horizontalmente la Zona Amarilla, esto significa que estás trabajando "para no tener".',
      'full'      => 'Si tu resultado está por debajo de la línea central oscura que recorre horizontalmente la Zona Amarilla, esto significa que estás trabajando "para no tener". La mayoría de las personas NO PUEDEN TENER. No importa si lo tienen físicamente... no pueden tenerlo de verdad. No se sienten lo suficientemente valiosos. No se sienten lo suficientemente buenos. Sienten que no deberían obtener lo que están intentando alcanzar y sienten que no lo merecen. Por lo general, han sido programados con mensajes como: “no vales nada” o “no sirves para nada”. Eso es el resultado de mucho procesamiento negativo que hace que la persona se sienta así. El proceso negativo básico que está gobernando sus vidas es: “No puedes ser esto, no puedes hacer esto, no puedes tener esto. No puedes tener tus sueños. No puedes ser, no puedes hacer, y no puedes tener”. PROCESO NEGATIVO: Es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar. Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.',
      'full_html' => '<p style="margin-bottom:14px;">Si tu resultado está por debajo de la línea central oscura que recorre horizontalmente la Zona Amarilla, esto significa que estás trabajando "para no tener".</p><p style="margin-bottom:14px;"><strong>La mayoría de las personas NO PUEDEN TENER.</strong></p><p style="margin-bottom:14px;">No importa si lo tienen físicamente... no pueden tenerlo de verdad.<br>No se sienten lo suficientemente valiosos.<br>No se sienten lo suficientemente buenos.<br>Sienten que no deberían obtener lo que están intentando alcanzar y sienten que no lo merecen.</p><p style="margin-bottom:14px;">Por lo general, han sido programados con mensajes como:<br>“no vales nada”<br>o<br>“no sirves para nada.”</p><p style="margin-bottom:14px;">Eso es el resultado de mucho procesamiento negativo que hace que la persona se sienta así.</p><p style="margin-bottom:14px;">El proceso negativo básico que está gobernando sus vidas es: “No puedes ser esto, no puedes hacer esto, no puedes tener esto. No puedes tener tus sueños. No puedes ser, no puedes hacer, y no puedes tener”.</p><p style="margin-bottom:14px;"><strong>PROCESO NEGATIVO:</strong> Es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar.</p><p style="margin-bottom:0;">Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.</p>'
    ],
    'high_yellow' => [
      'name'      => 'Batallando para tener',
      'subtitle'  => 'Mitad de la Zona Amarilla hacia la parte alta',
      'title'     => 'Nivel: Batallando para tener',
      'short'     => 'Si tu resultado está por encima de la línea central oscura que recorre horizontalmente la Zona Amarilla pero aún en la Zona Amarilla, significa que estás batallando "para tener".',
      'full'      => 'Si tu resultado está por encima de la línea central oscura que recorre horizontalmente la Zona Amarilla pero aún en la Zona Amarilla, significa que estás batallando "para tener". La vida, la familia, tus padres o los grupos te han procesado negativamente diciéndote lo que no se puede hacer y por qué no se puede hacer y lo que no debe hacerse. En este tipo de entornos, las personas utilizan el poder o las fuerzas externas para dictar lo que es correcto, cómo se debe actuar o comportar. PROCESO NEGATIVO: Es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar. Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.',
      'full_html' => '<p style="margin-bottom:14px;">Si tu resultado está por encima de línea central oscura que recorre horizontalmente la Zona Amarilla pero aún en la Zona Amarilla, significa que estás batallando "para tener".</p><p style="margin-bottom:14px;">La vida, la familia, tus padres o los grupos te han procesado negativamente diciéndote lo que no se puede hacer y por qué no se puede hacer y lo que no debe hacerse.</p><p style="margin-bottom:14px;">En este tipo de entornos, las personas utilizan el poder o las fuerzas externas para dictar lo que es correcto, cómo se debe actuar o comportar.</p><p style="margin-bottom:14px;"><strong>PROCESO NEGATIVO:</strong> Es una serie de acciones, cambios o funciones que te impiden o te alejan de alcanzar el resultado o propósito que deseas lograr. Es un movimiento continuo y descendente que te desvía del rumbo que realmente querías tomar.</p><p style="margin-bottom:0;">Un proceso negativo está compuesto por acciones deshonestas, sin honor, contrarias a tu propósito o fuera de rumbo, que generan ciclos de comportamiento o decisiones que terminan produciendo un resultado negativo o no óptimo.</p>'
    ],
    'green' => [
      'name'      => 'Tienes la capacidad para tener',
      'subtitle'  => 'Zona Verde',
      'title'     => 'Nivel: Tienes la capacidad para tener',
      'short'     => '¡Felicidades! Si tu resultado está en la Zona Verde, tienes la capacidad para "tener"; cuanto más alto estés en la Zona Verde, mayor será tu capacidad para tener todo lo que deseas.',
      'full'      => '¡Felicidades! Si tu resultado está en la Zona Verde, tienes la capacidad para "tener"; cuanto más alto estés en la Zona Verde, mayor será tu capacidad para tener todo lo que deseas. Tu entorno trabaja contigo constantemente en armonía y has recibido muchos procesos positivos. PROCESO POSITIVO: Es una serie de acciones positivas, cambios o funciones que te llevan a lograr el resultado o propósito positivo que te has propuesto. Es un movimiento continuo y ascendente en la dirección que tú decidiste seguir. También puede definirse como una serie de acciones honestas, con integridad, alineadas con tus metas y propósitos, que dan lugar a ciclos de operación que culminan en un producto o resultado final positivo y óptimo. Recuerda que hay dos cosas que debes tener para volverte rico: La primera es la disciplina, y la segunda es la duplicación. Si tienes esas dos cosas, puedes tener éxito en cualquier momento. Si estás en la Zona Verde, ¡Tienes la habilidad para tener! Haz más de las acciones exitosas que ya estás ejecutando para expandir tu juego.',
      'full_html' => '<p style="margin-bottom:14px;"><strong>¡Felicidades!</strong></p><p style="margin-bottom:14px;">Si tu resultado está en la Zona Verde, tienes la capacidad para "tener"; cuanto más alto estés en la Zona Verde, mayor será tu capacidad para tener todo lo que deseas.</p><p style="margin-bottom:14px;">Tu entorno trabaja contigo constantemente en armonía y has recibido muchos procesos positivos.</p><p style="margin-bottom:14px;"><strong>PROCESO POSITIVO:</strong> Es una serie de acciones positivas, cambios o funciones que te llevan a lograr el resultado o propósito positivo que te has propuesto. Es un movimiento continuo y ascendente en la dirección que tú decidiste seguir.</p><p style="margin-bottom:14px;">También puede definirse como una serie de acciones honestas, con integridad, alineadas con tus metas y propósitos, que dan lugar a ciclos de operación que culminan en un producto o resultado final positivo y óptimo.</p><p style="margin-bottom:14px;">Recuerda que hay dos cosas que debes tener para volverte rico:<br>La primera es la disciplina, y la segunda es la duplicación.<br>Si tienes esas dos cosas, puedes tener éxito en cualquier momento.</p><p style="margin-bottom:14px;">Si estás en la Zona Verde,<br><strong>¡Tienes la habilidad para tener!</strong></p><p style="margin-bottom:0;">Haz más de las acciones exitosas que ya estás ejecutando para expandir tu juego.</p>'
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

$englishQuizData = [
  'isSpanish'   => false,
  'lang'        => 'en',
  'isLoggedIn'  => (bool)$is_logged_in,
  'payUrl'      => $pay_url_base,
  'accessUrl'   => $access_url_base,
  'chartTemplateUrl' => get_stylesheet_directory_uri() . '/assets/img/HaveTemplate.png',
  'financeUrl'  => home_url('/finance/'),
  'questions' => [
    ['a' => 'Life & Skills', 'ab' => 'Produce', 't' => 'Do you complete activities quickly?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Focus', 't' => 'Are you positioned for success?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigate', 't' => "Do you perceive other people's games?", 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Have', 't' => 'Do you drive a luxury car?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Focus', 't' => 'Is your future uncertain?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Produce', 't' => 'Do you like to have a lot of action?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Financial', 'ab' => 'Have', 't' => 'Do you go into debt at the end of the year?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigate', 't' => 'Do you tend to misperceive people?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Have', 't' => 'Do you travel in economy class instead of first class?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Have', 't' => 'Are you unsure about your material desires?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invest', 't' => 'Do you wish you were living your dream?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Produce', 't' => 'Has your career become less than what you wanted?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invest', 't' => 'Do you wish you had acted faster?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Financial', 'ab' => 'Invest', 't' => 'Will your career provide you with future wealth?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Focus', 't' => 'Do you always strive to be the best you can be?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigate', 't' => 'Do you dislike people?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Life & Skills', 'ab' => 'Invest', 't' => 'Do you take action to up your game?', 'o' => [['Yes', 4], ['Maybe', 2], ['No', 1]]],
    ['a' => 'Life & Skills', 'ab' => 'Investigate', 't' => 'Do you feel you know more than others, even those more successful than you?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Focus', 't' => 'Do you like staying close to home during holidays?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
    ['a' => 'Body', 'ab' => 'Focus', 't' => 'Are you easily distracted?', 'o' => [['Yes', 1], ['Maybe', 2], ['No', 4]]],
  ],
  'zones' => [
    1 => ['n' => 'Red', 'i' => 1, 'col' => 'var(--red)'],
    2 => ['n' => 'Yellow', 'i' => 2, 'col' => '#B98F0C'],
    3 => ['n' => 'Green', 'i' => 3, 'col' => 'var(--shgreen)'],
    4 => ['n' => 'Golden Magic', 'i' => 4, 'col' => '#8A7440'],
  ],
  'copy' => [
    'Red'          => "This is someone who is in the wrong place at the wrong time, connected to the wrong people. Effort produces little, because you are reacting to what happens instead of directing it.",
    'Yellow'       => "This is the “daily grind” or “rut” where the person doesn’t take risks but works only for security. Awake, but change still depends on how you feel that day.",
    'Green'        => "This is someone who is in the right place at the right time, making things go right. This person is living their dream. Results arrive consistently because structure holds them, not willpower.",
    'Golden Magic' => "You are outside of the physical universe. You operate above the laws of the physical universe and are totally telepathic. Mastery in your Zone reliably.",
  ],
  'ability_quotes' => [
    'Have'          => "You can earn more and still end up with nothing: if you don't feel entitled to keep it, money finds its own way out.",
    'Investigate'   => "Expensive decisions are rarely made for lack of money. They're made for lack of questions before signing.",
    'Focus'         => "Your attention is spread across so many fronts that none of them reaches the point where results start.",
    'Invest'        => "Your time, your energy and your money are already invested in something. The question is whether it's giving anything back.",
    'Produce'       => "You're busy most of the day and still find it hard to point at what you produced this week.",
    'Create Wealth' => "It can't be trained on its own: it's the average of the other five, showing you the result of all of them together.",
  ],
  'have_levels' => [
    'low_yellow' => [
      'name'      => 'Working not to have',
      'subtitle'  => 'Below the Yellow Zone centerline',
      'title'     => 'Level: Working not to have',
      'short'     => 'If your score sits below the dark centerline running horizontally across the Yellow Zone, you are working "not to have".',
      'full'      => 'If your score sits below the dark centerline running horizontally across the Yellow Zone, you are working "not to have". Most people CANNOT HAVE. It doesn\'t matter if they hold it physically... they cannot truly have it. They don\'t feel worthy enough. They don\'t feel good enough. They feel they shouldn\'t obtain what they are reaching for and feel they don\'t deserve it. Typically, they have been programmed with messages like "you\'re worth nothing" or "you\'re useless". That is the result of heavy negative processing making a person feel that way. The fundamental negative process governing their lives is: "You can\'t be this, you can\'t do this, you can\'t have this. You can\'t have your dreams. You cannot be, you cannot do, and you cannot have." NEGATIVE PROCESS: a series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take. A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.',
      'full_html' => '<p style="margin-bottom:14px;">If your score sits below the dark centerline running horizontally across the Yellow Zone, you are working "not to have".</p><p style="margin-bottom:14px;"><strong>Most people CANNOT HAVE.</strong></p><p style="margin-bottom:14px;">It doesn\'t matter if they hold it physically... they cannot truly have it.<br>They don\'t feel worthy enough.<br>They don\'t feel good enough.<br>They feel they shouldn\'t obtain what they are reaching for and feel they don\'t deserve it.</p><p style="margin-bottom:14px;">Typically, they have been programmed with messages like:<br>"you\'re worth nothing"<br>or<br>"you\'re useless."</p><p style="margin-bottom:14px;">That is the result of heavy negative processing making a person feel that way.</p><p style="margin-bottom:14px;">The fundamental negative process governing their lives is: "You can\'t be this, you can\'t do this, you can\'t have this. You can\'t have your dreams. You cannot be, you cannot do, and you cannot have."</p><p style="margin-bottom:14px;"><strong>NEGATIVE PROCESS:</strong> A series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take.</p><p style="margin-bottom:0;">A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.</p>'
    ],
    'high_yellow' => [
      'name'      => 'Struggling to have',
      'subtitle'  => 'Upper half of the Yellow Zone',
      'title'     => 'Level: Struggling to have',
      'short'     => 'If your score sits above the dark centerline running horizontally across the Yellow Zone, yet remains in the Yellow Zone, you are struggling "to have".',
      'full'      => 'If your score sits above the dark centerline running horizontally across the Yellow Zone, yet remains within the Yellow Zone, you are struggling "to have". Life, family, parents, or social groups have negatively processed you by dictating what cannot be done, why it cannot be done, and what must not be done. In environments like this, external power or force is exerted to dictate what is right and how one must act or behave. NEGATIVE PROCESS: a series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take. A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.',
      'full_html' => '<p style="margin-bottom:14px;">If your score sits above the dark centerline running horizontally across the Yellow Zone, yet remains in the Yellow Zone, you are struggling "to have".</p><p style="margin-bottom:14px;">Life, family, parents, or social groups have negatively processed you by dictating what cannot be done, why it cannot be done, and what must not be done.</p><p style="margin-bottom:14px;">In environments like this, external power or force is exerted to dictate what is right and how one must act or behave.</p><p style="margin-bottom:14px;"><strong>NEGATIVE PROCESS:</strong> A series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take.</p><p style="margin-bottom:0;">A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.</p>'
    ],
    'green' => [
      'name'      => 'You have the ability to have',
      'subtitle'  => 'Green Zone',
      'title'     => 'Level: You have the ability to have',
      'short'     => 'Congratulations! If your score is in the Green Zone, you have the ability "to have"; the higher you are in the Green Zone, the greater your capacity to have everything you desire.',
      'full'      => 'Congratulations! If your score is in the Green Zone, you have the ability "to have"; the higher you are in the Green Zone, the greater your capacity to have everything you desire. Your environment operates in steady harmony with you, and you have received abundant positive processing. POSITIVE PROCESS: a series of positive actions, changes, or functions that lead you directly to achieving the positive result or purpose you set out for. It is a continuous, upward motion in the direction you decided to pursue. It is defined as a series of honest, high-integrity actions aligned with your goals and purpose, producing operating cycles that culminate in an optimal, positive final product or result. Remember that two things are vital to accumulating wealth: first is discipline, and second is duplication. If you have those two, you can succeed at any moment. If you are in the Green Zone, you have the ability to have! Execute more of the successful actions you are already taking to expand your game.',
      'full_html' => '<p style="margin-bottom:14px;"><strong>Congratulations!</strong></p><p style="margin-bottom:14px;">If your score is in the Green Zone, you have the ability "to have"; the higher you are in the Green Zone, the greater your capacity to have everything you desire.</p><p style="margin-bottom:14px;">Your environment operates in steady harmony with you, and you have received abundant positive processing.</p><p style="margin-bottom:14px;"><strong>POSITIVE PROCESS:</strong> A series of positive actions, changes, or functions that lead you directly to achieving the positive result or purpose you set out for. It is a continuous, upward motion in the direction you decided to pursue.</p><p style="margin-bottom:14px;">It is defined as a series of honest, high-integrity actions aligned with your goals and purpose, producing operating cycles that culminate in an optimal, positive final product or result.</p><p style="margin-bottom:14px;">Remember that two things are vital to accumulating wealth:<br>First is discipline, and second is duplication.<br>If you have those two, you can succeed at any moment.</p><p style="margin-bottom:14px;">If you are in the Green Zone,<br><strong>You have the ability to have!</strong></p><p style="margin-bottom:0;">Execute more of the successful actions you are already taking to expand your game.</p>'
    ]
  ],
  'labels' => [
    'area'          => 'Area: ',
    'you_are_in'    => 'You are in the ',
    'you_are_here'  => ' · you are here',
    'start_here'    => ' · evaluated ability',
    'privacy_error' => 'Please accept the Privacy Policy to view your result.',
    'email_error'   => 'Please enter a valid email address.',
    'phone_error'   => 'Please enter a valid phone or WhatsApp number.',
    'email_sent'    => '✓ Your result has been sent to your email.',
    'gap_template'  => 'Having is one of the six abilities that form your financial health. The other five are Producing, Focusing, Investigating, Investing, and Creating Wealth. Your Financial Health Profile measures all six, shows you which one is holding you back the most, and gives you tools to elevate it.',
    'area_names'    => [
      'Financial'     => 'Financial',
      'Life & Skills' => 'Life & Skills',
      'Body'          => 'Body',
    ]
  ]
];
?>
<script>
window.zolQuizData = <?= json_encode($isSpanish ? $spanishQuizData : $englishQuizData); ?>;
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
          <div style="display:flex;gap:8px;">
            <select id="gCountryCode" class="input" style="flex:0 0 135px;min-width:120px;padding:0 8px;font-size:14px;background:#fff;cursor:pointer;border-radius:8px;">
              <option value="+52" <?= $isSpanish ? 'selected' : ''; ?>>🇲🇽 +52</option>
              <option value="+1" <?= !$isSpanish ? 'selected' : ''; ?>>🇺🇸 +1</option>
              <option value="+57">🇨🇴 +57</option>
              <option value="+34">🇪🇸 +34</option>
              <option value="+54">🇦🇷 +54</option>
              <option value="+56">🇨🇱 +56</option>
              <option value="+51">🇵🇪 +51</option>
              <option value="+593">🇪🇨 +593</option>
              <option value="+502">🇬🇹 +502</option>
              <option value="+503">🇸🇻 +503</option>
              <option value="+504">🇭🇳 +504</option>
              <option value="+505">🇳🇮 +505</option>
              <option value="+506">🇨🇷 +506</option>
              <option value="+507">🇵🇦 +507</option>
              <option value="+58">🇻🇪 +58</option>
              <option value="+591">🇧🇴 +591</option>
              <option value="+595">🇵🇾 +595</option>
              <option value="+598">🇺🇾 +598</option>
              <option value="+1">🇨🇦 +1</option>
              <option value="">🌐 <?= $isSpanish ? 'Otro' : 'Other'; ?></option>
            </select>
            <input class="input" type="tel" id="gPhone" style="flex:1;" placeholder="<?= $isSpanish ? '55 1234 5678' : '469 123 4567'; ?>" required>
          </div>
        </div>
        <label class="xs" style="display:flex;gap:9px;align-items:flex-start;margin-top:16px;">
          <input type="checkbox" id="gOk" style="margin-top:3px"> 
          <?= $isSpanish ? 'Acepto la Política de Privacidad y recibir mi resultado por correo.' : 'I agree to the Privacy Policy and to receiving my result by email.'; ?>
        </label>
        <label class="xs" style="display:flex;gap:9px;align-items:flex-start;margin-top:10px;">
          <input type="checkbox" id="gWaOptin" style="margin-top:3px"> 
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
          <p class="lede mt12" style="color:#4A5764;font-size:15px;line-height:1.55;">
            <?= $isSpanish 
              ? 'Tu Mini Perfil mide una sola de tus seis habilidades financieras, la Habilidad para Tener. Por eso tu resultado cae en uno de tres niveles.' 
              : 'Your Mini Profile measures only one of your six financial abilities, the Ability to Have. That is why your result falls into one of three levels.'; ?>
          </p>
          
          <div class="mt24" id="rBar" style="display:none;"></div>
          <div class="zlabels" style="display:none;">
            <span class="tiny"><?= $isSpanish ? 'Roja' : 'Red'; ?></span>
            <span class="tiny" id="rHere"></span>
            <span class="tiny"><?= $isSpanish ? 'Verde' : 'Green'; ?></span>
            <span class="tiny"><?= $isSpanish ? 'Magia Dorada' : 'Golden'; ?></span>
          </div>

          <p class="lede mt24" id="rBody" style="display:none;"></p>
          
          <hr class="rule mt32 mb32">

          <!-- Have Ability Level Card (R1) -->
          <div class="card pad-md mb28" id="rLevelCard" style="background:#FFFBF2;border:1px solid #F5E5C9;border-left:4px solid var(--fuego);border-radius:8px;">
            <div class="hgroup" style="justify-content:space-between;align-items:center;margin-bottom:8px;">
              <span class="tiny" style="font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--muted);"><?= $isSpanish ? 'Diagnóstico de tu Nivel en Tener' : 'Your Have Level Diagnosis'; ?></span>
              <span id="rLevelBadge" class="tiny" style="font-weight:700;padding:3px 10px;border-radius:4px;background:#FDE68A;color:#92400E;"></span>
            </div>
            <h3 id="rLevelTitle" style="font-size:18px;margin:0 0 16px;color:var(--ink);"></h3>
            
            <div class="have-level-content" style="display:flex;flex-wrap:wrap;gap:24px;align-items:flex-start;">
              <div class="have-level-chart" style="flex:0 0 auto;width:220px;max-width:100%;text-align:center;background:#fff;padding:12px;border-radius:8px;border:1px solid rgba(0,0,0,0.08);box-shadow:0 2px 8px rgba(0,0,0,0.04);margin:0 auto;">
                <div style="position:relative;cursor:pointer;display:inline-block;width:100%;" id="chartImgContainer" title="<?= $isSpanish ? 'Haz clic para ampliar la gráfica' : 'Click to enlarge chart'; ?>">
                  <img id="rHaveChartImg" src="<?= get_stylesheet_directory_uri(); ?>/assets/img/<?= $isSpanish ? 'HaveTemplate_ES.png' : 'HaveTemplate.png'; ?>" alt="<?= $isSpanish ? 'Gráfica del Mini Perfil - Nivel en Tener' : 'Mini Profile Chart - Ability to Have'; ?>" style="width:100%;height:auto;display:block;border-radius:4px;" />
                  <div style="position:absolute;bottom:6px;right:6px;background:rgba(15,23,42,0.75);color:#fff;border-radius:4px;padding:3px 6px;font-size:10px;font-weight:600;display:flex;align-items:center;gap:3px;backdrop-filter:blur(2px);">
                    <span>🔍</span> <?= $isSpanish ? 'Ampliar' : 'Enlarge'; ?>
                  </div>
                </div>
                <div class="tiny text-muted mt8" style="font-size:11px;font-weight:600;"><?= $isSpanish ? 'Tu Gráfica del Mini Perfil' : 'Your Mini Profile Chart'; ?></div>
                <div style="display:flex;flex-direction:column;gap:6px;margin-top:10px;">
                  <button type="button" class="btn btn-ghost btn-sm" id="btnOpenChartModal" style="width:100%;font-size:11.5px;padding:6px 8px;justify-content:center;cursor:pointer;">
                    🔍 <?= $isSpanish ? 'Ver en grande' : 'Enlarge chart'; ?>
                  </button>
                  <a id="btnDownloadHaveChart" class="btn btn-ghost btn-sm" download="<?= $isSpanish ? 'Mi_Mini_Perfil.png' : 'My_Mini_Profile.png'; ?>" href="<?= get_stylesheet_directory_uri(); ?>/assets/img/<?= $isSpanish ? 'HaveTemplate_ES.png' : 'HaveTemplate.png'; ?>" style="width:100%;font-size:11.5px;padding:6px 8px;justify-content:center;text-decoration:none;cursor:pointer;">
                    ⬇️ <?= $isSpanish ? 'Bajar gráfica' : 'Download chart'; ?>
                  </a>
                </div>
              </div>
              <div id="rLevelText" style="flex:1 1 300px;min-width:260px;font-size:14px;line-height:1.68;color:#2C3742;margin:0;"></div>
            </div>
          </div>

          <!-- Por áreas evaluadas (oculto en mini perfil según C5/R1) -->
          <div id="rAreasContainer" style="display:none;">
            <div class="tiny mb16" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink);"><?= $isSpanish ? 'Resultados por área evaluada' : 'Results by evaluated area'; ?></div>
            <div id="rAreas" class="areas-breakdown mb28"></div>
          </div>

          <!-- 6 Financial Abilities Breakdown (oculto en mini perfil según C5/R1) -->
          <div id="rAbilitiesContainer" style="display:none;">
            <div class="tiny mb16" style="font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--ink);"><?= $isSpanish ? 'Tus seis habilidades financieras' : 'Your six financial abilities'; ?></div>
            <div id="rAbilitiesBreakdown" class="abilities-breakdown mb28"></div>
          </div>

          <!-- The Gap copy (R1 v2.1) -->
          <div class="card pad-md mb28" style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;">
            <p class="lede" id="rGapCopy" style="color:#2C3742;line-height:1.6;font-size:14px;margin:0;">
              <?= $isSpanish 
                ? '<strong>Lo que este resultado todavía no te muestra:</strong> Tener es una de las seis habilidades que forman tu salud financiera. Las otras cinco son Investigar, Enfocarse, Invertir, Producir y Crear riqueza. Tu Perfil de Salud Financiera mide las seis, te muestra cuál te está frenando más y te da con qué trabajarla.' 
                : '<strong>What this result still doesn\'t show you:</strong> Having is only one of the six abilities that define your financial health. The other five are Investigating, Focusing, Investing, Producing, and Creating Wealth. Your Financial Health Profile measures all six, shows you which one is holding you back the most, and gives you tools to elevate it.'; ?>
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
                : 'Complete chart of your 6 abilities, Alan C. Walter audio lesson, and the "Mastering Your Financial Future" workbook.'; ?>
            </p>

            <div class="card pad-sm mt12" style="background:#fff;border:1px solid rgba(0,0,0,0.06);border-radius:8px;">
              <div class="tiny mb6" style="font-weight:700;color:var(--ink);"><?= $isSpanish ? 'Incluye exactamente:' : 'What\'s included:'; ?></div>
              <ul class="xs" style="margin:0;padding-left:18px;color:#4A5764;line-height:1.65;">
                <li><?= $isSpanish ? '100 preguntas y diagnóstico preciso' : '100 questions and precise diagnosis'; ?></li>
                <li><?= $isSpanish ? 'Tu gráfica completa de las seis habilidades' : 'Your full chart of all six abilities'; ?></li>
                <li><?= $isSpanish ? 'Audio-lección exclusiva de Alan C. Walter' : 'Alan C. Walter\'s exclusive audio lesson'; ?></li>
                <li><?= $isSpanish ? 'Cuaderno "Tomando las riendas de tu futuro financiero"' : 'Workbook "Mastering Your Financial Future"'; ?></li>
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

  <!-- Lightbox Modal for Chart -->
  <div id="chartModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(15,23,42,0.85);z-index:999999;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(4px);box-sizing:border-box;">
    <div style="background:#fff;border-radius:12px;max-width:520px;width:100%;max-height:92vh;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.3);position:relative;">
      <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 20px;border-bottom:1px solid #e2e8f0;">
        <h4 id="chartModalTitle" style="margin:0;font-size:16px;color:#0f172a;font-weight:700;"><?= $isSpanish ? 'Tu Gráfica · Mini Perfil' : 'Your Chart · Mini Profile'; ?></h4>
        <button type="button" id="closeChartModal" style="background:none;border:none;font-size:24px;line-height:1;cursor:pointer;color:#64748b;padding:0 6px;">&times;</button>
      </div>
      <div style="padding:16px;overflow-y:auto;text-align:center;background:#f8fafc;flex:1;">
        <img id="chartModalImg" src="<?= get_stylesheet_directory_uri(); ?>/assets/img/<?= $isSpanish ? 'HaveTemplate_ES.png' : 'HaveTemplate.png'; ?>" alt="Gráfica Mini Perfil" style="max-width:100%;height:auto;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.1);display:inline-block;" />
      </div>
      <div style="padding:14px 20px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;background:#fff;">
        <a id="modalDownloadBtn" class="btn btn-go btn-sm" download="<?= $isSpanish ? 'Mi_Mini_Perfil.png' : 'My_Mini_Profile.png'; ?>" href="<?= get_stylesheet_directory_uri(); ?>/assets/img/<?= $isSpanish ? 'HaveTemplate_ES.png' : 'HaveTemplate.png'; ?>" style="text-decoration:none;cursor:pointer;">⬇️ <?= $isSpanish ? 'Bajar gráfica' : 'Download chart'; ?></a>
        <button type="button" id="modalCloseBtn" class="btn btn-ghost btn-sm" style="cursor:pointer;"><?= $isSpanish ? 'Cerrar' : 'Close'; ?></button>
      </div>
    </div>
  </div>
</section>
