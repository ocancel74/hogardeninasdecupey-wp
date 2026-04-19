/* ============================================================
   HOGAR DE NIÑAS CUPEY — app.js
   Carga dinámica desde /data/content.json
   Para editar el contenido del sitio, sólo modifica content.json.
   ============================================================ */

// ——— SVG icons for social networks ———
const SOCIAL_ICONS = {
  facebook: `<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>`,
  instagram: `<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>`,
};

// ——— Format date to Spanish ———
function formatDate(dateStr) {
  if (!dateStr) return '';
  const d = new Date(dateStr + 'T00:00:00');
  return d.toLocaleDateString('es-PR', { year: 'numeric', month: 'long', day: 'numeric' });
}

// ——— Build social icon HTML ———
function buildSocialIcon(platform, url, size = '') {
  const icon = SOCIAL_ICONS[platform] || '🔗';
  const label = platform.charAt(0).toUpperCase() + platform.slice(1);
  return `<a href="${url}" target="_blank" rel="noopener noreferrer" class="social-icon ${size}" aria-label="${label}" title="${label}">${typeof icon === 'string' && icon.startsWith('<') ? icon : icon}</a>`;
}

// ——— Main init: fetch JSON and render everything ———
async function init() {
  let data;
  try {
    const res = await fetch('data/content.json');
    if (!res.ok) throw new Error('No se pudo cargar content.json');
    data = await res.json();
  } catch (err) {
    console.error('[Cupey] Error cargando content.json:', err);
    document.body.innerHTML = `<div style="display:grid;place-items:center;height:100vh;font-family:sans-serif;padding:2rem;text-align:center"><h1>Error al cargar el sitio</h1><p>Verifica que el archivo <code>data/content.json</code> exista y sea válido.</p><pre style="color:red;font-size:0.85rem;margin-top:1rem">${err.message}</pre></div>`;
    return;
  }

  renderNavbarLogo(data.site);
  renderNavbarSocial(data.site);
  renderHero(data.hero);
  renderQuienesSomos(data.quienesSomos);
  renderHistoria(data.historia);
  renderDirectores(data.directores);
  renderPatrocinadores(data.patrocinadores);
  renderServicios(data.servicios);
  renderComoAyudar(data.comoAyudar);
  renderNoticias(data.noticias);
  renderContacto(data.contacto, data.site);
  renderFooter(data.footer, data.site);
  renderDonateFab(data.site);

  initNavbar();
  initMobileMenu();
  initScrollReveal();
  initBackToTop();
  initContactForm(data.contacto);

  // Page title
  document.title = data.site.name || 'Hogar de Niñas Cupey';
}

// ——————————————————————————————————————
// RENDER FUNCTIONS
// ——————————————————————————————————————

function renderNavbarLogo(site) {
  if (!site) return;
  const img = document.getElementById('logo-img');
  const txt = document.getElementById('logo-text');
  if (img && site.logo) {
    img.src = site.logo;
    img.alt = site.name || 'Logo';
  }
  if (txt) txt.textContent = site.name || '';
}

function renderNavbarSocial(site) {
  const el = document.getElementById('navbar-social');
  if (!el || !site.socialMedia) return;
  el.innerHTML = Object.entries(site.socialMedia)
    .map(([platform, url]) => buildSocialIcon(platform, url))
    .join('');
}

function renderHero(hero) {
  if (!hero) return;

  const titleEl = document.getElementById('hero-title');
  const subtitleEl = document.getElementById('hero-subtitle');
  const ctaEl = document.getElementById('hero-cta');
  const heroSection = document.getElementById('inicio');

  if (titleEl) titleEl.innerHTML = hero.title || '';
  if (subtitleEl) subtitleEl.textContent = hero.subtitle || '';

  if (hero.backgroundImage && heroSection) {
    heroSection.style.backgroundImage = `url('${hero.backgroundImage}')`;
    heroSection.style.backgroundSize = 'cover';
    heroSection.style.backgroundPosition = 'center';
  }

  if (ctaEl && hero.cta) {
    const { primary, secondary } = hero.cta;
    ctaEl.innerHTML = `
      ${primary ? `<a href="${primary.href}" class="btn btn--outline">${primary.text}</a>` : ''}
      ${secondary ? `<a href="${secondary.href}" class="btn btn--gold">${secondary.text}</a>` : ''}
    `;
  }
}

function renderQuienesSomos(qs) {
  if (!qs) return;

  setText('qs-title', qs.title);

  const misionEl = document.getElementById('qs-mision');
  if (misionEl && qs.mision) {
    misionEl.innerHTML = `<h3>${qs.mision.titulo}</h3><p>${qs.mision.texto}</p>`;
  }

  const visionEl = document.getElementById('qs-vision');
  if (visionEl && qs.vision) {
    visionEl.innerHTML = `<h3>${qs.vision.titulo}</h3><p>${qs.vision.texto}</p>`;
  }

  const valoresEl = document.getElementById('valores-grid');
  if (valoresEl && qs.valores) {
    valoresEl.innerHTML = qs.valores.map(v => `
      <div class="valor-item reveal">
        <div class="valor-item__icon">${v.icono}</div>
        <div class="valor-item__title">${v.titulo}</div>
        <div class="valor-item__text">${v.texto}</div>
      </div>
    `).join('');
  }

  const statsEl = document.getElementById('stats-bar');
  if (statsEl && qs.estadisticas) {
    statsEl.innerHTML = qs.estadisticas.map(s => `
      <div class="stat-item">
        <span class="stat-item__number">${s.numero}</span>
        <span class="stat-item__label">${s.descripcion}</span>
      </div>
    `).join('');
  }
}

function renderHistoria(historia) {
  if (!historia) return;

  setText('historia-title', historia.title);
  setText('historia-intro', historia.introduccion);

  const timelineEl = document.getElementById('timeline');
  if (!timelineEl || !historia.hitos) return;

  timelineEl.innerHTML = historia.hitos.map((hito, i) => {
    const imgHtml = hito.imagen
      ? `<img src="${hito.imagen}" alt="${hito.titulo}" class="timeline-img" onerror="this.style.display='none'" />`
      : `<div class="timeline-img-placeholder">📜</div>`;
    return `
      <div class="timeline-item reveal">
        ${i % 2 === 0 ? `
          <div class="timeline-content">
            ${imgHtml}
            <h3>${hito.titulo}</h3>
            <p>${hito.texto}</p>
          </div>
          <div class="timeline-dot-col">
            <div class="timeline-dot"></div>
            <span class="timeline-year">${hito.anio}</span>
          </div>
          <div class="timeline-empty"></div>
        ` : `
          <div class="timeline-empty"></div>
          <div class="timeline-dot-col">
            <div class="timeline-dot"></div>
            <span class="timeline-year">${hito.anio}</span>
          </div>
          <div class="timeline-content">
            ${imgHtml}
            <h3>${hito.titulo}</h3>
            <p>${hito.texto}</p>
          </div>
        `}
      </div>
    `;
  }).join('');
}

function renderDirectores(dir) {
  if (!dir) return;

  setText('dir-title', dir.title);
  setText('dir-subtitle', dir.subtitle);

  const gridEl = document.getElementById('directors-grid');
  if (!gridEl || !dir.miembros) return;

  gridEl.innerHTML = dir.miembros.map(m => {
    const avatarHtml = m.foto
      ? `<img src="${m.foto}" alt="${m.nombre}" class="director-avatar" onerror="this.parentElement.innerHTML='<div class=director-avatar-placeholder>👩</div>'" />`
      : `<div class="director-avatar-placeholder">👩</div>`;
    return `
      <div class="director-card reveal">
        ${avatarHtml}
        <h3>${m.nombre}</h3>
        <div class="cargo">${m.cargo}</div>
        <p>${m.descripcion || ''}</p>
      </div>
    `;
  }).join('');
}

function renderPatrocinadores(pat) {
  if (!pat) return;

  setText('pat-title', pat.title);
  setText('pat-subtitle', pat.subtitle);

  const gridEl = document.getElementById('sponsors-grid');
  if (!gridEl || !pat.lista) return;

  gridEl.innerHTML = pat.lista.map(s => {
    const logoHtml = s.logo
      ? `<img src="${s.logo}" alt="${s.nombre}" class="sponsor-logo" onerror="this.parentElement.innerHTML='<div class=sponsor-logo-placeholder>🏢</div><span class=sponsor-name>${s.nombre}</span>'" />`
      : `<div class="sponsor-logo-placeholder">🏢</div>`;
    return `
      <div class="sponsor-card reveal">
        <a href="${s.url || '#'}" target="_blank" rel="noopener noreferrer">
          ${logoHtml}
          <span class="sponsor-name">${s.nombre}</span>
        </a>
        ${s.categoria ? `<span class="sponsor-category">${s.categoria}</span>` : ''}
      </div>
    `;
  }).join('');
}

function renderServicios(srv) {
  if (!srv) return;

  setText('srv-title', srv.title);
  setText('srv-subtitle', srv.subtitle);

  const gridEl = document.getElementById('services-grid');
  if (!gridEl || !srv.lista) return;

  gridEl.innerHTML = srv.lista.map(s => {
    const imgHtml = s.imagen
      ? `<img src="${s.imagen}" alt="${s.titulo}" class="service-img" onerror="this.parentElement.innerHTML='<div class=service-img-placeholder>${s.icono || '⭐'}</div>'" />`
      : `<div class="service-img-placeholder">${s.icono || '⭐'}</div>`;
    return `
      <div class="service-card reveal">
        ${imgHtml}
        <div class="service-body">
          <h3>${s.titulo}</h3>
          <p>${s.descripcion}</p>
        </div>
      </div>
    `;
  }).join('');
}

function renderComoAyudar(help) {
  if (!help) return;

  setText('help-title', help.title);
  setText('help-subtitle', help.subtitle);
  setText('help-nota', help.nota);

  const gridEl = document.getElementById('help-grid');
  if (!gridEl || !help.opciones) return;

  gridEl.innerHTML = help.opciones.map(o => `
    <div class="help-card ${o.destacado ? 'help-card--destacado' : ''} reveal">
      <div class="help-card__icon">${o.icono}</div>
      <h3>${o.titulo}</h3>
      <p>${o.descripcion}</p>
      <a href="${o.url}" class="btn ${o.destacado ? 'btn--primary' : 'btn--outline'}" ${o.url.startsWith('http') ? 'target="_blank" rel="noopener noreferrer"' : ''}>${o.cta}</a>
    </div>
  `).join('');
}

function renderNoticias(news) {
  if (!news) return;

  setText('news-title', news.title);
  setText('news-subtitle', news.subtitle);

  const gridEl = document.getElementById('news-grid');
  if (!gridEl || !news.eventos) return;

  const sorted = [...news.eventos].sort((a, b) => new Date(a.fecha) - new Date(b.fecha));

  gridEl.innerHTML = sorted.map(e => {
    const imgHtml = e.imagen
      ? `<img src="${e.imagen}" alt="${e.titulo}" class="news-img" onerror="this.parentElement.innerHTML='<div class=news-img-placeholder>📰</div>'" />`
      : `<div class="news-img-placeholder">📰</div>`;
    return `
      <div class="news-card reveal">
        ${imgHtml}
        <div class="news-body">
          <div class="news-meta">
            ${e.categoria ? `<span class="news-category">${e.categoria}</span>` : ''}
            <span class="news-date">${formatDate(e.fecha)}</span>
          </div>
          <h3>${e.titulo}</h3>
          <p>${e.descripcion}</p>
        </div>
      </div>
    `;
  }).join('');
}

function renderContacto(contacto, site) {
  if (!contacto) return;

  setText('contact-title', contacto.title);
  setText('contact-subtitle', contacto.subtitle);

  const infoEl = document.getElementById('contact-info');
  if (infoEl && contacto.info) {
    const { direccion, telefono, email, horario } = contacto.info;
    const socialHtml = site && site.socialMedia
      ? `<div class="contact-social-links">${Object.entries(site.socialMedia).map(([p, u]) => buildSocialIcon(p, u)).join('')}</div>`
      : '';

    infoEl.innerHTML = `
      <h3>Información de Contacto</h3>
      ${direccion ? `<div class="contact-info-item"><div class="contact-info-icon">📍</div><div class="contact-info-text"><strong>Dirección</strong><span>${direccion}</span></div></div>` : ''}
      ${telefono ? `<div class="contact-info-item"><div class="contact-info-icon">📞</div><div class="contact-info-text"><strong>Teléfono</strong><span>${telefono}</span></div></div>` : ''}
      ${email ? `<div class="contact-info-item"><div class="contact-info-icon">✉️</div><div class="contact-info-text"><strong>Correo</strong><span><a href="mailto:${email}" style="color:inherit">${email}</a></span></div></div>` : ''}
      ${horario ? `<div class="contact-info-item"><div class="contact-info-icon">🕐</div><div class="contact-info-text"><strong>Horario</strong><span>${horario}</span></div></div>` : ''}
      ${socialHtml}
    `;
  }
}

function renderFooter(footer, site) {
  if (!footer) return;

  setText('footer-name', site ? site.name : '');
  setText('footer-org', footer.textoOrganizacion || '');
  setText('footer-copy', footer.texto || '');

  const socialEl = document.getElementById('footer-social');
  if (socialEl && site && site.socialMedia) {
    socialEl.innerHTML = Object.entries(site.socialMedia)
      .map(([p, u]) => buildSocialIcon(p, u))
      .join('');
  }

  const linksEl = document.getElementById('footer-links');
  if (linksEl && footer.links) {
    linksEl.innerHTML = footer.links
      .map(l => `<a href="${l.href}">${l.texto}</a>`)
      .join('');
  }
}

function renderDonateFab(site) {
  const fab = document.getElementById('donate-fab');
  if (fab && site && site.donateUrl) {
    fab.href = site.donateUrl;
  }
}

// ——————————————————————————————————————
// NAVBAR BEHAVIOR
// ——————————————————————————————————————

function initNavbar() {
  const navbar = document.getElementById('navbar');
  const links = document.querySelectorAll('.navbar__link');
  const sections = document.querySelectorAll('section[id]');
  const DROPDOWN_SECTIONS = ['quienes-somos', 'historia', 'directores', 'patrocinadores'];

  // Dropdown toggle
  const dropdown = document.querySelector('.navbar__dropdown');
  const toggle   = dropdown && dropdown.querySelector('.navbar__dropdown-toggle');
  if (dropdown && toggle) {
    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = dropdown.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen);
    });
    document.addEventListener('click', () => {
      dropdown.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    });
    dropdown.addEventListener('click', e => e.stopPropagation());
  }

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);

    let current = '';
    sections.forEach(s => {
      if (window.scrollY >= s.offsetTop - 100) current = s.id;
    });

    links.forEach(link => {
      link.classList.toggle('active', link.getAttribute('href') === `#${current}`);
    });

    // Highlight dropdown toggle when any of its sections is active
    if (toggle) {
      toggle.classList.toggle('active', DROPDOWN_SECTIONS.includes(current));
    }
  }, { passive: true });

  // Smooth scroll for all anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = document.getElementById('navbar').offsetHeight;
        window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });
        // Close dropdown after clicking a dropdown item
        if (dropdown) { dropdown.classList.remove('open'); toggle && toggle.setAttribute('aria-expanded', 'false'); }
      }
    });
  });
}

// ——————————————————————————————————————
// MOBILE MENU
// ——————————————————————————————————————

function initMobileMenu() {
  const hamburger  = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');
  const mobileClose = document.getElementById('mobile-close');
  const mobileLinks = document.querySelectorAll('.mobile-menu__link, .mobile-menu__sublink');

  const open  = () => { mobileMenu.classList.add('open'); document.body.style.overflow = 'hidden'; };
  const close = () => { mobileMenu.classList.remove('open'); document.body.style.overflow = ''; };

  if (hamburger)  hamburger.addEventListener('click', open);
  if (mobileClose) mobileClose.addEventListener('click', close);
  mobileLinks.forEach(l => l.addEventListener('click', close));

  // Accordion for "Quiénes Somos" group
  const groupToggle = document.querySelector('.mobile-menu__group-toggle');
  const group       = document.querySelector('.mobile-menu__group');
  if (groupToggle && group) {
    groupToggle.addEventListener('click', () => group.classList.toggle('open'));
  }
}

// ——————————————————————————————————————
// SCROLL REVEAL
// ——————————————————————————————————————

function initScrollReveal() {
  const observer = new IntersectionObserver(
    entries => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } }),
    { threshold: 0.12 }
  );
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
}

// ——————————————————————————————————————
// BACK TO TOP
// ——————————————————————————————————————

function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;
  window.addEventListener('scroll', () => {
    btn.classList.toggle('visible', window.scrollY > 400);
  }, { passive: true });
  btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

// ——————————————————————————————————————
// CONTACT FORM — EmailJS
// ——————————————————————————————————————

function initContactForm(contacto) {
  const form = document.getElementById('contact-form');
  if (!form) return;

  // Initialize EmailJS with public key from content.json
  if (contacto && contacto.emailjs && contacto.emailjs.publicKey &&
      contacto.emailjs.publicKey !== 'TU_PUBLIC_KEY') {
    if (typeof emailjs !== 'undefined') {
      emailjs.init(contacto.emailjs.publicKey);
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const name    = document.getElementById('contact-name');
    const email   = document.getElementById('contact-email');
    const message = document.getElementById('contact-message');
    const feedback = document.getElementById('form-feedback');
    const btnText    = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    // Clear errors
    clearError('err-name');
    clearError('err-email');
    clearError('err-message');
    feedback.className = 'form-feedback';
    feedback.textContent = '';

    // Validate
    let valid = true;
    if (!name.value.trim()) { showError('err-name', 'Por favor ingresa tu nombre.'); name.classList.add('error'); valid = false; }
    else name.classList.remove('error');

    if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      showError('err-email', 'Por favor ingresa un correo válido.'); email.classList.add('error'); valid = false;
    } else email.classList.remove('error');

    if (!message.value.trim()) { showError('err-message', 'Por favor escribe tu mensaje.'); message.classList.add('error'); valid = false; }
    else message.classList.remove('error');

    if (!valid) return;

    // Check EmailJS config
    const ejsConf = contacto && contacto.emailjs;
    const isConfigured = ejsConf &&
      ejsConf.serviceId  !== 'TU_SERVICE_ID'  &&
      ejsConf.templateId !== 'TU_TEMPLATE_ID' &&
      ejsConf.publicKey  !== 'TU_PUBLIC_KEY';

    if (!isConfigured) {
      feedback.textContent = '⚙️ Para activar el formulario, configura EmailJS en data/content.json (ver instrucciones abajo).';
      feedback.className = 'form-feedback error';
      return;
    }

    // Send via EmailJS
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline';
    document.getElementById('contact-submit').disabled = true;

    const templateParams = {
      from_name:    name.value.trim(),
      from_email:   email.value.trim(),
      subject:      (document.getElementById('contact-subject').value || 'Mensaje desde el sitio web').trim(),
      message:      message.value.trim(),
      to_email:     'info@hogardeninasdecupey.org',
    };

    try {
      await emailjs.send(ejsConf.serviceId, ejsConf.templateId, templateParams);
      form.reset();
      feedback.textContent = '✅ ¡Mensaje enviado con éxito! Nos pondremos en contacto pronto.';
      feedback.className = 'form-feedback success';
    } catch (err) {
      console.error('[EmailJS] Error:', err);
      feedback.textContent = '❌ Hubo un error al enviar. Por favor intenta de nuevo o contáctanos directamente.';
      feedback.className = 'form-feedback error';
    } finally {
      btnText.style.display = 'inline';
      btnLoading.style.display = 'none';
      document.getElementById('contact-submit').disabled = false;
    }
  });
}

// ——————————————————————————————————————
// HELPERS
// ——————————————————————————————————————

function setText(id, value) {
  const el = document.getElementById(id);
  if (el && value !== undefined) el.textContent = value;
}

function showError(id, msg) {
  const el = document.getElementById(id);
  if (el) el.textContent = msg;
}

function clearError(id) {
  const el = document.getElementById(id);
  if (el) el.textContent = '';
}

// ——— Start app ———
document.addEventListener('DOMContentLoaded', init);
