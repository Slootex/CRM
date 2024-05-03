<script>
    function slideInAnimationSideBar() {
        var nav_menu_frontpage              = document.getElementById("nav-menu-frontpage");
        nav_menu_frontpage.style.animation  = "fadeOutLeft .5s forwards";

        var nav_menu                        = document.getElementById("nav-menu");
        nav_menu.style.animation            = "fadeInLeft .5s forwards";
        nav_menu.style.display              = "block";
    }
    function slideOutAnimationSideBar() {
        var nav_menu                        = document.getElementById("nav-menu");
        nav_menu.style.animation            = "fadeOutLeft .5s forwards";

        var nav_menu_frontpage              = document.getElementById("nav-menu-frontpage");
        nav_menu_frontpage.style.animation  = "fadeInLeft .5s forwards";
    }
    var category_1_counter = 0;
    function slideDownAnimationCategory() {
        if(category_1_counter == 0) {
            var main_category                        = document.getElementById("category-menu-1");
            main_category.style.display              = "block";
            main_category.style.animation            = "fadeInDown 1s forwards";
            category_1_counter                       = 1;
        } else {
            var main_category                        = document.getElementById("category-menu-1");
            main_category.style.display              = "none";
            main_category.style.animation            = "fadeOutUp 1s forwards";
            category_1_counter                       = 0;
        }
        
        
    }
</script>
<div id="wrapper" class="mt-0 absolute">
    <div class="ml-0 pt-5 pl-5 text-center float-left" onclick="slideInAnimationSideBar()" id="nav-menu-frontpage">
        <div class="bg-black h-2 w-12 rounded-lg"></div>
        <div class="bg-black h-2 w-12 rounded-lg mt-2"></div>
        <div class="bg-black h-2 w-12 rounded-lg mt-2"></div>
    </div>
    <div class="ml-0 h-screen bg-blue-400 w-72 sm:w-70 rounded-br-xl hidden absolute" id="nav-menu">
        <div class="mr-0 pt-5 pr-5 text-center float-right" onclick="slideOutAnimationSideBar()">
            <div class="bg-white h-2 w-12 rounded-lg"></div>
            <div class="bg-white h-2 w-12 rounded-lg mt-2"></div>
            <div class="bg-white h-2 w-12 rounded-lg mt-2"></div>
        </div>
        <div class="drop-shadow-xl mt-24 ml-6 px-16 py-1 float-left rounded-md bg-blue-600 hover:bg-blue-500">
            <h1 class=" text-center text-3xl text-white font-thin" onclick="window.location.href = '{{url('/')}}/employee/orders'">Aufträge</h1>
        </div>
        <div class="drop-shadow-xl mt-14 ml-7 px-8 py-1 float-left rounded-md bg-blue-600 hover:bg-blue-500">
            <h1 class=" text-center text-3xl text-white font-thin">Interessenten</h1>
        </div>
        <div class="drop-shadow-xl mt-14 ml-7 px-16 py-1 float-left rounded-md bg-blue-600 hover:bg-blue-500">
            <h1 class=" text-center text-3xl text-white font-thin">Versand</h1>
        </div>
        <div class="drop-shadow-xl mt-14 mb-10 ml-7 px-8 py-1 float-left rounded-md bg-blue-600 hover:bg-blue-500">
            <h1 class=" text-center text-3xl text-white font-thin">Einstellungen</h1>
        </div>  
        <div class="drop-shadow-xl mt-80 ml-2 px-8 py-1 float-left rounded-md">
            <h1 class=" text-center text-3xl text-white font-thin">Help <span>- Support</span></h1>
        </div>  
    </div>
</div>