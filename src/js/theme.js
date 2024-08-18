
//Jquery no-conflict mode
( function( $ ) {

    $(document).ready( () => {

        //Events tigger
        window.onresize = setNavOnLoad;
        window.onscroll = showFixedNavbar;

        /**
         * Set primary padding height nav based
         */
        let adminBar = document.getElementById('wpadminbar');
        if(adminBar){
            var adminBarHeight = adminBar.clientHeight;
        }
        const wpBody = document.getElementById('primary');
        const navBar = document.getElementById('masthead');
        if(navBar){
            var navBarHeight = navBar.clientHeight;
        }
        wpBody.style.paddingTop = navBarHeight + 'px';
        if(adminBar){
            navBar.style.marginTop = adminBarHeight + 'px';    
        }

        //Recalculate on window resize
        function setNavOnLoad() {
            if(adminBarHeight){
                adminBarHeight = adminBar.clientHeight;
            }
            wpBody.style.paddingTop = navBarHeight + 'px';
            navBar.style.marginTop = adminBarHeight + 'px';
        }

        /**
         * Fix navbar on scroll
         */
        function showFixedNavbar(){
            pageScroll = window.scrollY;
            //console.log(pageScroll);
            navBar.classList.toggle('has-fixed', pageScroll > 140);
        }
        
        /**
         * Menu open button
         */
        var toggleButton = document.getElementById("toggle-btn");
        toggleButton.addEventListener("click", changeVisiblility, false);
        function changeVisiblility(e) {
            e.preventDefault();
            document.getElementById("main-menu").classList.toggle('show-element');
        }

        //Open Submenus function
        if($(".menu-item-has-children").length){
            $(".menu-item-has-children").on( "click", function(){
                $(".sub-menu").toggleClass("show-element");
            });
        }

    } );

} (jQuery) );