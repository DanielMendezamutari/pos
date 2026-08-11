let enterPress = false;

function initLector(field) {
  const jqInput = $(field);

  noty({
    text  : "<b>F2:</b> Activa el foco en el buscador para lector de codigo de barras",
    layout: "topRight",
    type  : "success", timeout: 5000, progressBar: true
  });

  jqInput.keydown(function (e) {
    console.log("presionado key");
    if (e.keyCode === 13) {
      enterPress = true;
      e.preventDefault();
    }
  });
  document.onkeyup = function (e) {
    if (e.key === "F2") {
      jqInput.val("").focus();
      enterPress = false;
    }
  };
}
