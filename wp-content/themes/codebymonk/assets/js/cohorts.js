/**
 * Events / Cohorts In-Page Qualification Quiz & Application Handler
 */
document.addEventListener('DOMContentLoaded', function () {
  var modal = document.getElementById('cohortQuizModal');
  if (!modal) return;

  var tag = document.getElementById('cohortQuizTag');
  var stepCount = document.getElementById('cohortQuizStepCount');
  var progressBar = document.getElementById('cohortQuizProgressBar');
  var body = document.getElementById('cohortQuizBody');
  var btnBack = document.getElementById('cohortQuizBack');
  var btnNext = document.getElementById('cohortQuizNext');
  var footer = document.getElementById('cohortQuizFooter');

  var isSpanish = (document.documentElement.lang && document.documentElement.lang.indexOf('es') === 0) ||
                  (window.location.pathname.indexOf('/es/') !== -1);

  var FSTEPS = isSpanish ? [
    {
      title: '¿Qué área deseas mover primero?',
      options: ['Financiera — tu área roja', 'Vida y Habilidades', 'Cuerpo']
    },
    {
      title: '¿Cuánto tiempo puedes dedicarle cada semana?',
      options: ['Menos de dos horas', 'De dos a cuatro horas', 'Más de cuatro horas']
    },
    {
      title: '¿Has trabajado con este método anteriormente?',
      options: ['No, esto es nuevo', 'He leído los libros', 'He tomado un programa']
    }
  ] : [
    {
      title: 'Which area do you want to move first?',
      options: ['Financial — your red area', 'Life & Skills', 'Body']
    },
    {
      title: 'How much time can you give it each week?',
      options: ['Under two hours', 'Two to four hours', 'More than four hours']
    },
    {
      title: 'Have you worked with this method before?',
      options: ['No, this is new', 'I have read the books', 'I have done a programme']
    }
  ];

  var currentCohort = {
    id: 0,
    name: isSpanish ? 'Evento de otoño' : 'Autumn event',
    date: '14 October',
    isWaitlist: false
  };

  var stepIdx = 0;
  var answers = []; // [areaIdx, timeIdx, expIdx]

  function openModal(cohortData) {
    currentCohort = cohortData;
    stepIdx = 0;
    answers = [];
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    modal.classList.add('is-open');

    if (btnBack) btnBack.textContent = isSpanish ? 'Atrás' : 'Back';

    if (currentCohort.isWaitlist) {
      renderWaitlistForm();
    } else {
      footer.style.display = 'flex';
      renderStep();
    }
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  // Update progress bar helper
  function updateProgress(stepNum) {
    if (!progressBar) return;
    var spans = progressBar.querySelectorAll('span');
    spans.forEach(function (span, i) {
      if (i < stepNum) {
        span.classList.add('on');
      } else {
        span.classList.remove('on');
      }
    });
  }

  // Render Step 0, 1, or 2 (Questions)
  function renderStep() {
    if (stepIdx < 3) {
      var st = FSTEPS[stepIdx];
      var startsPrefix = isSpanish ? 'inicia el ' : 'starts ';
      tag.textContent = currentCohort.name + ' · ' + startsPrefix + currentCohort.date;
      stepCount.textContent = isSpanish ? ('Paso ' + (stepIdx + 1) + ' de 3') : ('Step ' + (stepIdx + 1) + ' of 3');
      stepCount.style.display = 'inline';
      progressBar.style.display = 'flex';
      updateProgress(stepIdx + 1);

      var html = '<h2 class="mb24">' + st.title + '</h2>';
      html += '<div class="stack quiz-options">';
      st.options.forEach(function (opt, i) {
        var isSelected = answers[stepIdx] === i;
        html += '<button type="button" class="choice' + (isSelected ? ' sel' : '') + '" data-idx="' + i + '">';
        html += '<span>' + opt + '</span>';
        html += '<i class="radio-indicator"></i>';
        html += '</button>';
      });
      html += '</div>';
      body.innerHTML = html;

      // Attach click events on options
      var choiceBtns = body.querySelectorAll('.choice');
      choiceBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var chosen = parseInt(btn.dataset.idx, 10);
          answers[stepIdx] = chosen;
          renderStep();
        });
      });

      btnBack.disabled = (stepIdx === 0);
      if (stepIdx === 2) {
        btnNext.textContent = isSpanish ? 'Continuar a detalles' : 'Continue to details';
      } else {
        btnNext.textContent = isSpanish ? 'Continuar' : 'Continue';
      }
      btnNext.disabled = (answers[stepIdx] === undefined);
    } else {
      // Step 4: Contact details to book/hold place & save to DB
      renderLeadForm();
    }
  }

  // Step 4: Contact details form
  function renderLeadForm() {
    stepCount.textContent = isSpanish ? 'Paso final' : 'Final step';
    var startsPrefix = isSpanish ? 'inicia el ' : 'starts ';
    tag.textContent = currentCohort.name + ' · ' + startsPrefix + currentCohort.date;
    progressBar.style.display = 'none';

    var areaText = FSTEPS[0].options[answers[0]] || '';
    var timeText = FSTEPS[1].options[answers[1]] || '';
    var expText = FSTEPS[2].options[answers[2]] || '';

    var kickerText = isSpanish ? 'Aparta tu lugar' : 'Request your place';
    var titleText = isSpanish ? 'Un coach confirmará tu lugar' : 'A coach will confirm your place';
    var descText = isSpanish 
      ? (currentCohort.name + ', inicia el ' + currentCohort.date + '. Completa tus datos para registrar tu solicitud y apartar tu lugar para este evento.')
      : (currentCohort.name + ', starting ' + currentCohort.date + '. Complete your details to save your application and hold your spot.');

    var labelName = isSpanish ? 'Tu nombre completo *' : 'Your Full Name *';
    var labelEmail = isSpanish ? 'Correo electrónico *' : 'Email Address *';
    var labelPhone = isSpanish ? 'WhatsApp / Teléfono' : 'Phone Number (optional)';
    var phonePlaceholder = isSpanish ? '+52 55 1234 5678' : '+1 (555) 000-0000';

    var html = '<div class="lead-form-wrap">';
    html += '<div class="kicker" style="color:var(--shgreen)">' + kickerText + '</div>';
    html += '<h2 class="mt8">' + titleText + '</h2>';
    html += '<p class="sm mt8 text-muted">' + descText + '</p>';

    html += '<form id="cohortLeadForm" class="mt24">';
    html += '  <div class="field">';
    html += '    <label for="leadName">' + labelName + '</label>';
    html += '    <input type="text" id="leadName" class="input" placeholder="e.g. Jane Doe" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadEmail">' + labelEmail + '</label>';
    html += '    <input type="email" id="leadEmail" class="input" placeholder="jane@example.com" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadPhone">' + labelPhone + '</label>';
    html += '    <input type="tel" id="leadPhone" class="input" placeholder="' + phonePlaceholder + '">';
    html += '  </div>';
    html += '  <div id="cohortFormError" class="xs mt8" style="color:var(--red);display:none;"></div>';
    html += '</form>';
    html += '</div>';

    body.innerHTML = html;

    btnBack.disabled = false;
    btnNext.textContent = isSpanish ? 'Solicitar llamada' : 'Request a call';
    btnNext.disabled = false;
  }

  // Waitlist form for events with status waitlist
  function renderWaitlistForm() {
    stepCount.style.display = 'none';
    progressBar.style.display = 'none';
    tag.textContent = currentCohort.name;

    var kickerText = isSpanish ? 'Lista de espera' : 'Waiting List';
    var titleText = isSpanish ? ('Avisarme cuando abra ' + currentCohort.name) : ('Notify me when ' + currentCohort.name + ' opens');
    var descText = isSpanish 
      ? 'Deja tu correo para tener acceso prioritario antes de que se abran los registros generales para este evento.'
      : 'Leave your email to get early access before public registration opens.';

    var labelName = isSpanish ? 'Tu nombre completo *' : 'Your Name *';
    var labelEmail = isSpanish ? 'Correo electrónico *' : 'Email Address *';

    var html = '<div class="lead-form-wrap">';
    html += '<div class="kicker" style="color:var(--muted)">' + kickerText + '</div>';
    html += '<h2 class="mt8">' + titleText + '</h2>';
    html += '<p class="sm mt8 text-muted">' + descText + '</p>';

    html += '<form id="cohortLeadForm" class="mt24">';
    html += '  <div class="field">';
    html += '    <label for="leadName">' + labelName + '</label>';
    html += '    <input type="text" id="leadName" class="input" placeholder="e.g. Jane Doe" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadEmail">' + labelEmail + '</label>';
    html += '    <input type="email" id="leadEmail" class="input" placeholder="jane@example.com" required>';
    html += '  </div>';
    html += '  <div id="cohortFormError" class="xs mt8" style="color:var(--red);display:none;"></div>';
    html += '</form>';
    html += '</div>';

    body.innerHTML = html;

    btnBack.disabled = true;
    btnNext.textContent = isSpanish ? 'Avisarme' : 'Notify me';
    btnNext.disabled = false;
  }

  // Handle Next button click
  btnNext.addEventListener('click', function () {
    if (!currentCohort.isWaitlist && stepIdx < 3) {
      if (answers[stepIdx] === undefined) {
        alert(isSpanish ? 'Por favor selecciona una opción para continuar.' : 'Please select an option to continue.');
        return;
      }
      stepIdx++;
      renderStep();
      return;
    }

    // Submit Lead / Waitlist Form via AJAX
    var nameInput = document.getElementById('leadName');
    var emailInput = document.getElementById('leadEmail');
    var phoneInput = document.getElementById('leadPhone');
    var errorDiv = document.getElementById('cohortFormError');

    if (!nameInput || !emailInput) return;

    var nameVal = nameInput.value.trim();
    var emailVal = emailInput.value.trim();
    var phoneVal = phoneInput ? phoneInput.value.trim() : '';

    if (!nameVal) {
      if (errorDiv) {
        errorDiv.textContent = isSpanish ? 'Por favor ingresa tu nombre completo.' : 'Please enter your full name.';
        errorDiv.style.display = 'block';
      }
      nameInput.focus();
      return;
    }

    if (!emailVal || emailVal.indexOf('@') === -1) {
      if (errorDiv) {
        errorDiv.textContent = isSpanish ? 'Por favor ingresa un correo electrónico válido.' : 'Please enter a valid email address.';
        errorDiv.style.display = 'block';
      }
      emailInput.focus();
      return;
    }

    var formData = new FormData();
    formData.append('action', 'zol_submit_cohort_lead');
    var nonce = (window.zolData && window.zolData.nonce) ? window.zolData.nonce : '';
    formData.append('nonce', nonce);
    formData.append('name', nameVal);
    formData.append('email', emailVal);
    formData.append('phone', phoneVal);
    formData.append('cohort_id', currentCohort.id);
    formData.append('cohort_name', currentCohort.name);

    if (!currentCohort.isWaitlist) {
      var areaText = FSTEPS[0].options[answers[0]] || '';
      var timeText = FSTEPS[1].options[answers[1]] || '';
      var expText = FSTEPS[2].options[answers[2]] || '';
      formData.append('area', areaText);
      formData.append('time', timeText);
      formData.append('exp', expText);
    } else {
      formData.append('area', 'Waitlist');
      formData.append('time', 'N/A');
      formData.append('exp', 'N/A');
    }

    btnNext.disabled = true;
    btnNext.textContent = isSpanish ? 'Guardando registro...' : 'Saving application...';

    var ajaxUrl = (window.zolData && window.zolData.ajaxUrl) ? window.zolData.ajaxUrl : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
      method: 'POST',
      body: formData
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (data.success) {
          // Render success message
          footer.style.display = 'none';
          stepCount.style.display = 'none';

          var requestedText = isSpanish ? 'Registrado' : 'Requested';
          var confirmTitle = isSpanish ? 'Un coach confirmará tu lugar' : 'A coach will confirm your place';
          var thankMsg = isSpanish
            ? ('Gracias, <strong>' + escapeHtml(nameVal) + '</strong>. Tu registro para <strong>' + escapeHtml(currentCohort.name) + '</strong> (inicia ' + escapeHtml(currentCohort.date) + ') ha sido recibido en el sistema.')
            : ('Thank you, <strong>' + escapeHtml(nameVal) + '</strong>. Your application for <strong>' + escapeHtml(currentCohort.name) + '</strong> (starts ' + escapeHtml(currentCohort.date) + ') has been registered in the system.');
          var confirmSub = isSpanish
            ? 'Hemos registrado tu solicitud y un asesor se comunicará contigo en breve para apartar tu lugar.'
            : 'A confirmation has been sent and an advisor will reach out shortly to hold your spot.';
          var doneLabel = isSpanish ? 'Entendido' : 'Done';

          var successHtml = '<div class="card tint pad-lg quiz-success-card mt16">';
          successHtml += '  <div class="kicker" style="color:var(--shgreen)">' + requestedText + '</div>';
          successHtml += '  <h2 class="mt8">' + confirmTitle + '</h2>';
          successHtml += '  <p class="sm mt16">' + thankMsg + '</p>';
          successHtml += '  <p class="xs mt8 text-muted">' + confirmSub + '</p>';
          successHtml += '  <button type="button" class="btn btn-go mt24 js-close-quiz">' + doneLabel + '</button>';
          successHtml += '</div>';

          body.innerHTML = successHtml;

          var doneBtn = body.querySelector('.js-close-quiz');
          if (doneBtn) {
            doneBtn.addEventListener('click', closeModal);
          }
        } else {
          if (errorDiv) {
            errorDiv.textContent = data.data && data.data.message ? data.data.message : (isSpanish ? 'Error al guardar el registro. Intenta de nuevo.' : 'Error saving application. Please try again.');
            errorDiv.style.display = 'block';
          }
          btnNext.disabled = false;
          btnNext.textContent = currentCohort.isWaitlist ? (isSpanish ? 'Avisarme' : 'Notify me') : (isSpanish ? 'Solicitar llamada' : 'Request a call');
        }
      })
      .catch(function (err) {
        if (errorDiv) {
          errorDiv.textContent = isSpanish ? 'Error de conexión. Por favor intenta de nuevo.' : 'Connection error. Please try again.';
          errorDiv.style.display = 'block';
        }
        btnNext.disabled = false;
        btnNext.textContent = currentCohort.isWaitlist ? (isSpanish ? 'Avisarme' : 'Notify me') : (isSpanish ? 'Solicitar llamada' : 'Request a call');
      });
  });

  // Handle Back button click
  btnBack.addEventListener('click', function () {
    if (stepIdx > 0) {
      stepIdx--;
      renderStep();
    }
  });

  // Trigger buttons on page
  document.addEventListener('click', function (e) {
    var quizBtn = e.target.closest('.js-trigger-cohort-quiz');
    if (quizBtn) {
      e.preventDefault();
      openModal({
        id: quizBtn.dataset.cohortId || 0,
        name: quizBtn.dataset.cohortName || (isSpanish ? 'Evento de otoño' : 'Autumn event'),
        date: quizBtn.dataset.cohortDate || '14 October',
        isWaitlist: false
      });
      return;
    }

    var waitlistBtn = e.target.closest('.js-trigger-cohort-waitlist');
    if (waitlistBtn) {
      e.preventDefault();
      openModal({
        id: waitlistBtn.dataset.cohortId || 0,
        name: waitlistBtn.dataset.cohortName || (isSpanish ? 'Evento de invierno' : 'Winter event'),
        date: waitlistBtn.dataset.cohortDate || '20 January',
        isWaitlist: true
      });
      return;
    }

    if (e.target.closest('.js-close-quiz')) {
      e.preventDefault();
      closeModal();
    }
  });

  // Escape key closes modal
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.hidden) {
      closeModal();
    }
  });

  function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
});
