(function () {
  'use strict';

  // Ambil elemen switch untuk mode gelap
  var toggleSwitch = document.getElementById('darkSwitch');
  var currentTheme = localStorage.getItem('theme');
  var logoImage = document.getElementById("logoImage");
  var cartCount = document.getElementById("cartCount"); // Ambil elemen jumlah keranjang

  function updateLogo(theme) {
    if (!logoImage) return;
    var lightLogo = logoImage.getAttribute("data-light");
    var darkLogo = logoImage.getAttribute("data-dark");
    logoImage.src = theme === "dark" ? darkLogo : lightLogo;
  }

  function updateCartColor(theme) {
    if (!cartCount) return;
    cartCount.style.color = theme === "dark" ? "yellow" : "red"; // Ubah warna berdasarkan tema
  }

  if (currentTheme) {
    document.documentElement.setAttribute('theme-color', currentTheme);
    if (toggleSwitch) {
      toggleSwitch.checked = currentTheme === 'dark';
    }
    updateLogo(currentTheme);
    updateCartColor(currentTheme); // Update warna saat halaman dimuat
  }

  function switchTheme(e) {
    var newTheme = e.target.checked ? "dark" : "light";
    document.documentElement.setAttribute("theme-color", newTheme);
    localStorage.setItem("theme", newTheme);
    updateLogo(newTheme);
    updateCartColor(newTheme);
  }

  if (toggleSwitch) {
    toggleSwitch.addEventListener("change", switchTheme, false);
  }

  // Mode RTL
  var rtltoggleSwitch = document.getElementById("rtlSwitch");
  var rtlcurrentTheme = localStorage.getItem("view");

  if (rtlcurrentTheme) {
    document.documentElement.setAttribute("view-mode", rtlcurrentTheme);
    if (rtltoggleSwitch) {
      rtltoggleSwitch.checked = rtlcurrentTheme === "rtl";
    }
  }

  function rtlswitchTheme(e) {
    var newView = e.target.checked ? "rtl" : "ltr";
    document.documentElement.setAttribute("view-mode", newView);
    localStorage.setItem("view", newView);
  }

  if (rtltoggleSwitch) {
    rtltoggleSwitch.addEventListener("change", rtlswitchTheme, false);
  }

})();
