window.addEventListener("scroll", () => {
    console.log("waddup");
    document.querySelector("header").setAttribute("style", "background-color: #d6a906ee;")
  }, { once: true });