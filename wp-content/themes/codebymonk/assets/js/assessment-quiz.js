/**
 * Personal Zones Profile Assessment Engine
 */
document.addEventListener('DOMContentLoaded', function () {
  var quizSection = document.getElementById('quiz');
  if (!quizSection) return;

  var Q = [
    { a: "Financial", t: "When money gets tight, what do you do first?", o: [["Avoid looking at it until there is no choice", 1], ["Work more hours and hope it settles", 2], ["Review the numbers and adjust the plan", 3], ["Bring in someone who knows more than I do", 4]] },
    { a: "Financial", t: "How far ahead can you see your finances?", o: [["Not at all", 1], ["To the end of the month", 2], ["A year, roughly", 3], ["Several years, with a structure behind it", 4]] },
    { a: "Financial", t: "When income arrives, what happens to it?", o: [["It disappears before I notice", 1], ["It covers what is overdue", 2], ["It follows a plan I set", 3], ["It is allocated before it arrives", 4]] },
    { a: "Financial", t: "How do you feel discussing money with people close to you?", o: [["I avoid it entirely", 1], ["Tense but able", 2], ["Straightforward", 3], ["It is a normal working conversation", 4]] },
    { a: "Financial", t: "Your last significant financial decision was made by…", o: [["Circumstances, not me", 1], ["Me, under pressure", 2], ["Me, with time to think", 3], ["Me, against a longer plan", 4]] },
    { a: "Life & Skills", t: "When something important is not working, you…", o: [["Push harder at the same thing", 1], ["Notice it, and stall", 2], ["Name it and change the approach", 3], ["Have already redesigned it", 4]] },
    { a: "Life & Skills", t: "How consistently do you produce your best work?", o: [["Rarely, and I cannot predict when", 1], ["When conditions are right", 2], ["Most weeks", 3], ["Consistently, because it does not rely on mood", 4]] },
    { a: "Life & Skills", t: "How clear is your direction for the next two years?", o: [["I have none", 1], ["A vague sense", 2], ["Clear, written down", 3], ["Clear, and I am already executing it", 4]] },
    { a: "Life & Skills", t: "When you learn something useful, what usually happens?", o: [["Nothing changes", 1], ["I try it once", 2], ["I apply it and keep what works", 3], ["I apply it and teach it to someone", 4]] },
    { a: "Life & Skills", t: "How often do you finish what you start?", o: [["Seldom", 1], ["When someone is waiting on it", 2], ["Usually", 3], ["Almost always, by design", 4]] },
    { a: "Body", t: "How is your energy through an ordinary day?", o: [["It runs out early", 1], ["It dips and I push through", 2], ["Steady most days", 3], ["Reliable, and I know what maintains it", 4]] },
    { a: "Body", t: "How well do you sleep?", o: [["Badly, most nights", 1], ["Unevenly", 2], ["Well most nights", 3], ["Well, and it is protected deliberately", 4]] },
    { a: "Body", t: "How does your body respond under pressure?", o: [["It gives out", 1], ["It complains and I ignore it", 2], ["It holds", 3], ["It holds, and I adjust before it has to", 4]] },
    { a: "Body", t: "Movement in your week is…", o: [["Absent", 1], ["Occasional", 2], ["Regular", 3], ["Regular and matched to what I need", 4]] }
  ];

  var ZONE = {
    1: { n: "Red", i: 1, col: "var(--red)" },
    2: { n: "Amber", i: 2, col: "#B98F0C" },
    3: { n: "Green", i: 3, col: "var(--shgreen)" },
    4: { n: "Golden Magic", i: 4, col: "#8A7440" }
  };

  var COPY = {
    "Red": "Red means you are out of flow. Effort goes in and very little comes back, because you are reacting to what happens instead of directing it. It is the most expensive Zone to stay in and the one where a single structural change makes the biggest difference.",
    "Amber": "Amber means you are already awake. You can recognise what is not working and you have words for it, but change still depends on your willpower on the day rather than on a structure holding it. It is where most people get stuck — and also where the climb is fastest once it starts.",
    "Green": "Green means you are in flow. Results arrive consistently because there is structure behind them, not because you forced them. The work from here is holding it under load and widening it into the areas that are still lagging.",
    "Golden Magic": "Golden Magic means mastery. You operate in your Zone reliably and you can take other people there. The work from here is transmission — turning what you do into something others can learn."
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
    qArea.textContent = 'Area: ' + item.a;
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
      rZone.textContent = 'You are in the ' + z.n + ' Zone';
      rZone.style.color = z.col;
    }
    if (rHere) {
      rHere.textContent = z.n + ' · you are here';
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
      rBody.textContent = COPY[z.n] || COPY["Amber"];
    }

    var worstIdx = scores.indexOf(Math.min.apply(null, scores));

    if (rAreas) {
      var areaHtml = '';
      areas.forEach(function (a, i) {
        var zz = ZONE[scores[i]] || ZONE[2];
        var isLowest = (i === worstIdx);
        areaHtml += '<div class="row area-score-row" style="padding:12px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;">';
        areaHtml += '  <div class="grow" style="font-weight:600;font-size:15px;color:var(--ink);">' + a + '</div>';
        areaHtml += '  <span class="tiny" style="color:' + zz.col + ';font-weight:600;letter-spacing:0.06em;">' + zz.n + (isLowest ? ' · start here' : '') + '</span>';
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
          err.textContent = 'Please accept the Privacy Policy to view your result.';
          err.style.display = 'block';
        }
        return;
      }

      var emailVal = gMail ? gMail.value.trim() : '';
      var nameVal = gName ? gName.value.trim() : 'Participant';

      if (!emailVal || emailVal.indexOf('@') < 1 || emailVal.indexOf('.') < 0) {
        if (err) {
          err.textContent = 'Please enter a valid email address.';
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
