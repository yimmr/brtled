window.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll(".wp-block-brtled-taxonomy-nav a").forEach((function(t){t.getAttribute("href")==location.hash&&t.parentElement.classList.add("active"),t.addEventListener("click",(function(){document.querySelectorAll(".wp-block-brtled-taxonomy-nav li").forEach((function(t){t.classList.remove("active")})),this.parentElement.classList.add("active")}))})),window.location.hash||document.querySelector(".wp-block-brtled-taxonomy-nav li.active a")?.click()}));