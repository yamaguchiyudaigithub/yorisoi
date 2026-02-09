/**
 * Front scripts (minimal)
 * - Drawer menu (hamburger)
 * - Smooth scroll for in-page anchors (header offset)
 * - Scroll-in animation (sections ふわっと表示)
 */

(() => {
  const BREAKPOINT_TABLET = 768;
  const SCROLL_IN_CLASS = "is-inview";
  const SCROLL_IN_ROOT_MARGIN = "0px 0px -8% 0px"; // 少し見えたら発火
  const SCROLL_IN_THRESHOLD = 0.05;

  function lockBodyScroll() {
    const scrollY = window.scrollY || window.pageYOffset || 0;
  document.body.style.position = "fixed";
  document.body.style.top = `-${scrollY}px`;
  document.body.style.width = "100%";
  document.body.dataset.scrollY = String(scrollY);
}

  function unlockBodyScroll() {
    const scrollY = parseInt(document.body.dataset.scrollY || "0", 10);
  document.body.style.position = "";
  document.body.style.top = "";
  document.body.style.width = "";
  delete document.body.dataset.scrollY;
    window.scrollTo(0, scrollY);
  }

  function show(el) {
    el.style.display = "block";
    el.style.opacity = "1";
  }

  function hide(el) {
    el.style.display = "none";
    el.style.opacity = "0";
  }

  function openDrawer(hamburger, drawer) {
    hamburger.classList.add("is-open");
    hamburger.setAttribute("aria-expanded", "true");
    hamburger.setAttribute("aria-label", "メニューを閉じる");
    drawer.setAttribute("aria-hidden", "false");
    lockBodyScroll();
    show(drawer);
  }

  function closeDrawer(hamburger, drawer) {
    hamburger.classList.remove("is-open");
    hamburger.setAttribute("aria-expanded", "false");
    hamburger.setAttribute("aria-label", "メニューを開く");
    drawer.setAttribute("aria-hidden", "true");
    hide(drawer);
    unlockBodyScroll();
  }

  function isHashLinkToSamePage(url) {
    if (!url.hash) return false;
    const current = new URL(window.location.href);
    return url.origin === current.origin && url.pathname === current.pathname;
  }

  function getHeaderOffset() {
    // fixed header height (fallback 0)
    const header = document.querySelector("header");
    return header ? header.getBoundingClientRect().height : 0;
  }

  function smoothScrollToTarget(target) {
    const offset = getHeaderOffset();
    const targetTop = window.scrollY + target.getBoundingClientRect().top - offset;
    const top = Math.max(0, Math.floor(targetTop));
    try {
      window.scrollTo({ top, behavior: "smooth" });
    } catch {
      window.scrollTo(0, top);
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    // セクションごとにふわっと表示（Scroll-in animation）
    const scrollSections = document.querySelectorAll(".p-top-dx > section");
    if (scrollSections.length > 0 && "IntersectionObserver" in window) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add(SCROLL_IN_CLASS);
            }
          });
        },
        { rootMargin: SCROLL_IN_ROOT_MARGIN, threshold: SCROLL_IN_THRESHOLD }
      );
      scrollSections.forEach((section) => observer.observe(section));
    }

    // Header reveal (show from 2nd section)
    const header = document.querySelector(".p-header");
    const fvSection = document.querySelector(".p-top-dx__fv");
    if (header && fvSection) {
      header.classList.add("is-reveal-enabled");

      const updateHeaderVisibility = () => {
        const headerHeight = header.getBoundingClientRect().height || 0;
        const triggerY = fvSection.offsetTop + fvSection.offsetHeight - headerHeight;
        const shouldReveal = window.scrollY >= Math.max(0, triggerY);
        header.classList.toggle("is-revealed", shouldReveal);
      };

      // initial + listeners
      updateHeaderVisibility();

      let rafId = 0;
      const requestUpdate = () => {
        if (rafId) return;
        rafId = window.requestAnimationFrame(() => {
          rafId = 0;
          updateHeaderVisibility();
        });
      };

      window.addEventListener("scroll", requestUpdate, { passive: true });
      window.addEventListener("resize", requestUpdate);
    }

    // Drawer
    const hamburger = document.querySelector(".js-hamburger");
    const drawer = document.querySelector(".js-drawer");
    if (hamburger && drawer) {
      // initial state
      if (drawer.getAttribute("aria-hidden") !== "false") {
        hide(drawer);
      }

      hamburger.addEventListener("click", () => {
        const isOpen = hamburger.classList.contains("is-open");
        if (isOpen) {
          closeDrawer(hamburger, drawer);
    } else {
          openDrawer(hamburger, drawer);
        }
      });

      // close when clicking the close button inside drawer
      const closeBtn = drawer.querySelector(".js-drawer-close");
      if (closeBtn) {
        closeBtn.addEventListener("click", () => closeDrawer(hamburger, drawer));
      }

      // close when clicking any link inside drawer
      drawer.querySelectorAll("a[href]").forEach((a) => {
        a.addEventListener("click", () => closeDrawer(hamburger, drawer));
      });

      // close on Esc
      window.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && hamburger.classList.contains("is-open")) {
          closeDrawer(hamburger, drawer);
        }
      });

      // close when switching to desktop
      window.addEventListener("resize", () => {
        if (window.matchMedia(`(min-width: ${BREAKPOINT_TABLET}px)`).matches) {
          if (hamburger.classList.contains("is-open")) {
            closeDrawer(hamburger, drawer);
          }
        }
      });
    }

    // Smooth scroll for in-page anchors (including /#... links)
    document.addEventListener("click", (e) => {
      const link = e.target instanceof Element ? e.target.closest('a[href*="#"]') : null;
      if (!link) return;

      let url;
      try {
        url = new URL(link.getAttribute("href"), window.location.href);
      } catch {
    return;
      }

      if (!isHashLinkToSamePage(url)) return;

      const id = url.hash.slice(1);
      if (!id) return;

      const target = document.getElementById(id);
      if (!target) return;

    e.preventDefault();
      smoothScrollToTarget(target);
    });

    // スタッフ紹介：SP時の「続きを読む」
    document.querySelectorAll(".js-staff-bio-more").forEach((btn) => {
      const wrap = btn.closest(".p-top-dx__staff-bio-wrap");
      if (!wrap) return;
      const openText = btn.dataset.openText || "続きを読む";
      const closeText = btn.dataset.closeText || "閉じる";
      btn.addEventListener("click", () => {
        const isOpen = wrap.classList.toggle("is-open");
        btn.textContent = isOpen ? closeText : openText;
        btn.setAttribute("aria-expanded", isOpen ? "true" : "false");
      });
    });
  });
})();
