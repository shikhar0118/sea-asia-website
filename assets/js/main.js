(() => {
  // Mobile navigation menu
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.primary-nav');
  if (toggle && nav) {
    const closeMenu = (returnFocus = false) => {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open menu');
      nav.classList.remove('is-open');
      if (returnFocus) toggle.focus();
    };

    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      nav.classList.toggle('is-open', open);
    });
    nav.addEventListener('click', event => {
      if (event.target.closest('a')) {
        closeMenu();
      }
    });
    document.addEventListener('click', event => {
      if (!nav.contains(event.target) && !toggle.contains(event.target)) closeMenu();
    });
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
        closeMenu(true);
      }
    });
    window.addEventListener('resize', () => {
      if (window.matchMedia('(min-width: 961px)').matches) closeMenu();
    });
  }
  // Keep the copyright year current.
  document.querySelectorAll('[data-year]').forEach(el => {
    el.textContent = new Date().getFullYear();
  });

  // Homepage service slideshow. Scene order matches the image order in index.html.
  const hero = document.querySelector('.hero');
  if (hero) {
    const slides = [
      {
        eyebrow: '01 / CUSTOMS CLEARANCE',
        title: 'Customs House Agency (CHA) Services',
        copy: 'Professional import and export customs clearance coordination, including Shipping Bills, Bills of Entry, documentation verification, customs assessment, examination, and cargo release formalities.'
      },
      {
        eyebrow: '02 / EXIM DOCUMENTATION',
        title: 'Import, Export & Compliance Support',
        copy: 'Complete documentation assistance covering commercial invoices, packing lists, Bills of Lading, certificates, e-Sanchit submissions, AD Code, ICEGATE-related requirements, and applicable regulatory procedures.'
      },
      {
        eyebrow: '03 / SHIPPING & CARRIER',
        title: 'Shipping Line & Carrier Coordination',
        copy: 'Efficient coordination with shipping lines and carriers for vessel schedules, booking requests, container availability, shipping instructions, documentation amendments, sailing updates, and shipment tracking.'
      },
      {
        eyebrow: '04 / FREIGHT & LOGISTICS',
        title: 'Transportation & Port Coordination',
        copy: 'Reliable coordination for container movement, transportation, port entry, terminal handling, cargo examination, delivery schedules, shipment milestones, and operational updates.'
      }
    ];
    const photos = [...hero.querySelectorAll('.hero-photo')];
    const eyebrow = hero.querySelector('.hero-eyebrow-label');
    const title = hero.querySelector('h1');
    const copy = hero.querySelector('.hero-copy');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let activeSlide = 0;
    let autoplayTimer;
    let entranceTimer;

    const showSlide = (index) => {
      activeSlide = (index + slides.length) % slides.length;
      const slide = slides[activeSlide];

      photos.forEach((photo, photoIndex) => {
        photo.classList.toggle('is-active', photoIndex === activeSlide);
      });
      hero.classList.toggle('is-air-scene', false);
      hero.classList.toggle('is-ocean-scene', activeSlide === 2);
      hero.classList.toggle('is-customs-scene', activeSlide === 0);
      hero.classList.toggle('is-warehouse-scene', false);

      if (eyebrow) eyebrow.textContent = slide.eyebrow;
      if (title) title.innerHTML = slide.title;
      if (copy) copy.textContent = slide.copy;

      // Fade the new headline in at the same time as its image.
      if (!reduceMotion) {
        hero.classList.remove('is-entering');
        void hero.offsetWidth;
        hero.classList.add('is-entering');
        window.clearTimeout(entranceTimer);
        entranceTimer = window.setTimeout(() => {
          hero.classList.remove('is-entering');
        }, 900);
      }
    };

    // Give visitors time to read the service details; pause while the page is hidden.
    const stopAutoplay = () => window.clearInterval(autoplayTimer);
    const startAutoplay = () => {
      stopAutoplay();
      if (!reduceMotion && !document.hidden) {
        autoplayTimer = window.setInterval(() => showSlide(activeSlide + 1), 8000);
      }
    };

    document.addEventListener('visibilitychange', () => document.hidden ? stopAutoplay() : startAutoplay());
    startAutoplay();
  }

  const header = document.querySelector('.site-header');
  const updateHeader = () => {
    if (!header) return;
    const currentlyScrolled = header.classList.contains('is-scrolled');
    const threshold = currentlyScrolled ? 8 : 20;
    const shouldBeScrolled = window.scrollY > threshold;
    if (shouldBeScrolled !== currentlyScrolled) {
      header.classList.toggle('is-scrolled', shouldBeScrolled);
    }
  };
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });

  // GSAP is already loaded by the site pages. Keep motion graceful if a CDN
  // is unavailable, and leave the normal page fully visible for reduced motion.
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const proofStrip = document.querySelector('.proof-strip');
  if (proofStrip && !reduceMotion) {
    if ('IntersectionObserver' in window) {
      const proofObserver = new IntersectionObserver((entries) => {
        if (!entries.some((entry) => entry.isIntersecting)) return;
        proofStrip.classList.add('is-live');
        proofObserver.disconnect();
      }, { threshold: 0.28 });
      proofObserver.observe(proofStrip);
    } else {
      proofStrip.classList.add('is-live');
    }
  }
  if (!window.gsap || !window.ScrollTrigger || reduceMotion) return;
  gsap.registerPlugin(ScrollTrigger);

  const ease = 'power3.out';
  const homeHero = document.querySelector('.hero');
  if (homeHero) {
    gsap.timeline({ defaults: { ease } })
      .from('.hero-content > .eyebrow', { y: 14, autoAlpha: 0, duration: .45, clearProps: 'transform,opacity' })
      .from('.hero h1', { y: 24, autoAlpha: 0, duration: .62, clearProps: 'transform,opacity' }, '-=.2')
      .from('.hero-copy', { y: 16, autoAlpha: 0, duration: .5, clearProps: 'transform,opacity' }, '-=.28')
      .from('.hero-actions > *', { y: 12, autoAlpha: 0, duration: .42, stagger: .1, clearProps: 'transform,opacity' }, '-=.2');
  }

  document.querySelectorAll('.page-hero .container').forEach((container) => {
    gsap.from(container.children, { y: 18, autoAlpha: 0, duration: .52, stagger: .07, ease, delay: .08, clearProps: 'transform,opacity' });
  });

  const revealSelector = [
    '.section-heading', '.intro-grid > *', '.feature-content > *', '.contact-layout > *',
    '.proof-intro', '.cta-inner > *', '.footer-main > *', '.footer-bottom > *',
    '.content-section .gallery-note', '.content-section .callout'
  ].join(',');
  document.querySelectorAll(revealSelector).forEach((element, index) => {
    gsap.from(element, {
      y: 20, autoAlpha: 0, duration: .58, delay: index % 2 ? .04 : 0, ease,
      scrollTrigger: { trigger: element, start: 'top 90%', once: true }
    });
  });

  document.querySelectorAll('.service-grid, .page-grid, .steps-grid, .recognition-list').forEach((grid) => {
    const cards = grid.querySelectorAll('.service-card, .info-card, .recognition-item, article');
    if (!cards.length) return;
    gsap.fromTo(cards, { y: 16, autoAlpha: 0 }, {
      y: 0, autoAlpha: 1, duration: .54, stagger: .08, ease, clearProps: 'transform,opacity',
      scrollTrigger: { trigger: grid, start: 'top 88%', once: true }
    });
  });

  // Count the existing proof values in place, retaining their suffix markup.
  document.querySelectorAll('.proof-item strong').forEach((value) => {
    // Establishment years are dates, so keep them ungrouped (2013, not 2,013).
    if (value.closest('.proof-year')) return;
    const textNode = [...value.childNodes].find((node) => node.nodeType === Node.TEXT_NODE);
    if (!textNode) return;
    const match = textNode.textContent.trim().match(/^(\d[\d,]*)/);
    if (!match) return;
    const target = Number(match[1].replace(/,/g, ''));
    const suffix = textNode.textContent.trim().slice(match[1].length);
    const counter = { value: 0 };
    ScrollTrigger.create({
      trigger: value,
      start: 'top 92%',
      once: true,
      onEnter: () => gsap.to(counter, {
        value: target, duration: 1.35, ease: 'power2.out',
        onUpdate: () => { textNode.textContent = `${Math.round(counter.value).toLocaleString('en-IN')}${suffix}`; }
      })
    });
  });

  gsap.utils.toArray('.hero-photo').forEach((photo) => {
    gsap.to(photo, {
      yPercent: 3, ease: 'none',
      scrollTrigger: { trigger: photo.closest('.hero'), start: 'top top', end: 'bottom top', scrub: .8 }
    });
  });
})();
