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
    unreadCount: 3,
    items: [
      { id: 1, unread: true,  name: "Cyril Lucero",       text: "invited you to like LemPang.",                time: "1d", type: "invite", avatar: "https://i.pravatar.cc/120?img=11" },
      { id: 2, unread: true,  name: "Chyll Mixel Carlos", text: "invited you to like Cloud Collectibles.",     time: "2d", type: "invite", avatar: "https://i.pravatar.cc/120?img=15" },
      { id: 3, unread: true,  name: "James De Guzman",    text: "invited you to follow Athena East.",          time: "2d", type: "invite", avatar: "https://i.pravatar.cc/120?img=28" },
      { id: 4, unread: false, name: "PUPCOM",             text: "Your birthday is 3 days away. 🎉",            time: "3d", type: "info",   avatar: "/images/logo.png" },
      { id: 5, unread: false, name: "Migz Labiano",       text: "reacted to your post.",                       time: "1w", type: "like",   avatar: "https://i.pravatar.cc/120?img=49" },
    ],

    toggleNotif() {
      this.notifOpen = !this.notifOpen;
      this.menuOpen = false;
    },

    closeAll() {
      this.notifOpen = false;
      this.menuOpen = false;
    },

    filtered() {
      return this.items.filter((i) => (this.notifTab === "all" ? true : i.unread));
    },

    markAllRead() {
      this.items = this.items.map((i) => ({ ...i, unread: false }));
      this.unreadCount = 0;
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
