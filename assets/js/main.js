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

  // Homepage slideshow. Scene order matches the image order in index.html.
  const hero = document.querySelector('.hero');
  if (hero) {
    const slides = [
      {
        eyebrow: 'CUSTOM HOUSE AGENT (CHA) & ADVISORY',
        title: 'Licensed Customs House Brokerage<br><em>& Regulatory Advisory</em>',
        copy: 'Complete import and export customs clearance across all major Indian ports, ICDs, and nationwide branches, including documentation auditing and statutory EXIM compliance.'
      },
      {
        eyebrow: 'OCEAN FREIGHT FORWARDING',
        title: 'Global Ocean Freight<br><em>& Vessel Logistics</em>',
        copy: 'Cost-effective FCL and LCL ocean forwarding with capacity exceeding 15,000 TEUs annually for worldwide port-to-port and door-to-door deliveries.'
      },
      {
        eyebrow: 'AIR CARGO LOGISTICS',
        title: 'International Air Cargo<br><em>& 24/7 Aviation Expediting</em>',
        copy: 'Time-critical international air freight forwarding and round-the-clock 24/7 Aviation AOG (Aircraft On Ground) emergency parts clearance and delivery.'
      },
      {
        eyebrow: 'ROAD TRANSPORTATION',
        title: 'Pan-India Road Freight<br><em>& Specialized Transit Corridors</em>',
        copy: 'Nationwide surface transportation using modern commercial fleets with dedicated scheduled runs along high-demand industrial corridors, including the Bhopal–Mumbai route.'
      },
      {
        eyebrow: 'RAIL CARGO LOGISTICS',
        title: 'High-Capacity Rail Cargo<br><em>& Multimodal Rake Operations</em>',
        copy: 'End-to-end full railway rake coordination and ICD terminal handling with Indian Railways for large-scale domestic bulk freight and cross-border project exports.'
      },
      {
        eyebrow: 'BONDED WAREHOUSING & SUPPLY CHAIN',
        title: 'Bonded Warehousing & Integrated<br><em>Supply Chain Solutions</em>',
        copy: 'Secure customs-bonded and general warehousing facilities providing professional palletizing, industrial crafting, and real-time inventory and purchase order tracking.'
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
      hero.classList.toggle('is-air-scene', activeSlide === 2);
      hero.classList.toggle('is-ocean-scene', activeSlide === 1);
      hero.classList.toggle('is-customs-scene', activeSlide === 0);
      hero.classList.toggle('is-warehouse-scene', activeSlide === 5);

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

    // Rotate slides every five seconds; stop while the page is hidden.
    const stopAutoplay = () => window.clearInterval(autoplayTimer);
    const startAutoplay = () => {
      stopAutoplay();
      if (!reduceMotion && !document.hidden) {
        autoplayTimer = window.setInterval(() => showSlide(activeSlide + 1), 5000);
      }
    };

    document.addEventListener('visibilitychange', () => document.hidden ? stopAutoplay() : startAutoplay());
    startAutoplay();
  }

  // Optional scroll reveals. The site remains readable if GSAP is unavailable
  // or if the visitor prefers reduced motion.
  if (!window.gsap || !window.ScrollTrigger || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  gsap.registerPlugin(ScrollTrigger);

  // Add small entrance effects to shared page sections.
  const startPageAnimations = () => {
    const headerIntro = gsap.timeline({ defaults: { ease: 'power2.out' } });
    headerIntro
      .from('.brand-mark', { x: -14, autoAlpha: 0, duration: 0.45 })
      .from('.brand-name', { y: 8, autoAlpha: 0, duration: 0.35 }, '-=0.22')
      .from('.primary-nav a', { y: -8, autoAlpha: 0, duration: 0.32, stagger: 0.045 }, '-=0.18')
      .from('.header-cta', { y: -8, autoAlpha: 0, duration: 0.32 }, '-=0.16');

    const pageHero = document.querySelector('.page-hero');
    if (pageHero) {
      gsap.from('.page-hero .container > *', {
        y: 18,
        autoAlpha: 0,
        duration: 0.52,
        stagger: 0.08,
        ease: 'power2.out',
        delay: 0.12
      });
    }

    const revealItems = document.querySelectorAll(
      '.section-heading, .intro-grid > *, .feature-content > *, .contact-layout > *'
    );
    revealItems.forEach((element) => {
      gsap.from(element, {
        y: 20,
        autoAlpha: 0,
        duration: 0.6,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: element,
          start: 'top 88%',
          once: true
        }
      });
    });

    document.querySelectorAll('.service-grid, .page-grid, .steps-grid, .proof-grid').forEach((grid) => {
      const cards = grid.querySelectorAll('.service-card, .info-card, article, .proof-item');
      if (!cards.length) return;
      gsap.fromTo(cards,
        { y: 30, autoAlpha: 0 },
        {
          y: 0,
          autoAlpha: 1,
          duration: 0.68,
          stagger: 0.09,
          ease: 'power2.out',
          scrollTrigger: { trigger: grid, start: 'top 84%', once: true }
        }
      );
    });

    gsap.utils.toArray('.hero-photo').forEach((background) => {
      gsap.to(background, {
        yPercent: 4,
        ease: 'none',
        scrollTrigger: {
          trigger: background.closest('.hero'),
          start: 'top top',
          end: 'bottom top',
          scrub: 0.7
        }
      });
    });

    gsap.utils.toArray('.feature-image').forEach((background) => {
      gsap.fromTo(background,
        { backgroundPositionY: '42%' },
        {
          backgroundPositionY: '68%',
          ease: 'none',
          scrollTrigger: {
            trigger: background.closest('.feature-band'),
            start: 'top bottom',
            end: 'bottom top',
            scrub: 0.7
          }
        }
      );
    });

    gsap.utils.toArray('.page-hero').forEach((hero) => {
      gsap.to(hero, {
        '--scroll-orbit': '90px',
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 0.7
        }
      });
    });
  };

  startPageAnimations();
})();
