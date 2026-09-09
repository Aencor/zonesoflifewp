/**
 * Cohorts In-Page Qualification Quiz & Application Handler
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

  var FSTEPS = [
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
    name: 'Autumn cohort',
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
      tag.textContent = currentCohort.name + ' · starts ' + currentCohort.date;
      stepCount.textContent = 'Step ' + (stepIdx + 1) + ' of 3';
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
      btnNext.textContent = (stepIdx === 2) ? 'Continue to details' : 'Continue';
      btnNext.disabled = (answers[stepIdx] === undefined);
    } else {
      // Step 4: Contact details to book/hold place & save to DB
      renderLeadForm();
    }
  }

  // Step 4: Contact details form
  function renderLeadForm() {
    stepCount.textContent = 'Final step';
    tag.textContent = currentCohort.name + ' · starts ' + currentCohort.date;
    progressBar.style.display = 'none';

    var areaText = FSTEPS[0].options[answers[0]] || '';
    var timeText = FSTEPS[1].options[answers[1]] || '';
    var expText = FSTEPS[2].options[answers[2]] || '';

    var html = '<div class="lead-form-wrap">';
    html += '<div class="kicker" style="color:var(--shgreen)">Request your place</div>';
    html += '<h2 class="mt8">A coach will confirm your place</h2>';
    html += '<p class="sm mt8 text-muted">' + currentCohort.name + ', starting ' + currentCohort.date + '. Complete your details to save your application and hold your spot.</p>';

    html += '<form id="cohortLeadForm" class="mt24">';
    html += '  <div class="field">';
    html += '    <label for="leadName">Your Full Name *</label>';
    html += '    <input type="text" id="leadName" class="input" placeholder="e.g. Jane Doe" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadEmail">Email Address *</label>';
    html += '    <input type="email" id="leadEmail" class="input" placeholder="jane@example.com" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadPhone">Phone Number (optional)</label>';
    html += '    <input type="tel" id="leadPhone" class="input" placeholder="+1 (555) 000-0000">';
    html += '  </div>';
    html += '  <div id="cohortFormError" class="xs mt8" style="color:var(--red);display:none;"></div>';
    html += '</form>';
    html += '</div>';

    body.innerHTML = html;

    btnBack.disabled = false;
    btnNext.textContent = 'Request a call';
    btnNext.disabled = false;
  }

  // Waitlist form for cohorts with status waitlist
  function renderWaitlistForm() {
    stepCount.style.display = 'none';
    progressBar.style.display = 'none';
    tag.textContent = currentCohort.name;

    var html = '<div class="lead-form-wrap">';
    html += '<div class="kicker" style="color:var(--muted)">Waiting List</div>';
    html += '<h2 class="mt8">Notify me when ' + currentCohort.name + ' opens</h2>';
    html += '<p class="sm mt8 text-muted">Leave your email to get early access before public registration opens.</p>';

    html += '<form id="cohortLeadForm" class="mt24">';
    html += '  <div class="field">';
    html += '    <label for="leadName">Your Name *</label>';
    html += '    <input type="text" id="leadName" class="input" placeholder="e.g. Jane Doe" required>';
    html += '  </div>';
    html += '  <div class="field">';
    html += '    <label for="leadEmail">Email Address *</label>';
    html += '    <input type="email" id="leadEmail" class="input" placeholder="jane@example.com" required>';
    html += '  </div>';
    html += '  <div id="cohortFormError" class="xs mt8" style="color:var(--red);display:none;"></div>';
    html += '</form>';
    html += '</div>';

    body.innerHTML = html;

    btnBack.disabled = true;
    btnNext.textContent = 'Notify me';
    btnNext.disabled = false;
  }

  // Handle Next button click
  btnNext.addEventListener('click', function () {
    if (!currentCohort.isWaitlist && stepIdx < 3) {
      if (answers[stepIdx] === undefined) {
        alert('Please select an option to continue.');
        return;
      }
      stepIdx++;
      renderStep();
      return;
    }

    // Submit Lead Form
    var nameInput = document.getElementById('leadName');
    var emailInput = document.getElementById('leadEmail');
    var phoneInput = document.getElementById('leadPhone');
    var errorDiv = document.getElementById('cohortFormError');

    if (!nameInput || !emailInput) return;

    var nameVal = nameInput.value.trim();
    var emailVal = emailInput.value.trim();
    var phoneVal = phoneInput ? phoneInput.value.trim() : '';

    if (!nameVal || !emailVal) {
      if (errorDiv) {
        errorDiv.textContent = 'Please fill in both your name and email address.';
        errorDiv.style.display = 'block';
      }
      return;
    }

    // Prepare FormData
    var formData = new FormData();
    formData.append('action', 'zol_submit_cohort_lead');
    if (window.zolData && window.zolData.nonce) {
      formData.append('nonce', window.zolData.nonce);
    }
    formData.append('name', nameVal);
    formData.append('email', emailVal);
    formData.append('phone', phoneVal);
    formData.append('cohort_id', currentCohort.id);
    formData.append('cohort_name', currentCohort.name);

    if (!currentCohort.isWaitlist) {
      formData.append('area', FSTEPS[0].options[answers[0]] || '');
      formData.append('time', FSTEPS[1].options[answers[1]] || '');
      formData.append('exp', FSTEPS[2].options[answers[2]] || '');
    } else {
      formData.append('area', 'Waiting List Registration');
      formData.append('time', 'N/A');
      formData.append('exp', 'N/A');
    }

    btnNext.disabled = true;
    btnNext.textContent = 'Saving application...';

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

          var successHtml = '<div class="card tint pad-lg quiz-success-card mt16">';
          successHtml += '  <div class="kicker" style="color:var(--shgreen)">Requested</div>';
          successHtml += '  <h2 class="mt8">A coach will confirm your place</h2>';
          successHtml += '  <p class="sm mt16">Thank you, <strong>' + escapeHtml(nameVal) + '</strong>. Your application for <strong>' + escapeHtml(currentCohort.name) + '</strong> (starts ' + escapeHtml(currentCohort.date) + ') has been registered in the system.</p>';
          successHtml += '  <p class="xs mt8 text-muted">A confirmation has been sent and an advisor will reach out shortly to hold your spot.</p>';
          successHtml += '  <button type="button" class="btn btn-go mt24 js-close-quiz">Done</button>';
          successHtml += '</div>';

          body.innerHTML = successHtml;

          var doneBtn = body.querySelector('.js-close-quiz');
          if (doneBtn) {
            doneBtn.addEventListener('click', closeModal);
          }
        } else {
          if (errorDiv) {
            errorDiv.textContent = data.data && data.data.message ? data.data.message : 'Error saving application. Please try again.';
            errorDiv.style.display = 'block';
          }
          btnNext.disabled = false;
          btnNext.textContent = currentCohort.isWaitlist ? 'Notify me' : 'Request a call';
        }
      })
      .catch(function (err) {
        if (errorDiv) {
          errorDiv.textContent = 'Connection error. Please try again.';
          errorDiv.style.display = 'block';
        }
        btnNext.disabled = false;
        btnNext.textContent = currentCohort.isWaitlist ? 'Notify me' : 'Request a call';
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
        name: quizBtn.dataset.cohortName || 'Autumn cohort',
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
        name: waitlistBtn.dataset.cohortName || 'Winter cohort',
        date: waitlistBtn.dataset.cohortDate || '20 January',
        isWaitlist: true
      });
      return;
    }

    if (e.target.closest('.js-close-quiz')) {
      e.preventDefault();
      closeModal();
      return;
    }
  });

  // ESC key to close
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
