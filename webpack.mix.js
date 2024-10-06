const mix = require('laravel-mix');
const tailwindcss = require("tailwindcss");


mix.sass("./src/css/theme.sass", "./style.css")
.js("./src/js/theme.js", "./public/js/theme.js")
.js("./src/js/customizer.js", "./public/js/customizer.js")
.js("./src/js/navigation.js", "./public/js/navigation.js")
.js("./src/js/category-image.js", "./public/js/category-image.js")
.js("./src/js/meta-box-image.js", "./public/js/meta-box-image.js")
.copyDirectory("./src/imgs/", "./public/imgs/")
.copyDirectory("./src/fonts/", "./public/fonts/")
.options({
	processCssUrls: false,
	postCss: [tailwindcss("./tailwind.config.js")]
});