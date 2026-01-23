import "./bootstrap";

import Alpine from "alpinejs";
window.Alpine = Alpine;

/**
 * Theme helpers
 * - Uses <html class="dark">
 * - Persists to localStorage("theme"): "dark" | "light"
 */
function applyTheme(isDark) {
  document.documentElement.classList.toggle("dark", isDark);
}

function getSavedTheme() {
  const saved = localStorage.getItem("theme"); // "dark" | "light" | null
  if (saved === "dark") return "dark";
  if (saved === "light") return "light";
  return null;
}

function prefersDark() {
  return window.matchMedia?.("(prefers-color-scheme: dark)")?.matches ?? false;
}

/**
 * Global API (safe for inline scripts)
 */
window.setTheme = (mode) => {
  const isDark = mode === "dark";
  localStorage.setItem("theme", isDark ? "dark" : "light");
  applyTheme(isDark);

  // sync Alpine store if present
  try {
    if (Alpine?.store?.("theme")) Alpine.store("theme").isDark = isDark;
  } catch (_) {}
};

window.getTheme = () => (document.documentElement.classList.contains("dark") ? "dark" : "light");

/**
 * IMPORTANT:
 * layout/app.blade.php already sets theme before paint.
 * Here we only "normalize" if localStorage explicitly says otherwise.
 */
(() => {
  const saved = getSavedTheme();
  if (saved) {
    applyTheme(saved === "dark");
  } else {
    // keep whatever the layout chose, but align with system if nothing set yet
    applyTheme(prefersDark());
  }
})();

/**
 * Notifications sidebar Alpine component (keeps blade clean)
 */
window.notifSidebar = function notifSidebar() {
  return {
    notifOpen: false,
    notifTab: "all",
    menuOpen: false,

    // ✅ start 0, then fetch real count
    unreadCount: 0,

    async init() {
      // 1) fetch unread count on load
      await this.fetchUnreadCount();

      // 2) listen for updates from notifications page (mark read / mark all read)
      window.addEventListener("notif-updated", (e) => {
        this.unreadCount = e.detail?.count ?? 0;
      });
    },

    async fetchUnreadCount() {
      try {
        const res = await fetch("/notifications/unread", {
          headers: { Accept: "application/json" },
        });
        if (!res.ok) return;

        const data = await res.json();

        // your controller returns { count: n }
        this.unreadCount = data.count ?? 0;
      } catch (err) {
        // ignore
      }
    },

    toggleNotif() {
      this.notifOpen = !this.notifOpen;
      this.menuOpen = false;
    },

    closeAll() {
      this.notifOpen = false;
      this.menuOpen = false;
    },
  };
};

document.addEventListener("alpine:init", () => {
  Alpine.store("theme", {
    isDark: document.documentElement.classList.contains("dark"),
    set(mode) {
      window.setTheme(mode);
      this.isDark = mode === "dark";
    },
    toggle() {
      this.set(this.isDark ? "light" : "dark");
    },
  });
});

Alpine.start();
