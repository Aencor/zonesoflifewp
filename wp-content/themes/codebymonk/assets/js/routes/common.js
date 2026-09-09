export default {
  init() {
    // Mobile navigation toggle
    const burger = document.querySelector('.burger');
    const mainNav = document.querySelector('nav.main');
    if (burger && mainNav) {
      burger.addEventListener('click', (e) => {
        e.preventDefault();
        mainNav.classList.toggle('open');
      });
    }

    // Newsletter subscription handling
    document.querySelectorAll('.block-newsletter, .newsband').forEach((band) => {
      const goBtn = band.querySelector('.nGo');
      const mailInput = band.querySelector('.nMail');
      const checkConsent = band.querySelector('.nOk');
      const newsForm = band.querySelector('.newsForm');
      const newsDone = band.querySelector('.newsDone');
      const newsTxt = band.querySelector('.newsTxt');

      if (goBtn && mailInput) {
        goBtn.addEventListener('click', (e) => {
          e.preventDefault();
          const email = mailInput.value.trim();
          if (email.indexOf('@') < 1 || email.indexOf('.') < 0) {
            mailInput.focus();
            alert('Please enter a valid email address.');
            return;
          }
          if (checkConsent && !checkConsent.checked) {
            alert('Please accept the Privacy Policy to subscribe.');
            return;
          }
          if (newsTxt) {
            newsTxt.textContent = `Confirmed. The Zone Letter will be sent to ${email} every Monday.`;
          }
          if (newsForm) newsForm.hidden = true;
          if (newsDone) newsDone.hidden = false;
        });
      }
    });

    // Cookie banner handling
    const cookieBar = document.querySelector('#cookieBar');
    if (cookieBar) {
      const consent = localStorage.getItem('zol_cookie_consent');
      if (!consent) {
        cookieBar.hidden = false;
      }
      const ckAccept = document.querySelector('#ckAccept');
      const ckReject = document.querySelector('#ckReject');
      if (ckAccept) {
        ckAccept.addEventListener('click', () => {
          localStorage.setItem('zol_cookie_consent', 'accepted');
          cookieBar.hidden = true;
        });
      }
      if (ckReject) {
        ckReject.addEventListener('click', () => {
          localStorage.setItem('zol_cookie_consent', 'rejected');
          cookieBar.hidden = true;
        });
      }

      // Allow reopening cookie bar from Cookie Policy page
      document.addEventListener('click', (e) => {
        if (e.target && (e.target.id === 'reopenCookies' || e.target.closest('#reopenCookies'))) {
          e.preventDefault();
          cookieBar.hidden = false;
          cookieBar.scrollIntoView({ behavior: 'smooth', block: 'end' });
        }
      });
    }
  },
  finalize() {}
};