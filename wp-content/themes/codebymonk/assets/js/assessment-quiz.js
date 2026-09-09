/**
 * Personal Zones Profile Assessment Engine
 */
document.addEventListener('DOMContentLoaded', function () {
  var quizSection = document.getElementById('quiz');
  if (!quizSection) return;

  var i18n = (window.zolQuizData && window.zolQuizData.isSpanish) ? window.zolQuizData : null;

  var Q = (i18n && i18n.questions) ? i18n.questions : [
    { a: "Life & Skills", t: "Do you complete activities quickly?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", t: "Are you positioned for success?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", t: "Do you perceive other people's games?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", t: "Do you drive a luxury car?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", t: "Is your future uncertain?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", t: "Do you like to have a lot of action?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Financial", t: "Do you go into debt at the end of the year?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", t: "Do you tend to misperceive people?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", t: "Do you travel in economy class instead of first class?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", t: "Are you unsure about your material desires?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", t: "Do you wish you were living your dream?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", t: "Has your career become less than what you wanted?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", t: "Do you wish you had acted faster?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Financial", t: "Will your career provide you with future wealth?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", t: "Do you always strive to be the best you can be?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", t: "Do you dislike people?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Life & Skills", t: "Do you take action to up your game?", o: [["Yes", 4], ["Maybe", 2], ["No", 1]] },
    { a: "Life & Skills", t: "Do you feel you know more than others, even those more successful than you?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", t: "Do you like staying close to home during holidays?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] },
    { a: "Body", t: "Are you easily distracted?", o: [["Yes", 1], ["Maybe", 2], ["No", 4]] }
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

  var LBL = (i18n && i18n.labels) ? i18n.labels : {
    area: 'Area: ',
    you_are_in: 'You are in the ',
    you_are_here: ' · you are here',
    start_here: ' · start here',
    privacy_error: 'Please accept the Privacy Policy to view your result.',
    email_error: 'Please enter a valid email address.',
    area_names: {}
  };

  var answers = [];
  var idx = 0;

  var intro = document.getElementById('quizIntro');
  var run = document.getElementById('quizRun');
  var gate = document.getElementById('quizGate');
  var res = document.getElementById('quizResult');

  var btnStart = document.getElementById('startQuiz');
  var btnBack = document.getElementById('qBack');
  var btnGateGo = document.getElementById('gGo');
  var btnRetake = document.getElementById('retake');

  var qArea = document.getElementById('qArea');
  var qCount = document.getElementById('qCount');
  var qBar = document.getElementById('qBar');
  var qText = document.getElementById('qText');
  var qOpts = document.getElementById('qOpts');

  function paintBar(el, total, done) {
    if (!el) return;
    el.innerHTML = '';
    for (var i = 0; i < total; i++) {
      var span = document.createElement('span');
      if (i < done) span.className = 'on';
      el.appendChild(span);
    }
  }

  function startAssessment() {
    answers = [];
    idx = 0;
    intro.hidden = true;
    gate.hidden = true;
    res.hidden = true;
    run.hidden = false;
    drawQ();
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

  function drawQ() {
    var item = Q[idx];
    qArea.textContent = LBL.area + (LBL.area_names[item.a] || item.a);
    qCount.textContent = (idx + 1) + ' / ' + Q.length;
    paintBar(qBar, Q.length, idx + 1);
    qText.textContent = item.t;

    var html = '';
    item.o.forEach(function (o) {
      var val = o[1];
      var isSel = answers[idx] === val;
      html += '<button type="button" class="choice' + (isSel ? ' sel' : '') + '" data-val="' + val + '">';
      html += '<span>' + o[0] + '</span>';
      html += '<i class="radio-indicator"></i>';
      html += '</button>';
    });
    qOpts.innerHTML = html;

    var choiceBtns = qOpts.querySelectorAll('.choice');
    choiceBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        answers[idx] = parseInt(btn.dataset.val, 10);
        if (idx < Q.length - 1) {
          idx++;
          drawQ();
        } else {
          run.hidden = true;
          gate.hidden = false;
        }
      });
    });

    btnBack.disabled = (idx === 0);
  }

  if (btnBack) {
    btnBack.addEventListener('click', function () {
      if (idx > 0) {
        idx--;
        drawQ();
      }
    });
  }

  function scoreArea(areaName) {
    var vals = [];
    Q.forEach(function (item, i) {
      if (item.a === areaName && answers[i]) {
        vals.push(answers[i]);
      }
    });
    if (!vals.length) return 2;
    return Math.round(vals.reduce(function (a, b) { return a + b; }, 0) / vals.length);
  }

  function renderResult(nameVal, emailVal) {
    var areas = ["Financial", "Life & Skills", "Body"];
    var scores = areas.map(scoreArea);
    var overall = Math.round(scores.reduce(function (a, b) { return a + b; }, 0) / scores.length);
    var z = ZONE[overall] || ZONE[2];

    var rZone = document.getElementById('rZone');
    var rHere = document.getElementById('rHere');
    var rBar = document.getElementById('rBar');
    var rBody = document.getElementById('rBody');
    var rAreas = document.getElementById('rAreas');

    if (rZone) {
      var zoneLabel = z.n.toLowerCase().indexOf('zone') !== -1 || z.n.toLowerCase().indexOf('zona') !== -1 ? z.n : (z.n + (i18n ? ' Zona' : ' Zone'));
      rZone.textContent = LBL.you_are_in + zoneLabel;
      rZone.style.color = z.col;
    }
    if (rHere) {
      rHere.textContent = z.n + LBL.you_are_here;
    }
    if (rBar) {
      var barHtml = '<div class="zones dim">';
      for (var i = 1; i <= 4; i++) {
        barHtml += '<i class="z' + i + (i <= z.i ? ' on' : '') + '"></i>';
      }
      barHtml += '</div>';
      rBar.innerHTML = barHtml;
    }
    if (rBody) {
      rBody.textContent = COPY[z.n] || COPY["Yellow"] || COPY["Amarilla"];
    }

    var worstIdx = scores.indexOf(Math.min.apply(null, scores));

    if (rAreas) {
      var areaHtml = '';
      areas.forEach(function (a, i) {
        var zz = ZONE[scores[i]] || ZONE[2];
        var isLowest = (i === worstIdx);
        areaHtml += '<div class="row area-score-row" style="padding:12px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;">';
        areaHtml += '  <div class="grow" style="font-weight:600;font-size:15px;color:var(--ink);">' + (LBL.area_names[a] || a) + '</div>';
        areaHtml += '  <span class="tiny" style="color:' + zz.col + ';font-weight:600;letter-spacing:0.06em;">' + zz.n + (isLowest ? LBL.start_here : '') + '</span>';
        areaHtml += '</div>';
      });
      rAreas.innerHTML = areaHtml;
    }

    gate.hidden = true;
    res.hidden = false;
    quizSection.scrollIntoView({ behavior: 'smooth' });

    // Send to database
    var formData = new FormData();
    formData.append('action', 'zol_submit_assessment_lead');
    if (window.zolData && window.zolData.nonce) {
      formData.append('nonce', window.zolData.nonce);
    }
    formData.append('name', nameVal);
    formData.append('email', emailVal);
    formData.append('zone', z.n);
    formData.append('financial_zone', ZONE[scores[0]].n);
    formData.append('life_zone', ZONE[scores[1]].n);
    formData.append('body_zone', ZONE[scores[2]].n);

    var ajaxUrl = (window.zolData && window.zolData.ajaxUrl) ? window.zolData.ajaxUrl : '/wp-admin/admin-ajax.php';
    fetch(ajaxUrl, { method: 'POST', body: formData });
  }

  if (btnGateGo) {
    btnGateGo.addEventListener('click', function () {
      var gOk = document.getElementById('gOk');
      var gName = document.getElementById('gName');
      var gMail = document.getElementById('gMail');
      var err = document.getElementById('quizGateError');

      if (gOk && !gOk.checked) {
        if (err) {
          err.textContent = LBL.privacy_error;
          err.style.display = 'block';
        }
        return;
      }

      var emailVal = gMail ? gMail.value.trim() : '';
      var nameVal = gName ? gName.value.trim() : (i18n ? 'Participante' : 'Participant');

      if (!emailVal || emailVal.indexOf('@') < 1 || emailVal.indexOf('.') < 0) {
        if (err) {
          err.textContent = LBL.email_error;
          err.style.display = 'block';
        }
        if (gMail) gMail.focus();
        return;
      }

      if (err) err.style.display = 'none';
      renderResult(nameVal, emailVal);
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
