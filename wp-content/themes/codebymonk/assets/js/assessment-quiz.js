/**
 * Personal Zones Profile Assessment Engine
 */
document.addEventListener('DOMContentLoaded', function () {
  var quizSection = document.getElementById('quiz');
  if (!quizSection) return;

  var isEs = (window.zolQuizData && window.zolQuizData.isSpanish === true);
  var i18n = window.zolQuizData || null;

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

  var HAVE_LEVELS = (i18n && i18n.have_levels) ? i18n.have_levels : {
    low_yellow: {
      name: "Working not to have",
      title: "Level: Working not to have",
      short: 'Your score sits below the Yellow Zone\'s centerline: today you are working "not to have". It\'s not a lack of effort. It\'s an active negative process steering you away from what you desire even as you chase it, and it can be changed.',
      full: 'WORKING NOT TO HAVE. If your score sits below the dark centerline running horizontally across the Yellow Zone, you are working "not to have". Most people CANNOT HAVE. It doesn\'t matter if they hold it physically... they cannot truly have it. They don\'t feel worthy enough. They don\'t feel good enough. They feel they shouldn\'t obtain what they are reaching for and feel they don\'t deserve it. Typically, they have been programmed with messages like "you\'re worth nothing" or "you\'re useless". That is the result of heavy negative processing making a person feel that way. The fundamental negative process governing their lives is: "You can\'t be this, you can\'t do this, you can\'t have this. You can\'t have your dreams. You cannot be, you cannot do, and you cannot have." NEGATIVE PROCESS: a series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take. A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.'
    },
    high_yellow: {
      name: "Struggling to have",
      title: "Level: Struggling to have",
      short: 'Your score sits in the upper half of the Yellow Zone: you are struggling "to have". You make progress, but every win costs you more than it should because you\'re carrying learned rules about what can\'t or shouldn\'t be done.',
      full: 'STRUGGLING TO HAVE. If your score sits above the dark centerline running horizontally across the Yellow Zone, yet remains within the Yellow Zone, you are struggling "to have". Life, family, parents, or social groups have negatively processed you by dictating what cannot be done, why it cannot be done, and what must not be done. In environments like this, external power or force is exerted to dictate what is right and how one must act or behave. NEGATIVE PROCESS: a series of actions, changes, or functions that prevent or pull you away from achieving the result or purpose you desire. It is a continuous, downward motion deviating you from the path you truly intended to take. A negative process is composed of dishonest, dishonorable, out-purpose, or off-course actions generating cycles of behavior or decisions that produce a negative or sub-optimal outcome.'
    },
    green: {
      name: "You have the ability to have",
      title: "Level: You have the ability to have",
      short: 'Your score is in the Green Zone: you have the capacity "to have". Your environment operates in harmony with you and you\'ve built positive processes. The next step is doubling down on what already works to expand your game.',
      full: 'YOU HAVE THE ABILITY TO HAVE. Congratulations! If your score is in the Green Zone, you have the ability "to have"; the higher you are in the Green Zone, the greater your capacity to have everything you desire. Your environment operates in steady harmony with you, and you have received abundant positive processing. POSITIVE PROCESS: a series of positive actions, changes, or functions that lead you directly to achieving the positive result or purpose you set out for. It is a continuous, upward motion in the direction you decided to pursue. It is defined as a series of honest, high-integrity actions aligned with your goals and purpose, producing operating cycles that culminate in an optimal, positive final product or result. Remember that two things are vital to accumulating wealth: first is discipline, and second is duplication. If you have those two, you can succeed at any moment. If you are in the Green Zone, you have the ability to have! Execute more of the successful actions you are already taking to expand your game.'
    }
  };

  var LBL = (i18n && i18n.labels) ? i18n.labels : {
    area: 'Area: ',
    you_are_in: 'You are in the ',
    you_are_here: ' · you are here',
    start_here: ' · evaluated ability',
    privacy_error: 'Please accept the Privacy Policy to view your result.',
    email_error: 'Please enter a valid email address.',
    phone_error: 'Please enter a valid phone or WhatsApp number.',
    email_sent: '✓ Sent to your email',
    gap_template: "Having is one of the six abilities that form your financial health. The other five are Producing, Focusing, Investigating, Investing, and Creating Wealth. Your Financial Health Profile measures all six, shows you which one is holding you back the most, and gives you tools to elevate it.",
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
    var searchKey = (abKey || '').toLowerCase();
    Q.forEach(function (item, i) {
      var itemAb = (item.ab || '').toLowerCase();
      if ((itemAb === searchKey || itemAb.indexOf(searchKey) === 0 || searchKey.indexOf(itemAb) === 0) && answers[i]) {
        vals.push(answers[i]);
      }
    });
    if (!vals.length) return 2;
    return Math.round(vals.reduce(function (a, b) { return a + b; }, 0) / vals.length);
  }

  function scoreArea(areaKey) {
    var vals = [];
    var searchKey = (areaKey || '').toLowerCase();
    Q.forEach(function (item, i) {
      var itemA = (item.a || '').toLowerCase();
      if ((itemA === searchKey || itemA.indexOf(searchKey) === 0 || searchKey.indexOf(itemA) === 0) && answers[i]) {
        vals.push(answers[i]);
      }
    });
    if (!vals.length) return 2;
    return Math.round(vals.reduce(function (a, b) { return a + b; }, 0) / vals.length);
  }

  function renderResult(nameVal, emailVal, phoneVal, waOptinVal) {
    var isEs = (window.zolQuizData && window.zolQuizData.isSpanish === true) || (i18n && i18n.isSpanish === true) || (document.documentElement.lang && document.documentElement.lang.indexOf('es') === 0);
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

    // Areas breakdown & scores
    var areas = ["Financial", "Life & Skills", "Body"];
    var areaScores = areas.map(scoreArea);
    var worstAreaIdx = areaScores.indexOf(Math.min.apply(null, areaScores));

    // Overall zone score
    var overallScore = Math.max(1, Math.min(4, Math.round(allScores.reduce(function (a, b) { return a + b; }, 0) / allScores.length)));
    var z = ZONE[overallScore] || ZONE[2];

    // Find lowest ability (among base 5 abilities first, to give actionable focus)
    var lowestBaseScore = Math.min.apply(null, abilityScores);
    var lowestBaseIdx = abilityScores.indexOf(lowestBaseScore);
    var worstAbilityObj = baseAbilities[lowestBaseIdx];
    var worstAbilityName = worstAbilityObj.label;
    var worstQuote = ABILITY_QUOTES[worstAbilityObj.key] || "";

    // Calculate Have Ability Level (abilityScores[0] corresponds to Tener/Have)
    var haveVals = [];
    Q.forEach(function (item, qIdx) {
      var itemAb = (item.ab || '').toLowerCase();
      if ((itemAb === 'have' || itemAb === 'tener') && answers[qIdx]) {
        haveVals.push(answers[qIdx]);
      }
    });
    var haveAvg = haveVals.length ? (haveVals.reduce(function (a, b) { return a + b; }, 0) / haveVals.length) : (abilityScores[0] || 2);
    
    // Determine level key
    var haveLevelKey = (haveAvg >= 3.0) ? 'green' : ((haveAvg >= 2.25) ? 'high_yellow' : 'low_yellow');
    var haveLevelObj = HAVE_LEVELS[haveLevelKey] || HAVE_LEVELS.low_yellow;

    // Numerical score for line positioning on the -10000..+10000 chart
    var haveNumericScore;
    if (haveAvg >= 3.0) {
      haveNumericScore = 60 + ((haveAvg - 3.0) / 1.0) * 35; // 60 to 95 (Green Zone)
    } else if (haveAvg >= 2.25) {
      haveNumericScore = 30 + ((haveAvg - 2.25) / 0.75) * 30; // 30 to 60 (Upper Yellow Zone)
    } else if (haveAvg >= 1.4) {
      haveNumericScore = 0 + ((haveAvg - 1.4) / 0.85) * 30; // 0 to 30 (Lower Yellow Zone)
    } else {
      haveNumericScore = -100 + ((haveAvg - 1.0) / 0.4) * 100; // -100 to 0 (Red Zone)
    }

    // DOM Elements - R1 Layout
    var rUserName = document.getElementById('rUserName');
    var rZone = document.getElementById('rZone');
    var rHere = document.getElementById('rHere');
    var rBar = document.getElementById('rBar');
    var rBody = document.getElementById('rBody');
    var rAreas = document.getElementById('rAreas');
    var rLevelBadge = document.getElementById('rLevelBadge');
    var rLevelTitle = document.getElementById('rLevelTitle');
    var rLevelText = document.getElementById('rLevelText');
    var rAbilitiesBreakdown = document.getElementById('rAbilitiesBreakdown');
    var rGapCopy = document.getElementById('rGapCopy');

    // 1. Prominent Zone Heading (C5 R1 copy)
    if (rZone) {
      var personDisplayName = (nameVal || '').trim();
      var zoneLabel;
      if (personDisplayName) {
        zoneLabel = isEs 
          ? (personDisplayName + ', este es tu Mini Perfil: tu Habilidad para Tener.') 
          : (personDisplayName + ', this is your Mini Profile: your Ability to Have.');
      } else {
        zoneLabel = isEs 
          ? 'Este es tu Mini Perfil: tu Habilidad para Tener.' 
          : 'This is your Mini Profile: your Ability to Have.';
      }
      rZone.textContent = zoneLabel;
      rZone.style.color = 'var(--ink)';
    }

    // Dynamic Chart rendering with score line on Canvas
    function calcHaveY(score) {
      var YValues = [10000, 1000, 100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 0, -10, -20, -30, -40, -50, -60, -70, -80, -90, -100, -1000, -10000];
      var YPoints = [129, 178, 201, 251, 300, 349, 398, 447, 474, 497, 546, 573, 595, 629, 671, 694, 743, 773, 793, 805, 819, 833, 848, 868, 893];
      if (score > 10000) score = 10000;
      if (score < -10000) score = -10000;
      for (var i = 0; i < YValues.length; i++) {
        if (score === YValues[i]) return YPoints[i];
      }
      for (var i = 1; i < YValues.length; i++) {
        if (score > YValues[i]) {
          var hiV = YValues[i - 1], loV = YValues[i];
          var hiP = YPoints[i - 1], loP = YPoints[i];
          var pct = (score - loV) / (hiV - loV);
          return loP - (loP - hiP) * pct;
        }
      }
      return 497;
    }

    var chartUrl = (window.zolQuizData && window.zolQuizData.chartTemplateUrl)
      ? window.zolQuizData.chartTemplateUrl
      : (isEs ? '/wp-content/themes/codebymonk/assets/img/HaveTemplate_ES.png' : '/wp-content/themes/codebymonk/assets/img/HaveTemplate.png');

    var chartImg = new Image();
    chartImg.crossOrigin = 'anonymous';
    chartImg.onload = function () {
      try {
        var canvas = document.createElement('canvas');
        canvas.width = chartImg.naturalWidth || 580;
        canvas.height = chartImg.naturalHeight || 1024;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(chartImg, 0, 0);

        var yPos = calcHaveY(haveNumericScore);
        var xStart = 116; // Tick marks start
        var xEnd = 462;   // Right border of Have column

        // Draw dynamic score line (blue matching the user's reference)
        ctx.save();
        ctx.strokeStyle = '#2563eb';
        ctx.lineWidth = 6;
        ctx.beginPath();
        ctx.moveTo(xStart, yPos);
        ctx.lineTo(xEnd, yPos);
        ctx.stroke();

        // Annotate person's name at top of canvas
        var personName = (nameVal || '').trim();
        if (personName) {
          ctx.fillStyle = '#0f172a';
          ctx.font = 'bold 15px -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
          ctx.textAlign = 'center';
          ctx.fillText(personName + ' · ' + (isEs ? 'Mini Perfil: Nivel en Tener' : 'Mini Profile: Have Level'), canvas.width / 2, 42);
        }
        ctx.restore();

        var dynamicDataUrl = canvas.toDataURL('image/png');
        var rHaveChartImg = document.getElementById('rHaveChartImg');
        var chartModalImg = document.getElementById('chartModalImg');
        var btnDownloadHaveChart = document.getElementById('btnDownloadHaveChart');
        var modalDownloadBtn = document.getElementById('modalDownloadBtn');

        if (rHaveChartImg) rHaveChartImg.src = dynamicDataUrl;
        if (chartModalImg) chartModalImg.src = dynamicDataUrl;

        var downloadName = 'Mini_Perfil_' + (personName ? personName.replace(/[^a-zA-Z0-9_-]/g, '_') : 'Resultado') + '.png';
        if (btnDownloadHaveChart) {
          btnDownloadHaveChart.href = dynamicDataUrl;
          btnDownloadHaveChart.download = downloadName;
        }
        if (modalDownloadBtn) {
          modalDownloadBtn.href = dynamicDataUrl;
          modalDownloadBtn.download = downloadName;
        }
      } catch (err) {
        console.error('Error drawing chart canvas:', err);
      }
    };
    chartImg.src = chartUrl;

    // 2. Zone Bar (Signature 4-Color Indicator)
    if (rBar) {
      var barHtml = '<div class="zones dim">';
      for (var b = 1; b <= 4; b++) {
        barHtml += '<i class="z' + b + (b <= z.i ? ' on' : '') + '"></i>';
      }
      barHtml += '</div>';
      rBar.innerHTML = barHtml;
    }

    // 3. Zone Position Label
    if (rHere) {
      rHere.textContent = z.n + (isEs ? ' · tú estás aquí' : ' · you are here');
      rHere.style.color = z.col;
      rHere.style.fontWeight = '700';
    }

    // 4. Detailed Zone Explanation Copy
    if (rBody) {
      rBody.textContent = COPY[z.n] || COPY["Yellow"] || COPY["Amarilla"];
    }

    // 5. Have Ability Level Card (Mini Perfil Diagnosis)
    if (rLevelBadge) {
      rLevelBadge.textContent = (haveLevelKey === 'green') ? (isEs ? 'Zona Verde' : 'Green Zone') : (isEs ? 'Zona Amarilla' : 'Yellow Zone');
      if (haveLevelKey === 'green') {
        rLevelBadge.style.background = 'rgba(0,125,25,0.12)';
        rLevelBadge.style.color = 'var(--shgreen)';
      } else {
        rLevelBadge.style.background = '#FDE68A';
        rLevelBadge.style.color = '#92400E';
      }
    }
    if (rLevelTitle) {
      rLevelTitle.textContent = haveLevelObj.name;
    }
    if (rLevelText) {
      if (haveLevelObj.full_html) {
        rLevelText.innerHTML = haveLevelObj.full_html;
      } else {
        rLevelText.textContent = haveLevelObj.full;
      }
    }

    // 6. By Area Breakdown (Financiero, Vida y Habilidades, Cuerpo)
    if (rAreas) {
      var areaHtml = '';
      areas.forEach(function (a, i) {
        var zz = ZONE[areaScores[i]] || ZONE[2];
        var isLowest = (i === worstAreaIdx);
        var aLabel = (LBL.area_names && LBL.area_names[a]) ? LBL.area_names[a] : a;
        areaHtml += '<div class="row area-score-row" style="padding:12px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;">';
        areaHtml += '  <div class="grow" style="font-weight:600;font-size:15px;color:var(--ink);">' + aLabel + '</div>';
        areaHtml += '  <span class="tiny" style="color:' + zz.col + ';font-weight:700;letter-spacing:0.06em;">' + (isEs ? ('Zona ' + zz.n) : (zz.n + ' Zone')) + (isLowest ? LBL.start_here : '') + '</span>';
        areaHtml += '</div>';
      });
      rAreas.innerHTML = areaHtml;
    }

    // 7. Six Financial Abilities Breakdown
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
        abHtml += '  <span class="tiny" style="color:' + zz.col + ';font-weight:700;letter-spacing:0.06em;">' + (isEs ? ('Zona ' + zz.n) : (zz.n + ' Zone')) + (isLowest ? LBL.start_here : '') + '</span>';
        abHtml += '</div>';
      });
      rAbilitiesBreakdown.innerHTML = abHtml;
    }

    // 8. The Gap Copy
    if (rGapCopy && LBL.gap_template) {
      rGapCopy.innerHTML = (isEs 
        ? '<strong>Lo que este resultado todavía no te muestra:</strong> Tener es una de las seis habilidades que forman tu salud financiera. Las otras cinco son Producir, Enfocar, Investigar, Invertir y Crear riqueza. Tu Perfil de Salud Financiera mide las seis, te muestra cuál te está frenando más y te da con qué trabajarla.' 
        : '<strong>What this result still doesn\'t show you:</strong> Having is only one of the six abilities that define your financial health. The other five are Producing, Focusing, Investigating, Investing, and Creating Wealth. Your Financial Health Profile measures all six, shows you which one is holding you back the most, and gives you tools to elevate it.');
    }

    // 9. Purchase CTAs -> Full Profile (Finance page)
    var financeBase = (window.zolQuizData && window.zolQuizData.financeUrl) 
      ? window.zolQuizData.financeUrl 
      : (isEs ? '/es/perfil-financiero/' : '/finance/');

    var rBtnBuy = document.getElementById('rBtnBuy');
    var rBtnBuySession = document.getElementById('rBtnBuySession');

    if (rBtnBuy) {
      rBtnBuy.href = financeBase;
    }

    if (rBtnBuySession) {
      var sep = financeBase.indexOf('?') !== -1 ? '&' : '?';
      rBtnBuySession.href = financeBase + sep + 'package=session';
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
      have_level: haveLevelKey,
      have_level_name: haveLevelObj.name,
      have_level_quote: haveLevelObj.short,
      have_level_text: haveLevelObj.full || haveLevelObj.short,
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
    formData.append('financial_zone', (ZONE[areaScores[0]] || z).n);
    formData.append('life_zone', (ZONE[areaScores[1]] || z).n);
    formData.append('body_zone', (ZONE[areaScores[2]] || z).n);
    formData.append('lowest_ability', worstAbilityName);
    formData.append('lowest_ability_quote', worstQuote);
    formData.append('have_level', haveLevelKey);
    formData.append('have_level_name', haveLevelObj.name);
    formData.append('have_level_quote', haveLevelObj.short);
    formData.append('have_level_text', haveLevelObj.full || haveLevelObj.short);
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
      var rawPhone = gPhone ? gPhone.value.trim() : '';
      var gCountryCode = document.getElementById('gCountryCode');
      var countryCodeVal = gCountryCode ? gCountryCode.value : '';
      var phoneVal = rawPhone;
      if (countryCodeVal && rawPhone && rawPhone.indexOf('+') !== 0) {
        phoneVal = countryCodeVal + ' ' + rawPhone;
      }
      var rawName = gName ? gName.value.trim() : '';
      if (!rawName) {
        if (err) {
          err.textContent = isEs ? 'Escribe tu nombre' : 'Please enter your name';
          err.style.display = 'block';
        }
        if (gName) gName.focus();
        return;
      }
      var nameVal = rawName;
      var waOptinVal = gWaOptin ? gWaOptin.checked : true;

      if (!emailVal || emailVal.indexOf('@') < 1 || emailVal.indexOf('.') < 0) {
        if (err) {
          err.textContent = LBL.email_error;
          err.style.display = 'block';
        }
        if (gMail) gMail.focus();
        return;
      }

      if (!rawPhone || rawPhone.length < 7) {
        if (err) {
          err.textContent = LBL.phone_error || 'Por favor ingresa un número de teléfono válido.';
          err.style.display = 'block';
        }
        if (gPhone) gPhone.focus();
        return;
      }

      // Save lead cookies for prefill across checkout and portal (A4)
      document.cookie = 'zol_lead_email=' + encodeURIComponent(emailVal) + ';path=/;max-age=86400';
      document.cookie = 'zol_lead_name=' + encodeURIComponent(nameVal) + ';path=/;max-age=86400';
      document.cookie = 'zol_lead_phone=' + encodeURIComponent(phoneVal) + ';path=/;max-age=86400';
      try {
        localStorage.setItem('zol_lead_email', emailVal);
        localStorage.setItem('zol_lead_name', nameVal);
        localStorage.setItem('zol_lead_phone', phoneVal);
      } catch (e) {}

      if (err) err.style.display = 'none';
      renderResult(nameVal, emailVal, phoneVal, waOptinVal);
    });
  }

  // Country code selector helper
  var gCountryCode = document.getElementById('gCountryCode');
  var gPhone = document.getElementById('gPhone');
  if (gCountryCode && gPhone) {
    gCountryCode.addEventListener('change', function () {
      var code = this.value;
      if (code === '+52') gPhone.placeholder = '55 1234 5678';
      else if (code === '+1') gPhone.placeholder = '469 123 4567';
      else if (code === '+34') gPhone.placeholder = '612 34 56 78';
      else if (code === '+57') gPhone.placeholder = '300 123 4567';
      else if (code === '+54') gPhone.placeholder = '11 1234 5678';
      else gPhone.placeholder = '1234 5678';
    });
  }

  // Modal event listeners
  var chartModal = document.getElementById('chartModal');
  var btnOpenChartModal = document.getElementById('btnOpenChartModal');
  var chartImgContainer = document.getElementById('chartImgContainer');
  var closeChartModal = document.getElementById('closeChartModal');
  var modalCloseBtn = document.getElementById('modalCloseBtn');

  function openChartModal() {
    if (chartModal) chartModal.style.display = 'flex';
  }
  function closeChartModalFunc() {
    if (chartModal) chartModal.style.display = 'none';
  }

  if (btnOpenChartModal) btnOpenChartModal.addEventListener('click', openChartModal);
  if (chartImgContainer) chartImgContainer.addEventListener('click', openChartModal);
  if (closeChartModal) closeChartModal.addEventListener('click', closeChartModalFunc);
  if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeChartModalFunc);
  if (chartModal) {
    chartModal.addEventListener('click', function (e) {
      if (e.target === chartModal) closeChartModalFunc();
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
      sendData.append('have_level_name', lastLeadData.have_level_name || '');
      sendData.append('have_level_quote', lastLeadData.have_level_quote || '');
      sendData.append('have_level_text', lastLeadData.have_level_text || '');
      sendData.append('zone', lastLeadData.zone || 'Amber');
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
