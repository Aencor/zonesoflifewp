/**
 * Personal Zones Profile Assessment Engine
 */
document.addEventListener('DOMContentLoaded', function () {
  var quizSection = document.getElementById('quiz');
  if (!quizSection) return;

  var i18n = (window.zolQuizData && window.zolQuizData.isSpanish) ? window.zolQuizData : null;

  var Q = (i18n && i18n.questions) ? i18n.questions : [
    { a: "Life & Skills", ab: "Produce", t: "Do you complete activities quickly?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", ab: "Focus", t: "Are you positioned for success?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", ab: "Investigate", t: "Do you perceive other people's games?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", ab: "Have", t: "Do you drive a luxury car?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", ab: "Focus", t: "Is your future uncertain?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", ab: "Produce", t: "Do you like to have a lot of action?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", ab: "Have", t: "Do you go into debt at the end of the year?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", ab: "Investigate", t: "Do you tend to misperceive people?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", ab: "Have", t: "Do you travel in economy class instead of first class?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", ab: "Have", t: "Are you unsure about your material desires?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", ab: "Invest", t: "Do you wish you were living your dream?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", ab: "Produce", t: "Has your career become less than what you wanted?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", ab: "Invest", t: "Do you wish you had acted faster?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", ab: "Invest", t: "Will your career provide you with future wealth?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", ab: "Focus", t: "Do you always strive to be the best you can be?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", ab: "Investigate", t: "Do you dislike people?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", ab: "Invest", t: "Do you take action to up your game?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", ab: "Investigate", t: "Do you feel you know more than others, even those more successful than you?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", ab: "Focus", t: "Do you like staying close to home during holidays?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", ab: "Focus", t: "Are you easily distracted?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] }
  ];

  var ZONE = (i18n && i18n.zones) ? i18n.zones : {
    1: { n: "Red", i: 1, col: "var(--red)" },
    2: { n: "Yellow", i: 2, col: "#B98F0C" },
    3: { n: "Green", i: 3, col: "var(--shgreen)" },
    4: { n: "Golden Magic", i: 4, col: "#8A7440" }
  };

  var COPY = (i18n && i18n.copy) ? i18n.copy : {
    "Red": "This is someone who is in the wrong place at the wrong time, connected to the wrong people. Effort produces little, because you are reacting to what happens instead of directing it.",
    "Yellow": "This is the “daily grind” or “rut” where the person doesn’t take risks but works only for security. Awake, but change still depends on how you feel that day.",
    "Green": "This is someone who is in the right place at the right time, making things go right. This person is living their dream. Results arrive consistently because structure holds them, not willpower.",
    "Golden Magic": "You are outside of the physical universe. You operate above the laws of the physical universe and are totally telepathic. Mastery in your Zone reliably."
  };

  var ABILITY_QUOTES = (i18n && i18n.ability_quotes) ? i18n.ability_quotes : {
    "Have": "You can earn more and still end up with nothing: if you don't feel entitled to keep it, money finds its own way out.",
    "Investigate": "Expensive decisions are rarely made for lack of money. They're made for lack of questions before signing.",
    "Focus": "Your attention is spread across so many fronts that none of them reaches the point where results start.",
    "Invest": "Your time, your energy and your money are already invested in something. The question is whether it's giving anything back.",
    "Produce": "You're busy most of the day and still find it hard to point at what you produced this week.",
    "Create Wealth": "It can't be trained on its own: it's the average of the other five, showing you the result of all of them together."
  };

  var LBL = (i18n && i18n.labels) ? i18n.labels : {
    area: 'Area: ',
    you_are_in: 'You are in the ',
    you_are_here: ' · you are here',
    start_here: ' · lowest ability',
    privacy_error: 'Please accept the Privacy Policy to view your result.',
    email_error: 'Please enter a valid email address.',
    phone_error: 'Please enter a valid phone or WhatsApp number.',
    email_sent: '✓ Sent to your email',
    gap_template: "What this result still doesn't tell you: why {ability} sits where it does, which of the other five is dragging it down, and which first move has the most impact. That's in your Financial Health Profile: 100 questions, your full chart, the report on all six abilities, the Financial Fitness Workbook and Alan C. Walter's audio lesson.",
    area_names: {}
  };

  var answers = [];
  var idx = 0;
  var lastLeadData = null;

  var intro = document.getElementById('quizIntro');
  var run = document.getElementById('quizRun');
  var gate = document.getElementById('quizGate');
  var res = document.getElementById('quizResult');

  var btnStart = document.getElementById('startQuiz');
  var btnBack = document.getElementById('qBack');
  var btnGateGo = document.getElementById('gGo');
  var btnRetake = document.getElementById('retake');
  var btnEmailMe = document.getElementById('rBtnEmailMe');

  var qArea = document.getElementById('qArea');
  var qCount = document.getElementById('qCount');
  var qBar = document.getElementById('qBar');
  var qText = document.getElementById('qText');
  var qOpts = document.getElementById('qOpts');

  function startAssessment() {
    intro.hidden = true;
    res.hidden = true;
    gate.hidden = true;
    run.hidden = false;
    answers = new Array(Q.length);
    idx = 0;
    renderQuestion();
    quizSection.scrollIntoView({ behavior: 'smooth' });
  }

  if (btnStart) {
    btnStart.addEventListener('click', startAssessment);
  }

  // Handle scroll and start from external buttons (.js-scroll-to-quiz or header #quiz)
  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('.js-scroll-to-quiz, a[href="#quiz"], a[href$="/assessment/#quiz"]');
    if (trigger && quizSection) {
      e.preventDefault();
      startAssessment();
    }
  });

  function renderQuestion() {
    var q = Q[idx];
    qCount.textContent = (idx + 1) + ' / ' + Q.length;
    qArea.textContent = (LBL.area_names && LBL.area_names[q.a]) ? LBL.area_names[q.a] : q.a;
    qBar.style.width = Math.round(((idx + 1) / Q.length) * 100) + '%';
    qText.textContent = q.t;

    qOpts.innerHTML = '';
    q.o.forEach(function (opt) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'btn btn-ghost btn-block q-btn' + (answers[idx] === opt[1] ? ' active' : '');
      btn.textContent = opt[0];
      btn.addEventListener('click', function () {
        selectOption(opt[1]);
      });
      qOpts.appendChild(btn);
    });

    if (btnBack) {
      btnBack.style.visibility = (idx > 0) ? 'visible' : 'hidden';
    }
  }

  function selectOption(val) {
    answers[idx] = val;
    if (idx < Q.length - 1) {
      idx++;
      renderQuestion();
    } else {
      finishQuestions();
    }
  }

  if (btnBack) {
    btnBack.addEventListener('click', function () {
      if (idx > 0) {
        idx--;
        renderQuestion();
      }
    });
  }

  function finishQuestions() {
    run.hidden = true;
    gate.hidden = false;
    quizSection.scrollIntoView({ behavior: 'smooth' });
  }

  function scoreAbility(abKey) {
    var vals = [];
    Q.forEach(function (item, i) {
      if (item.ab === abKey && answers[i]) {
        vals.push(answers[i]);
      }
    });
    if (!vals.length) return 2;
    return Math.round(vals.reduce(function (a, b) { return a + b; }, 0) / vals.length);
  }

  function renderResult(nameVal, emailVal, phoneVal, waOptinVal) {
    var isEs = !!i18n;
    var baseAbilities = isEs
      ? [
          { key: "Tener", label: "Tener" },
          { key: "Investigar", label: "Investigar" },
          { key: "Enfocarse", label: "Enfocarse" },
          { key: "Invertir", label: "Invertir" },
          { key: "Producir", label: "Producir" }
        ]
      : [
          { key: "Have", label: "Have" },
          { key: "Investigate", label: "Investigate" },
          { key: "Focus", label: "Focus" },
          { key: "Invest", label: "Invest" },
          { key: "Produce", label: "Produce" }
        ];

    var abilityScores = baseAbilities.map(function (ab) {
      return scoreAbility(ab.key);
    });

    var sum = abilityScores.reduce(function (a, b) { return a + b; }, 0);
    var createWealthScore = Math.max(1, Math.min(4, Math.round(sum / abilityScores.length)));
    var createWealthKey = isEs ? "Crear riqueza" : "Create Wealth";

    var allAbilities = baseAbilities.concat([{ key: createWealthKey, label: createWealthKey }]);
    var allScores = abilityScores.concat([createWealthScore]);

    // Overall zone score
    var overallScore = Math.max(1, Math.min(4, Math.round(allScores.reduce(function (a, b) { return a + b; }, 0) / allScores.length)));
    var z = ZONE[overallScore] || ZONE[2];

    // Find lowest ability (among base 5 abilities first, to give actionable focus)
    var lowestBaseScore = Math.min.apply(null, abilityScores);
    var lowestBaseIdx = abilityScores.indexOf(lowestBaseScore);
    var worstAbilityObj = baseAbilities[lowestBaseIdx];
    var worstAbilityName = worstAbilityObj.label;
    var worstQuote = ABILITY_QUOTES[worstAbilityObj.key] || "";

    // DOM Elements - R1 Layout
    var rUserName = document.getElementById('rUserName');
    var rLowestAbility = document.getElementById('rLowestAbility');
    var rAbilityQuote = document.getElementById('rAbilityQuote');
    var rAbilitiesBreakdown = document.getElementById('rAbilitiesBreakdown');
    var rZoneName = document.getElementById('rZoneName');
    var rZoneScoreLabel = document.getElementById('rZoneScoreLabel');
    var rBar = document.getElementById('rBar');
    var rBody = document.getElementById('rBody');

    if (rUserName) {
      rUserName.textContent = nameVal;
    }
    if (rLowestAbility) {
      rLowestAbility.textContent = worstAbilityName;
    }
    if (rAbilityQuote) {
      rAbilityQuote.textContent = worstQuote ? '“' + worstQuote + '”' : '';
    }

    if (rAbilitiesBreakdown) {
      var abHtml = '';
      allAbilities.forEach(function (ab, i) {
        var score = allScores[i];
        var zz = ZONE[score] || ZONE[2];
        var isLowest = (ab.key === worstAbilityObj.key);
        abHtml += '<div class="row ability-score-row" style="padding:12px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;">';
        abHtml += '  <div class="grow" style="font-weight:600;font-size:15px;color:var(--ink);display:flex;align-items:center;gap:8px;">';
        abHtml += '    <span>' + ab.label + '</span>';
        if (i === 5) {
          abHtml += '    <span class="tiny text-muted" style="font-size:11px;font-weight:400;">(' + (isEs ? 'promedio' : 'average') + ')</span>';
        }
        abHtml += '  </div>';
        abHtml += '  <span class="tiny" style="color:' + zz.col + ';font-weight:700;letter-spacing:0.06em;">' + zz.n + (isLowest ? LBL.start_here : '') + '</span>';
        abHtml += '</div>';
      });
      rAbilitiesBreakdown.innerHTML = abHtml;
    }

    var rGapCopy = document.getElementById('rGapCopy');
    if (rGapCopy && LBL.gap_template) {
      rGapCopy.textContent = LBL.gap_template.replace('{ability}', worstAbilityName);
    }

    if (rZoneName) {
      rZoneName.textContent = z.n;
    }
    if (rZoneScoreLabel) {
      rZoneScoreLabel.textContent = (isEs ? 'Nivel ' : 'Level ') + overallScore + ' / 4';
    }
    if (rBar) {
      var barHtml = '<div class="zones dim">';
      for (var b = 1; b <= 4; b++) {
        barHtml += '<i class="z' + b + (b <= z.i ? ' on' : '') + '"></i>';
      }
      barHtml += '</div>';
      rBar.innerHTML = barHtml;
    }
    if (rBody) {
      rBody.textContent = COPY[z.n] || COPY["Yellow"] || COPY["Amarilla"];
    }

    gate.hidden = true;
    res.hidden = false;
    quizSection.scrollIntoView({ behavior: 'smooth' });

    lastLeadData = {
      name: nameVal,
      email: emailVal,
      phone: phoneVal,
      whatsapp_optin: waOptinVal ? '1' : '0',
      zone: z.n,
      lowest_ability: worstAbilityName,
      lowest_ability_quote: worstQuote,
      lang: isEs ? 'es' : 'en'
    };

    // Send to database
    var formData = new FormData();
    formData.append('action', 'zol_submit_assessment_lead');
    if (window.zolData && window.zolData.nonce) {
      formData.append('nonce', window.zolData.nonce);
    }
    formData.append('name', nameVal);
    formData.append('email', emailVal);
    formData.append('phone', phoneVal);
    formData.append('whatsapp_optin', waOptinVal ? '1' : '0');
    formData.append('zone', z.n);
    formData.append('lowest_ability', worstAbilityName);
    formData.append('lowest_ability_quote', worstQuote);
    formData.append('lang', isEs ? 'es' : 'en');
    allAbilities.forEach(function(ab, idx) {
      formData.append('ability_' + ab.key.toLowerCase().replace(/\s+/g, '_'), allScores[idx]);
    });

    var ajaxUrl = (window.zolData && window.zolData.ajaxUrl) ? window.zolData.ajaxUrl : '/wp-admin/admin-ajax.php';
    fetch(ajaxUrl, { method: 'POST', body: formData });
  }

  if (btnGateGo) {
    btnGateGo.addEventListener('click', function () {
      var gOk = document.getElementById('gOk');
      var gWaOptin = document.getElementById('gWaOptin');
      var gName = document.getElementById('gName');
      var gMail = document.getElementById('gMail');
      var gPhone = document.getElementById('gPhone');
      var err = document.getElementById('quizGateError');

      if (gOk && !gOk.checked) {
        if (err) {
          err.textContent = LBL.privacy_error;
          err.style.display = 'block';
        }
        return;
      }

      var emailVal = gMail ? gMail.value.trim() : '';
      var phoneVal = gPhone ? gPhone.value.trim() : '';
      var nameVal = gName ? gName.value.trim() : (i18n ? 'Participante' : 'Participant');
      var waOptinVal = gWaOptin ? gWaOptin.checked : true;

      if (!emailVal || emailVal.indexOf('@') < 1 || emailVal.indexOf('.') < 0) {
        if (err) {
          err.textContent = LBL.email_error;
          err.style.display = 'block';
        }
        if (gMail) gMail.focus();
        return;
      }

      if (!phoneVal || phoneVal.length < 7) {
        if (err) {
          err.textContent = LBL.phone_error || 'Por favor ingresa un número de teléfono válido.';
          err.style.display = 'block';
        }
        if (gPhone) gPhone.focus();
        return;
      }

      if (err) err.style.display = 'none';
      renderResult(nameVal, emailVal, phoneVal, waOptinVal);
    });
  }

  if (btnEmailMe) {
    btnEmailMe.addEventListener('click', function () {
      if (!lastLeadData) return;
      btnEmailMe.disabled = true;
      var emailSentMsg = document.getElementById('rEmailSentMsg');
      if (emailSentMsg) emailSentMsg.style.display = 'block';

      var sendData = new FormData();
      sendData.append('action', 'zol_email_mini_profile');
      if (window.zolData && window.zolData.nonce) {
        sendData.append('nonce', window.zolData.nonce);
      }
      sendData.append('name', lastLeadData.name);
      sendData.append('email', lastLeadData.email);
      sendData.append('lowest_ability', lastLeadData.lowest_ability);
      sendData.append('lowest_ability_quote', lastLeadData.lowest_ability_quote);
      sendData.append('lang', lastLeadData.lang || 'en');

      var ajaxUrl = (window.zolData && window.zolData.ajaxUrl) ? window.zolData.ajaxUrl : '/wp-admin/admin-ajax.php';
      fetch(ajaxUrl, { method: 'POST', body: sendData });
    });
  }

  if (btnRetake) {
    btnRetake.addEventListener('click', function () {
      res.hidden = true;
      run.hidden = true;
      gate.hidden = true;
      intro.hidden = false;
      answers = [];
      idx = 0;
      quizSection.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // Check URL hash for direct #quiz trigger
  if (window.location.hash === '#quiz') {
    startAssessment();
  }
});
