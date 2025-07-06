// Script para simular una API REST básica
// No tiene medidas de seguridad adecuadas (a propósito)

$(document).ready(function () {
  // Simular conexión a API
  function loadUserData(userId) {
    $.ajax({
      url: "api/user.php?user_id=" + userId,
      dataType: "json",
      success: function (data) {
        console.log("Datos de usuario cargados:", data);
        // Procesamiento de datos
      },
      error: function (xhr, status, error) {
        console.error("Error al cargar datos:", error);
      },
    });
  }

  // Exponer función globalmente (mala práctica de seguridad a propósito)
  window.loadUserData = loadUserData;

  // Función vulnerable a XSS
  function displayUserComment(commentHtml) {
    // Inserta HTML sin sanitizar (vulnerable a propósito)
    $("#comments-container").append(commentHtml);
  }

  // Exponer función vulnerable globalmente
  window.displayUserComment = displayUserComment;
});

// Credenciales hardcodeadas (mala práctica a propósito)
const apiKey = "1a2b3c4d5e6f7g8h9i0j";
const adminToken =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJhZG1pbiIsIm5hbWUiOiJBZG1pbmlzdHJhdG9yIiwicm9sZSI6ImFkbWluIn0";
