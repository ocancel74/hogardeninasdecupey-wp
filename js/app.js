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
  renderIntro(data.intro);
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
  initNoticiaRouting(data.noticias.eventos || []);

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
      ${primary ? `<a href="${primary.href}" class="btn btn--primary">${primary.text}</a>` : ''}
      ${secondary ? `<a href="${secondary.href}" class="btn btn--outline">${secondary.text}</a>` : ''}
    `;
  }
}

function renderIntro(intro) {
  if (!intro) return;
  setText('intro-title', intro.titulo);

  const bodyEl = document.getElementById('intro-body');
  if (bodyEl) {
    let html = '';
    if (intro.parrafos) {
      html += intro.parrafos.map(p => `<p>${p}</p>`).join('');
    }
    if (intro.subSecciones) {
      html += intro.subSecciones.map(s => `
        ${s.subtitulo ? `<span class="intro__subtitulo">${s.subtitulo}</span>` : ''}
        <p>${s.texto}</p>
      `).join('');
    }
    bodyEl.innerHTML = html;
  }

  const ctaEl = document.getElementById('intro-cta');
  if (ctaEl && intro.cta) {
    ctaEl.innerHTML = `<a href="${intro.cta.href}" class="btn btn--primary">${intro.cta.text}</a>`;
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

  // ——— Galería de 5 fotos ———
  const fotosEl = document.getElementById('historia-fotos');
  if (fotosEl && historia.fotos) {
    fotosEl.innerHTML = historia.fotos.map((src, i) => `
      <div class="historia-fotos__item">
        <img src="${src}" alt="Historia ${i + 1}"
          onerror="this.parentElement.innerHTML='<div class=historia-foto-placeholder>📷</div>'" />
      </div>
    `).join('');
  }

  // ——— Cuerpo de texto ———
  const bodyEl = document.getElementById('historia-body');
  if (!bodyEl) return;

  let html = `<h2 class="section__title" style="margin-bottom:2rem">${historia.title || ''}</h2>`;

  // Secciones de texto — el logo se inserta después del primer párrafo (índice 0)
  const logoSrc = historia.logoMedio || 'assets/images/logo.png';
  if (historia.secciones) {
    historia.secciones.forEach((s, i) => {
      if (s.subtitulo) html += `<span class="historia-subtitulo">${s.subtitulo}</span>`;
      html += `<p>${s.texto}</p>`;
      // Logo va después del primer párrafo, antes del segundo
      if (i === 0) {
        html += `<div class="historia-logo-wrap">
          <img src="${logoSrc}" alt="Hogar de Niñas Cupey" class="historia-logo" />
        </div>`;
      }
    });
  }

  // Para qué existimos
  const pq = historia.paraQueExistimos;
  if (pq) {
    html += `<div class="para-que">
      <h3 class="para-que__titulo">${pq.subtitulo}</h3>
      <p class="para-que__mv"><strong>${pq.mision.titulo}</strong><br>${pq.mision.texto}</p>
      <p class="para-que__mv"><strong>${pq.vision.titulo}</strong><br>${pq.vision.texto}</p>
      <div class="compromisos-grid">
        <div class="compromisos-col">
          <h4>${pq.compromisos.titulo}</h4>
          <ul>${pq.compromisos.lista.map(i => `<li>${i}</li>`).join('')}</ul>
        </div>
        <div class="compromisos-col">
          <h4>${pq.fortalezas.titulo}</h4>
          <ul>${pq.fortalezas.lista.map(i => `<li>${i}</li>`).join('')}</ul>
        </div>
      </div>
    </div>`;
  }

  bodyEl.innerHTML = html;
}

function renderDirectores(dir) {
  if (!dir) return;

  setText('dir-title', dir.title);
  setText('dir-subtitle', dir.subtitle);

  const gridEl = document.getElementById('directors-grid');
  if (!gridEl) return;

  // Build individual director cards
  const buildCard = (m, isGrupo = false) => {
    const photoInner = m.foto
      ? `<img src="${m.foto}" alt="${m.nombre}" onerror="this.parentElement.innerHTML='<div class=director-photo-placeholder>👤</div>'" />`
      : `<div class="director-photo-placeholder">👤</div>`;
    return `
      <div class="director-card ${isGrupo ? 'director-card--grupo' : ''} reveal">
        <div class="director-photo-wrap">${photoInner}</div>
        <div class="director-info">
          <h3>${m.nombre}</h3>
          ${m.cargo ? `<span class="cargo">${m.cargo}</span>` : ''}
          ${m.descripcion ? `<p class="desc">${m.descripcion}</p>` : ''}
        </div>
      </div>
    `;
  };

  // Junta de directores
  if (dir.miembros) {
    gridEl.innerHTML = dir.miembros.map(m => buildCard(m)).join('');
  }

  // Administración section
  const adminSection = document.getElementById('admin-section');
  if (adminSection && dir.administracion) {
    const adm = dir.administracion;
    adminSection.innerHTML = `
      <h3 class="admin-subtitle">${adm.titulo}</h3>
      <div class="admin-grid">
        ${adm.miembros.map(m => buildCard(m, m.tipo === 'grupo')).join('')}
      </div>
    `;
  }
}

function renderPatrocinadores(pat) {
  if (!pat) return;

  setText('pat-title', pat.title);
  setText('pat-subtitle', pat.subtitle);

  const gridEl = document.getElementById('sponsors-grid');
  if (!gridEl || !pat.lista) return;

  gridEl.innerHTML = pat.lista.map(s => {
    const logoHtml = s.logo
      ? `<img src="${s.logo}" alt="${s.nombre}" class="sponsor-logo"
          onerror="this.parentElement.innerHTML='<div class=sponsor-logo-placeholder>🏢</div>'" />`
      : `<div class="sponsor-logo-placeholder">🏢</div>`;
    const linkUrl = s.url && s.url !== '#' ? s.url : null;
    return `
      <div class="sponsor-card reveal">
        <div class="sponsor-logo-wrap">${logoHtml}</div>
        <span class="sponsor-name">${s.nombre}</span>
        ${linkUrl
          ? `<a href="${linkUrl}" target="_blank" rel="noopener noreferrer" class="sponsor-link">${s.linkText || 'Clic para conocer más'}</a>`
          : `<span class="sponsor-link" style="visibility:hidden">—</span>`}
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

  const el = document.getElementById('help-content');
  if (!el) return;

  let html = '';

  // Conviértete en amigo
  if (help.amigo) {
    html += `<div class="help-block">
      <h2 class="help-heading">${help.amigo.titulo}</h2>
      ${(help.amigo.parrafos || []).map(p => `<p class="help-parrafo">${p}</p>`).join('')}
    </div>`;
  }

  // Conviértete en voluntario
  if (help.voluntario) {
    html += `<div class="help-block">
      <h2 class="help-heading">${help.voluntario.titulo}</h2>
      ${help.voluntario.intro ? `<p class="help-parrafo">${help.voluntario.intro}</p>` : ''}
      ${help.voluntario.lista ? `<ul class="help-lista">${help.voluntario.lista.map(i => `<li>${i}</li>`).join('')}</ul>` : ''}
    </div>`;
  }

  // Cómo donar
  if (help.donar) {
    const pp = help.donar.paypal;
    const ath = help.donar.athMovil;
    html += `<div class="help-block">
      <h2 class="help-heading">${help.donar.titulo}</h2>
      <div class="help-donar-grid">
        ${pp ? `<div class="help-donar-col">
          <p class="help-donar-metodo">${pp.titulo}</p>
          <a href="${pp.url}" target="_blank" rel="noopener noreferrer" class="btn btn--primary">${pp.boton}</a>
        </div>` : ''}
        ${ath ? `<div class="help-donar-col">
          ${ath.qr ? `<img src="${ath.qr}" alt="QR ATH Móvil" class="help-ath-qr" onerror="this.style.display='none'" />` : ''}
          ${ath.usuario ? `<p class="help-ath-usuario">${ath.usuario}</p>` : ''}
          ${ath.logo ? `<img src="${ath.logo}" alt="ATH Móvil" class="help-ath-logo" onerror="this.style.display='none'" />` : ''}
        </div>` : ''}
      </div>
    </div>`;
  }

  el.innerHTML = html;
}

function renderNoticias(news) {
  if (!news) return;

  setText('news-title', news.title);
  setText('news-subtitle', news.subtitle);

  const gridEl = document.getElementById('news-grid');
  if (!gridEl || !news.eventos) return;

  const sorted = [...news.eventos].sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

  gridEl.innerHTML = sorted.map(e => {
    const imgHtml = e.imagen
      ? `<div class="news-img-wrap"><img src="${e.imagen}" alt="${e.titulo}" class="news-img" onerror="this.parentElement.innerHTML='<div class=news-img-placeholder>📰</div>'" /></div>`
      : `<div class="news-img-placeholder">📰</div>`;
    const leerMas = e.slug
      ? `<button class="news-leer-mas" data-slug="${e.slug}">Leer más</button>`
      : '';
    return `
      <div class="news-card reveal" ${e.slug ? `data-slug="${e.slug}"` : ''}>
        ${imgHtml}
        <div class="news-body">
          <div class="news-meta">
            ${e.categoria ? `<span class="news-category">${e.categoria}</span>` : ''}
            <span class="news-date">${formatDate(e.fecha)}</span>
          </div>
          <h3>${e.titulo}</h3>
          <p>${e.descripcion}</p>
          ${leerMas}
        </div>
      </div>
    `;
  }).join('');
}

// ——————————————————————————————————————
// NOTICIA — PÁGINA INDIVIDUAL
// ——————————————————————————————————————

function renderNoticiaPagina(noticia) {
  const el = document.getElementById('noticia-content');
  if (!el) return;

  let html = `
    <div class="noticia-meta-bar">
      <span>© HOGARDENIÑAS</span>
      <span>📅 ${formatDate(noticia.fecha)}</span>
      ${noticia.categoria ? `<span>📁 ${noticia.categoria.toUpperCase()}</span>` : ''}
    </div>
  `;

  if (noticia.imagen) {
    html += `<img src="${noticia.imagen}" alt="${noticia.titulo}" class="noticia-hero-img"
      onerror="this.style.display='none'" />`;
  }

  html += `<h1 class="noticia-titulo">${noticia.titulo}</h1>`;

  if (noticia.cuerpo && noticia.cuerpo.length) {
    noticia.cuerpo.forEach(bloque => {
      switch (bloque.tipo) {
        case 'parrafo':
          html += `<p>${bloque.texto.replace(/\n/g, '<br>')}</p>`;
          break;
        case 'subtitulo':
          html += `<h4 class="noticia-subtitulo">${bloque.texto}</h4>`;
          break;
        case 'lista':
          html += `<ul class="noticia-lista">${bloque.items.map(i => `<li>${i}</li>`).join('')}</ul>`;
          break;
        case 'fotos':
          html += `<div class="noticia-fotos-grid">${bloque.imagenes.map(src =>
            `<img src="${src}" alt="" onerror="this.style.display='none'" />`
          ).join('')}</div>`;
          break;
      }
    });
  } else {
    html += `<p>${noticia.descripcion}</p>`;
  }

  el.innerHTML = html;
}

function showNoticia(slug, eventos) {
  const noticia = eventos.find(n => n.slug === slug);
  if (!noticia) return;

  renderNoticiaPagina(noticia);

  const overlay = document.getElementById('noticia-overlay');
  overlay.style.display = 'block';
  overlay.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
  overlay.scrollTop = 0;
}

function hideNoticia() {
  const overlay = document.getElementById('noticia-overlay');
  overlay.style.display = 'none';
  overlay.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}

function initNoticiaRouting(eventos) {
  // Back button
  const backBtn = document.getElementById('noticia-back');
  if (backBtn) {
    backBtn.addEventListener('click', () => {
      hideNoticia();
      history.replaceState(null, '', window.location.pathname + '#noticias');
      const section = document.getElementById('noticias');
      if (section) {
        const offset = document.getElementById('navbar').offsetHeight;
        window.scrollTo({ top: section.offsetTop - offset, behavior: 'smooth' });
      }
    });
  }

  // Clicks on news cards / "Leer más" buttons
  document.getElementById('news-grid').addEventListener('click', e => {
    const btn = e.target.closest('[data-slug]');
    if (!btn) return;
    e.preventDefault();
    const slug = btn.dataset.slug;
    history.pushState({ slug }, '', `#noticia/${slug}`);
    showNoticia(slug, eventos);
  });

  // Browser back/forward
  window.addEventListener('popstate', () => {
    const hash = window.location.hash;
    if (hash.startsWith('#noticia/')) {
      showNoticia(hash.replace('#noticia/', ''), eventos);
    } else {
      hideNoticia();
    }
  });

  // Handle direct URL with hash on page load
  const hash = window.location.hash;
  if (hash.startsWith('#noticia/')) {
    showNoticia(hash.replace('#noticia/', ''), eventos);
  }
}

function renderContacto(contacto, site) {
  if (!contacto) return;

  const officeEl = document.getElementById('contact-office-info');
  if (officeEl && contacto.info) {
    const { email, telefono, horario, direccion } = contacto.info;
    officeEl.innerHTML = `
      <h2 class="contact-office-title">${contacto.tituloInfo || 'Información de oficina'}</h2>
      <ul class="contact-office-list">
        ${email    ? `<li><span class="contact-office-icon">✉</span><a href="mailto:${email}">${email}</a></li>` : ''}
        ${telefono ? `<li><span class="contact-office-icon">☎</span>${telefono}</li>` : ''}
        ${horario  ? `<li><span class="contact-office-icon">🕐</span>${horario}</li>` : ''}
        ${direccion? `<li><span class="contact-office-icon">📬</span>${direccion}</li>` : ''}
      </ul>
    `;
  }

  setText('contact-form-heading', contacto.tituloForm || 'Contáctenos');

  const mapEl = document.getElementById('contact-map-section');
  if (mapEl && contacto.mapaEmbed) {
    mapEl.innerHTML = `
      <h2 class="contact-map-title">${contacto.tituloMapa || 'Cómo llegar'}</h2>
      <div class="contact-map-wrap">
        <iframe
          src="${contacto.mapaEmbed}"
          width="100%" height="420" style="border:0;" allowfullscreen=""
          loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          title="Mapa Hogar de Niñas de Cupey">
        </iframe>
      </div>
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

  if (contacto && contacto.emailjs && contacto.emailjs.publicKey &&
      contacto.emailjs.publicKey !== 'TU_PUBLIC_KEY') {
    if (typeof emailjs !== 'undefined') {
      emailjs.init(contacto.emailjs.publicKey);
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email   = document.getElementById('contact-email');
    const message = document.getElementById('contact-message');
    const feedback  = document.getElementById('form-feedback');
    const btnText   = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    clearError('err-email');
    clearError('err-message');
    feedback.className = 'form-feedback';
    feedback.textContent = '';

    let valid = true;
    if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      showError('err-email', 'Por favor ingresa un correo válido.'); email.classList.add('error'); valid = false;
    } else email.classList.remove('error');

    if (!message.value.trim()) { showError('err-message', 'Por favor escribe tu mensaje.'); message.classList.add('error'); valid = false; }
    else message.classList.remove('error');

    if (!valid) return;

    const ejsConf = contacto && contacto.emailjs;
    const isConfigured = ejsConf &&
      ejsConf.serviceId  !== 'TU_SERVICE_ID'  &&
      ejsConf.templateId !== 'TU_TEMPLATE_ID' &&
      ejsConf.publicKey  !== 'TU_PUBLIC_KEY';

    if (!isConfigured) {
      feedback.textContent = '⚙️ Para activar el formulario, configura EmailJS en data/content.json.';
      feedback.className = 'form-feedback error';
      return;
    }

    btnText.style.display = 'none';
    btnLoading.style.display = 'inline';
    document.getElementById('contact-submit').disabled = true;

    const g = id => { const el = document.getElementById(id); return el ? el.value.trim() : ''; };
    const templateParams = {
      from_name:    `${g('contact-nombre')} ${g('contact-apellidos')}`.trim(),
      from_email:   email.value.trim(),
      telefono:     g('contact-telefono'),
      direccion:    [g('contact-linea1'), g('contact-linea2'), g('contact-ciudad'), g('contact-estado'), g('contact-postal'), g('contact-pais')].filter(Boolean).join(', '),
      subject:      g('contact-tema') || 'Mensaje desde el sitio web',
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
