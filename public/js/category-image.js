jQuery(document).ready((function(e){var t;e(".upload_image_button").on("click",(function(a){a.preventDefault(),console.log("Botón de selección de imagen clicado");var n=e(this);t||(t=wp.media({title:"Seleccionar imagen destacada",button:{text:"Usar esta imagen"},multiple:!1})).on("select",(function(){var e=t.state().get("selection").first().toJSON();n.parent().find("#term_image").val(e.url),n.parent().find("#term-image-preview img").attr("src",e.url)})),t.open()})),e(".remove_image_button").on("click",(function(t){t.preventDefault();var a=e(this);a.parent().find("#term_image").val(""),a.parent().find("#term-image-preview img").attr("src","")}))}));