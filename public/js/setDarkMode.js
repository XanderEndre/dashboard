// Function to toggle dark mode

function toggleDarkMode() {
  let darkModePreference = localStorage.getItem("warehouse-dark-mode");

  // If it's currently on or system prefers dark, turn it off. Otherwise, turn it on.
  if (darkModePreference === "on" || (darkModePreference === "system" && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
    document.documentElement.classList.remove("dark");
    localStorage.setItem("warehouse-dark-mode", "off");
  } else {
    document.documentElement.classList.add("dark");
    localStorage.setItem("warehouse-dark-mode", "on");
  }
}

// Load and set dark mode preference
let darkModePreference = localStorage.getItem("warehouse-dark-mode");

if (darkModePreference === "on") {
  document.documentElement.classList.add("dark");
} else if (darkModePreference === "off") {
  document.documentElement.classList.remove("dark");
} else if (darkModePreference === "system") {
  if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
  }
}

// Add a click event listener to the dark mode toggle button
document.addEventListener('DOMContentLoaded', (event) => {
  const darkModeToggle = document.getElementById('darkModeToggle');
  darkModeToggle.addEventListener('click', function (event) {
    event.stopPropagation();
    toggleDarkMode();

  });
});