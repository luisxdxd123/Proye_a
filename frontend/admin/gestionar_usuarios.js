document.addEventListener("DOMContentLoaded", () => {
    const btnAgregar = document.getElementById("btnAgregar");
    const btnEliminar = document.getElementById("btnEliminar");
    const btnModificar = document.getElementById("btnModificar");
  
    const modalAgregar = document.getElementById("modalAgregar");
    const modalEliminar = document.getElementById("modalEliminar");
    const modalModificar = document.getElementById("modalModificar");
  
    const btnsCancelar = document.querySelectorAll(".btnCancelar");
  
    btnAgregar.addEventListener("click", () => {
      modalAgregar.style.display = "flex";
    });
  
    btnEliminar.addEventListener("click", () => {
      modalEliminar.style.display = "flex";
    });
  
    btnModificar.addEventListener("click", () => {
      modalModificar.style.display = "flex";
    });
  
    btnsCancelar.forEach(btn => {
      btn.addEventListener("click", () => {
        modalAgregar.style.display = "none";
        modalEliminar.style.display = "none";
        modalModificar.style.display = "none";
      });
    });
  
    window.onclick = function(event) {
      if (event.target === modalAgregar) modalAgregar.style.display = "none";
      if (event.target === modalEliminar) modalEliminar.style.display = "none";
      if (event.target === modalModificar) modalModificar.style.display = "none";
    };
  });