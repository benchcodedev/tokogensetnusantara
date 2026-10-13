// Vanilla JS (Max 40 lines total): Drawer Menu Mobile & Lightbox Galeri
document.addEventListener('DOMContentLoaded', () => {
  const drawer = document.getElementById('mobile-drawer');
  const toggleDrawer = (open) => {
    if (!drawer) return;
    drawer.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  };
  document.getElementById('drawer-open')?.addEventListener('click', () => toggleDrawer(true));
  document.getElementById('drawer-close')?.addEventListener('click', () => toggleDrawer(false));
  drawer?.querySelectorAll('.drawer-link')?.forEach(l => l.addEventListener('click', () => toggleDrawer(false)));

  const modal = document.getElementById('lightbox-modal');
  const modalImg = document.getElementById('lightbox-img');
  const closeBox = () => {
    if (modal) { modal.classList.remove('active'); document.body.style.overflow = ''; }
  };
  document.querySelectorAll('[data-lightbox-src]').forEach(el => {
    el.addEventListener('click', () => {
      const src = el.getAttribute('data-lightbox-src');
      if (modal && modalImg && src) {
        modalImg.src = src;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  document.getElementById('lightbox-close')?.addEventListener('click', closeBox);
  modal?.addEventListener('click', (e) => { if (e.target === modal) closeBox(); });
});
