document.addEventListener('DOMContentLoaded', function () {
  const navToggler = document.querySelector('.nav-toggler');
  const navLinks = document.querySelector('.nav-links');
  const backdrop = document.querySelector('.backdrop-filter');

  if (navToggler && navLinks) {
    navToggler.addEventListener('click', function () {
      navLinks.classList.toggle('show');
      backdrop?.classList.toggle('show');
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', function () {
      navLinks?.classList.remove('show');
      backdrop.classList.remove('show');
    });
  }
});
